<?php
//家具更换
require "furnituredata.php";
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$api_floor = $_REQUEST["api_floor"] ;
$api_wallpaper = $_REQUEST["api_wallpaper"] ;
$api_wallhanging = $_REQUEST["api_wallhanging"] ;
$api_window = $_REQUEST["api_window"] ;
$api_shelf = $_REQUEST["api_shelf"] ;
$api_desk = $_REQUEST["api_desk"] ;
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
    $stmt = $conn->prepare("SELECT api_basic FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);
    $obj->api_furniture[0]=$api_floor;
	$obj->api_furniture[1]=$api_wallpaper;
    $obj->api_furniture[2]=$api_window;
    $obj->api_furniture[3]=$api_wallhanging;
    $obj->api_furniture[4]=$api_shelf;
    $obj->api_furniture[5]=$api_desk;	
	$json=json_encode($obj);    
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
$sql = "UPDATE userdata set api_basic='$json'
where uid=$uid1";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // use exec() because no results are returned
    $conn->exec($sql);
    echo 'svdata={"api_result":1,"api_result_msg":"\u6210\u529f"}';
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

?>