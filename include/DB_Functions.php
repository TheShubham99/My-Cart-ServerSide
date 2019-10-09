<?php
 
 
class DB_Functions {
 
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
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $uuid, $name, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
		// json response array
$response = array("error" => FALSE);
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
		
		/* bind result variables */
			$stmt->bind_result($id ,$uid, $name, $email2, $e_password, $salt, $created_at, $updated_at);
			
			
           /* fetch values */
			while ($stmt->fetch()) 
			{
 
 
 
			$user[]=array('unique_id'=> $uid, 'name'=> $name, 'email'=> $email2, 'encrypted_password'=>$e_password ,'salt'=>$salt ,'created_at'=> $created_at,'updated_at'=> $updated_at);
			
				
				
			}
 
				$stmt->close();
            // verifying user password
           // $salt = $user['salt'];
            //$encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
			
			
            // check for password equality
            if ($e_password == $hash) {
				
                // user authentication details are correct
				
             //   return $user;
				 $response["error"] = FALSE;
        $response["uid"] = $user[0]['unique_id'];
        $response["user"]["name"] = $user[0]['name'];
        $response["user"]["email"] = $user[0]['email'];
        $response["user"]["created_at"] = $user[0]['created_at'];
        $response["user"]["updated_at"] = $user[0]['updated_at'];
        echo json_encode($response);
		exit;
            }
        
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
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
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
}
 
?>