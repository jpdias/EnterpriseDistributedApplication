<?php
session_start();
$error = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['inputEmail']) || empty($_POST['inputPassword'])) {
        $error = "Invalid e-mail or password!";
    } else {
        $email = $_POST['inputEmail'];
        $password  = $_POST['inputPassword'];
        $codCliente;
        
		$data = array(
			"Email" => $email,
			"Password" => $password
		);
		
        $login = json_decode(CallAPI("POST", "http://localhost:46615/StoreService.svc/api/login", json_encode($data)), true);
		
		if ($login == 1)
		{
			$loginOk = true;
			
			$customer = json_decode(CallAPI("GET", "http://localhost:46615/StoreService.svc/api/customer/joao@mail.com"), true);
		
			$codCliente = $email;
			$nomeCliente = $customer["Name"];
		}
		else
		{
			echo '<script language="javascript">alert("Wrong password!")</script>';
		}
        
        if (isset($loginOk)) {
            $_SESSION['codCliente'] = $codCliente;
			$_SESSION['nomeCliente'] = $nomeCliente;
            header("location: profile.php?codCliente=$codCliente");
        }
    }
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    $result = curl_exec($curl);
    
    curl_close($curl);
    
    return $result;
}

?>