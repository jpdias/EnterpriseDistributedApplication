<?php
session_start();
$loginOk = false;

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
        $data = json_decode(CallAPI("GET", "http://localhost:49822/api/funcionarios"), true);

        foreach ($data as $item) {
            $u = $item["username"];
            $p = $item["password"];
            
          if ($u == $username && $p == $password)
              $loginOk = true;
        }
        

    if ($loginOk) {
        $_SESSION['username'] = $_POST['username'];
    } else {
        $_SESSION['error'] = "Credenciais inválidas";
        $_SESSION['u'] = $_POST['username'];

    }

}
else {
    $_SESSION['error'] = "Credenciais em falta";

}

header("location: index.php");








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