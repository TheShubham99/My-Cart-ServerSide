<?php

require_once 'include/DB_Functions2.php';
$db = new DB_Functions2();

$response = array("error" => FALSE);
 
if (isset($_POST['is_like']) && isset($_POST['p_name'])) {
 
 
 
	 
	  $is_like = $_POST['is_like'];
	$p_name = $_POST['p_name'];
   
    
		$count=$db->getLike($p_name);
		
		
		$c=1;
		
		extract($count);
	
//converting array in integer
		
		if($is_like==0)
		{
		$a=$likes_count-1;
		}
		elseif($is_like==1)
		{
		$a=$likes_count+1;
		}
	
		
	  $user = $db->storeLike($a, $is_like, $p_name);
       
            // user stored successfully
            $response["error"] = FALSE;
            $response["likes_count"] = $user["likes_count"];
           
            echo json_encode($response);
		
}
 
?>