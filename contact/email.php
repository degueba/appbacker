<?php


header('Content-type: application/json');
 
$errors = '';
 
if(empty($errors))
{
	
	$assunto = $_POST["assunto"];
	$from_name = $_POST["nome"];
	$from_email = $_POST['email'];
	$message = $_POST['msg'];
	
 
	$to_email = 'botelhodeveloper@gmail.com';
	$to_email_cc = 'rbdesigner@hotmail.com';
 
	$contact = "<p><strong>Name:</strong> $from_name</p>
		    <p><strong>Email:</strong> $from_email</p>";
	$content = "<p>$message</p>";
 
	$email_subject = "[AppBacker] $assunto";
	
 
	$email_body = '<html><body>';
	$email_body .= "$contact $content";
	$email_body .= '</body></html>';
 
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "From: $from_name\n";
	$headers .= "Reply-To: $from_email";
 
	if(mail($to_email,$email_subject,$email_body,$headers)){
		$response_array['status'] = 'success';	
		echo json_encode($response_array);
	} else {
		$response_array['status'] = 'error';
	echo json_encode($response_array);
	}
	
 
	

	
} else {
	
}

?>