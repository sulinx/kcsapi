<?php
//require "shipdata.php";
include '../config.php';
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$fuel = $_REQUEST["api_item1"];
$bull = $_REQUEST["api_item2"];
$stel = $_REQUEST["api_item3"];
$Alum = $_REQUEST["api_item4"];
$zicai = $_REQUEST["api_item5"];
$dajian = $_REQUEST["api_large_flag"];
$gaosu = $_REQUEST["api_highspeed"];
$kdock_id = $_REQUEST["api_kdock_id"] -1;

function getshipid($flag,$zicai){
	$servername = "localhost";
$username = "kancolleadmin";
$password = "?AloDp.W7M=)";
$dbname = "kancolle";
	if ($flag ==1){
		if($zicai ==1){
			$ids =array(163,137,138,139,161,70,71,72,74,75,76,77,78,79,81,85,86,89,92,124,125,155,83);
			$id = $ids[mt_rand(0,count($ids)-1)];
			return $id;
		}
		else if ($zicai ==20){
			$ids =array(78,79,85,86,90,91,92,80,110,111,116,120,131,139,143,153,155,163,167,171,83,84);
			$id = $ids[mt_rand(0,count($ids)-1)];
			return $id;
		}
		else if ($zicai ==100){
			$ids = array(91,84,80,110,111,116,131,139,143,153,155,167,171,176,421,441,442,445,446,447,450,424,332);
			$id = $ids[mt_rand(0,count($ids)-1)];
			return $id;
		}
	}
	else{		
		for($i=0;$i<=10;$i++){
			$id = mt_rand(0,231);
			if(($id>=1&&$id<=94)or($id>=106&&$id<=107)or($id == 116)or($id>=118&&$id<=120)or($id>=123&&$id<=128)or($id>=132&&$id<=135)or($id>=164&&$id<=165)or($id>=168&&$id<=170)or($id==205)or($id==231)){
            try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_id FROM shipdata where api_sortno = $id");
    $stmt->execute();
    // 设置结果集为关联数组		
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll();
	$res = $result[0];	
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null; 
			return($res[api_id]);		
			break;	
			}	
			
			
		}
	}
	}
$t=time();
$ship_id=getshipid($dajian,$zicai);
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_buildtime FROM shipdata where api_id = $ship_id");
    $stmt->execute();
    // 设置结果集为关联数组		
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll();
	$buildtime = $result[0][api_buildtime];	
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null; 
$comptime = $t+$buildtime*60;
$date = date("Y-m-d H:i:s",$comptime);
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_kdock FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);    
    $data = $obj[$kdock_id];
	$data->api_created_ship_id=$ship_id;
	$data->api_state=2;
	$data->api_complete_time=$comptime*1000;
	$data->api_complete_time_str=$date;
	$data->api_item1=$fuel;
	$data->api_item2=$bull;
	$data->api_item3=$stel;
	$data->api_item4=$Alum;	
	$data->api_item5=$zicai;
	$obj[$kdock_id] = $data;
	$req = json_encode($obj);	
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

$conn = null;
$sql = "UPDATE userdata set api_kdock='$req'
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

