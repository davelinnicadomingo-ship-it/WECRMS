<?php
require_once '../config/database.php';
require_once '../config/session.php';
requireHR();

header('Content-Type: application/json');

$ticket_id = $_POST['ticket_id'] ?? 0;
$assigned_to = $_POST['assigned_to'] ?? null;

if ($ticket_id) {
    $db = new Database();
    
    $db->query(
        "UPDATE tickets SET assigned_to = ?, updated_at = NOW() WHERE id = ?",
        [$assigned_to, $ticket_id]
    );
    
    echo json_encode(['success' => true, 'message' => 'Ticket assigned successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ticket ID']);
}
