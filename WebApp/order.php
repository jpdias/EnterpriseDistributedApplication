<?php

if (isset($_GET['customerId']) || isset($_GET['bookId']) || isset($_GET['quantity']))
{
	$customerId = $_GET['customerId'];
	$bookId = $_GET['bookId'];
	$quantity = $_GET['quantity'];
	
	$customer = json_decode(CallAPI("GET", "http://localhost:46615/StoreService.svc/api/customer/" . $customerId), true);
	
	$customerData = array(
		"_id" => $customer["_id"],
		"Email" => $customer["Email"],
		"Name" => $customer["Name"],
		"Address" => $customer["Address"],
		"Password" => $customer["Password"]
	);
	
	$book = json_decode(CallAPI("GET", "http://localhost:46615/StoreService.svc/api/book/" . $bookId), true);
	
	$bookData = array(
		"_id" => $book["_id"],
		"Title" => $book["Title"],
		"Price" => $book["Price"],
		"Editor" => $book["Editor"],
		"Stock" => $book["Stock"]
	);
	
	$data = array(
		"Book" => $bookData,
		"Quantity" => $quantity,
		"Customer" => $customerData
	);
	
	$order = json_decode(CallAPI("POST", "http://localhost:46615/StoreService.svc/api/order", json_encode($data)), true);
	
	if (isset($order))
	{
		echo '<script language="javascript">alert("Order made successfully!")</script>';
			
		echo '<script language="javascript">window.location = "catalog.php?id=' . $customer["_id"] . '"</script>';
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