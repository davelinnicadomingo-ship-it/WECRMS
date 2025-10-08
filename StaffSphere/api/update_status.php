<?php
require_once '../config/database.php';
require_once '../config/session.php';
requireHR();

header('Content-Type: application/json');

$ticket_id = $_POST['ticket_id'] ?? 0;
$status = $_POST['status'] ?? '';
$notes = $_POST['notes'] ?? '';

if ($ticket_id && $status) {
    $db = new Database();
    
    $current_ticket = $db->fetchOne("SELECT status FROM tickets WHERE id = ?", [$ticket_id]);
    
    if ($current_ticket) {
        $old_status = $current_ticket['status'];
        
        $db->query(
            "UPDATE tickets SET status = ?, updated_at = NOW() WHERE id = ?",
            [$status, $ticket_id]
        );
        
        $db->query(
            "INSERT INTO status_history (ticket_id, old_status, new_status, updated_by, notes) VALUES (?, ?, ?, ?, ?)",
            [$ticket_id, $old_status, $status, getUserId(), $notes]
        );
        
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ticket not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}
