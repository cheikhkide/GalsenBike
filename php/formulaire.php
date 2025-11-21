<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$nom = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$messageForm = $_POST['message'] ?? '';

if (empty($nom) || empty($email) || empty($messageForm)) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs']);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'cheikhkide2002@gmail.com';
    $mail->Password   = 'orgtqglinctltxra';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('cheikhkide2002@gmail.com', 'cheikhkide');
    $mail->addAddress('cheikhkide2002@gmail.com'); 

    $mail->isHTML(true);
    $mail->Subject = "Nouveau message de $nom";
    $mail->Body    = "<b>Nom :</b> $nom<br><b>Email :</b> $email<br><b>Message :</b><br>$messageForm";

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Message envoyé avec succès !']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur PHPMailer : ' . $mail->ErrorInfo]);
}
?>