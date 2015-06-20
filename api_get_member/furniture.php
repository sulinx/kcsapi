<?php
//家具
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
    $stmt = $conn->prepare("SELECT api_id,api_type,api_no FROM furniture where 1");
    $stmt->execute();    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	$result = $stmt->fetchAll();
	$req = new req();
	for ($i=0;$i<=count($result)-1;$i++){
		$req->api_data[$i]->api_member_id=19053956;
		$req->api_data[$i]->api_id=(int)$result[$i]["api_id"];
		$req->api_data[$i]->api_furniture_type=(int)$result[$i]["api_type"];
		$req->api_data[$i]->api_furniture_no=(int)$result[$i]["api_no"];
		$req->api_data[$i]->api_furniture_id=(int)$result[$i]["api_id"];		
	}	
	$json=json_encode($req);
	echo "svdata=$json"; 
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

?>