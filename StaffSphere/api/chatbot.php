<?php
require_once '../config/database.php';

header('Content-Type: application/json');

$query = $_POST['query'] ?? '';

if ($query) {
    $db = new Database();
    
    $query_lower = strtolower($query);
    
    $responses = $db->fetchAll(
        "SELECT * FROM chatbot_responses WHERE is_active = TRUE AND LOWER(keyword) LIKE ? LIMIT 3",
        ["%$query_lower%"]
    );
    
    if (empty($responses)) {
        $responses = $db->fetchAll(
            "SELECT * FROM chatbot_responses WHERE is_active = TRUE AND (LOWER(question) LIKE ? OR LOWER(response) LIKE ?) LIMIT 3",
            ["%$query_lower%", "%$query_lower%"]
        );
    }
    
    if (!empty($responses)) {
        echo json_encode([
            'success' => true,
            'responses' => array_map(function($r) {
                return [
                    'question' => $r['question'],
                    'response' => $r['response'],
                    'category' => $r['category']
                ];
            }, $responses)
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'responses' => [[
                'question' => 'Need Help?',
                'response' => 'I couldn\'t find a specific answer to your question. Please create a ticket or contact HR directly at hr@company.com for personalized assistance.',
                'category' => 'General'
            ]]
        ]);
    }
} else {
    $db = new Database();
    $popular = $db->fetchAll(
        "SELECT * FROM chatbot_responses WHERE is_active = TRUE ORDER BY RANDOM() LIMIT 5"
    );
    
    echo json_encode([
        'success' => true,
        'responses' => array_map(function($r) {
            return [
                'question' => $r['question'],
                'response' => $r['response'],
                'category' => $r['category']
            ];
        }, $popular)
    ]);
}
