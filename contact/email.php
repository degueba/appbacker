<?php

// ENVIO DE SMS
	function requisicaoApi($params, $endpoint){
		$url = "http://api.directcallsoft.com/{$endpoint}";
		$data = http_build_query($params);
		$ch =   curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($ch);
		curl_close($ch);
		// Converte os dados de JSON para ARRAY<
		$dados = json_decode($return, true);
		return $dados;
    }


header('Content-type: application/json');
 
$errors = '';
 
if(empty($errors))
{
	
	$assunto = $_POST["assunto"];
	$from_name = $_POST["nome"];
	$from_email = $_POST['email'];
	$message = $_POST['msg'];


	// CLIENT_ID que é fornecido pela DirectCall (Seu e-mail)
	$client_id = "rbdesigner@hotmail.com";
	// CLIENT_SECRET que é fornecido pela DirectCall (Código recebido por SMS)
	$client_secret = "7318123";
	// Faz a requisicao do access_token
	$req = requisicaoApi(array('client_id'=>$client_id, 'client_secret'=>$client_secret), "request_token");
	//Seta uma variavel com o access_token
	$access_token = $req['access_token'];

print_r($access_token);

	// send sms
	$SMS = "Contato de: {$from_name} - <{$from_email}> - {$message}";
	// Array com os parametros para o envio
	$data = array(
		'origem'=>"5521982402706", // Seu numero que é origem
		'destino'=>"5521982402706", // E o numero de destino
		'tipo'=>"texto",
		'access_token'=>$access_token,
		'texto'=>$SMS
	);
	// realiza o envio
	$req_sms = requisicaoApi($data, "sms/send");
	
 
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