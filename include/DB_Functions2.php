<?php
 
 
class DB_Functions2 {
 
    private $conn;
 
    // constructor
    function __construct() {
		
		
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
   
     
    public function storeLike($a, $is_like,$p_name) {
			
											
$stmt = $this->conn->prepare("UPDATE products SET likes_count = ? , is_like = ? WHERE p_name = ?");
        $stmt->bind_param("sss",$a, $is_like, $p_name);
        $result = $stmt->execute();
        $stmt->close();
		
		
 
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM products WHERE p_name = ?");
            $stmt->bind_param("s", $p_name);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
				
			
            return $user;
			
        } else {
            return false;
        }
    }
	
	
	public function getLike($p_name)
	{
		$stmt = $this->conn->prepare("SELECT likes_count from products Where p_name = ?");
		$stmt->bind_param("s",$p_name);
		$stmt->execute();
		$count=$stmt->get_result()->fetch_assoc();
		$stmt->close();
			
			return $count;
	}
 
    /**
     * Get user by product_name = p_name
     */
    public function getUser() {
		
		 
		 $response = array("error" => FALSE);
			 $query = "SELECT * FROM products ";

			if ($stmt = $this->conn->prepare($query)) {
				
			/* execute statement */
			$stmt->execute();
			
			/* bind result variables */
			$stmt->bind_result($id, $name, $price, $brief, $image, $info, $likescount, $islike);
			
			/* fetch values */
			while ($stmt->fetch()) 
			{
 
 
 
			$user[]=array("product_name"=> $name,"product_price"=> $price,"product_brief"=> $brief, "product_image"=> $image,"product_info"=> $info, "likes_count"=>$likescount, "is_like"=>$islike);
			//$code[]=$brif;
			
			
			 
				
 
			}
			$response["PRODUCTS"] = $user;
					
					

			//$response["PBRIEF"] = array("CODE"=> $code);
			return json_encode($response);
				//$result=array_merge($user,$code);
				
			/* close statement */
			$stmt->close();
			}
				
				//return $result;
				//return $code;
			/* close connection */
			$this->conn->close();
		 
		 
		 
	
	}
 
    /**
     * Check user is existed or not
     
    public function isUserExisted($p_name) {
        $stmt = $this->conn->prepare("SELECT p_name from users WHERE p_name = ?");
 
        $stmt->bind_param("s", $p_name);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 */
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
	*/
	
	
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
   
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 */
}
 
?>