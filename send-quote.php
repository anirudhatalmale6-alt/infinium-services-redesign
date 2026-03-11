<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

$to = 'info@infiniumservices.ca';
$subject = 'New Quote Request — Infinium Services Website';

$body = "You have a new quote request from your website:\n\n";
$body .= "==============================\n";
if (!empty($data['name']))    $body .= "Name:         " . $data['name'] . "\n";
if (!empty($data['phone']))   $body .= "Phone:        " . $data['phone'] . "\n";
if (!empty($data['email']))   $body .= "Email:        " . $data['email'] . "\n";
if (!empty($data['city']))    $body .= "City/Area:    " . $data['city'] . "\n";
if (!empty($data['service'])) $body .= "Service:      " . $data['service'] . "\n";
if (!empty($data['size']))    $body .= "Home Size:    " . $data['size'] . "\n";
if (!empty($data['type']))    $body .= "Home Type:    " . $data['type'] . "\n";
if (!empty($data['date']))    $body .= "Pref. Date:   " . $data['date'] . "\n";
if (!empty($data['time']))    $body .= "Pref. Time:   " . $data['time'] . "\n";
if (!empty($data['notes']))   $body .= "Notes:        " . $data['notes'] . "\n";
$body .= "==============================\n\n";
$body .= "Reply to this customer as soon as possible!\n";
$body .= "— Infinium Services Website\n";

$headers = "From: Infinium Services <info@infiniumservices.ca>\r\n";
$headers .= "Reply-To: " . (!empty($data['email']) ? $data['email'] : 'info@infiniumservices.ca') . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Email sent']);
} else {
    echo json_encode(['success' => false, 'message' => 'Email failed']);
}
?>
