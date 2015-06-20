<?php
//资源
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$servername = "localhost";
$username = "kancolleadmin";
$password = "?AloDp.W7M=)";
$dbname = "kancolle";
class req{ 	
	public $api_result=1;
	public $api_result_msg='成功';
	public $api_data;	
}
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_material FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);		
	$req = new req();
	$req->api_data=$obj;
	$json=json_encode($req);
	echo "svdata=$json";
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

?>