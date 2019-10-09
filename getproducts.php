<?php
require_once 'include/DB_Functions2.php';
$db = new DB_Functions2();
 
// json response array

 
 $products=array();

 
 
    // receiving the post params
   // $p_name = $_GET['p_name'];
	
    // get the products by p_name and p_brief
    $products = $db->getUser();
	echo $products;
	exit;
	
	
    if ($products == "") {
		
        // use is found
		$response["error"] = TRUE;
        $response["error_msg"] = "Wrong product name and product brief";
        
        echo json_encode($response);
    } else {
		print_r("inelse");
        // products is not found with the credentials
        $response["error"] = FALSE;
        $response["products"] = $products;
        //$response["products"]["p_brief"] = $products["p_brief"];
        echo json_encode($response);
    }
 
?>