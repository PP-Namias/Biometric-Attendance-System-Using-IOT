<?php  

$email = $_POST['email'];

$token = bin2hex(random_bytes(32));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s",time() + 60*30);


$conn = require __DIR__ . "/connectDB.php";

$sql = "UPDATE admin SET reset_token_hash = ?, reset_token_expires_at = ? WHERE admin_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);


$stmt->execute();

if ($conn->affected_rows > 0) {
	$mail = require 'mailer.php';
	$mail->setFrom("Mailer@example.com");
	$mail->addAddress($email);
	$mail->Subject = "Password Reset";
	$mail->Body = <<<END
	
	Click the link to reset your password: http://localhost/Biometric-Attendance-System-Using-IOT/BiometricAttendanceSystem/new_pass.php?token=$token

	END;

	try {

		$mail->send();
		echo "Password reset link sent to your email";


	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}


}