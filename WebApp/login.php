<?php
session_start();
$error = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['inputEmail']) || empty($_POST['inputPassword'])) {
        $error = "E-mail ou password inválida!";
    } else {
        $email = $_POST['inputEmail'];
        $password   = $_POST['inputPassword'];
        $codCliente;
        
        $data = json_decode(CallAPI("GET", "http://localhost:46615/StoreService.svc/api/customers"), true);
		
        foreach ($data as $item) {
            $emailFromAPI = $item["Email"];
            $passwordFromAPI = $item["Password"];
            $codClienteFromAPI = $item["Email"];
			$nomeClienteFromAPI = $item["Name"];
            if ($emailFromAPI == $email) {
                if ($passwordFromAPI == $password) {
                    $loginOk = true;
                    $codCliente = $codClienteFromAPI;
					$nomeCliente = $nomeClienteFromAPI;
                }
                else {
                    echo '<script language="javascript">alert("Password errada!")</script>';
                }
            }
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