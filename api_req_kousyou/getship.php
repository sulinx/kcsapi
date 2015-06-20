<?php
//获得舰娘
include '../config.php';
require "shipdata.php";
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$kdock_id = $_REQUEST["api_kdock_id"] -1;
class req{ 	
	public $api_result=1;
	public $api_result_msg='成功';
	public $api_data;	
}
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT shipnum FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$ship_id = $result[0]+1	;
	$dsn = null;
    $new_ship = '{"api_id":2853,"api_sortno":73,"api_ship_id":36,"api_lv":1,"api_exp":[0,100,0],"api_nowhp":15,"api_maxhp":15,"api_leng":1,"api_slot":[-1,-1,-1,-1,-1],"api_onslot":[0,0,0,0,0],"api_kyouka":[0,0,0,0,0],"api_backs":1,"api_fuel":15,"api_bull":20,"api_slotnum":2,"api_ndock_time":0,"api_ndock_item":[0,0],"api_srate":0,"api_cond":40,"api_karyoku":[12,29],"api_raisou":[27,69],"api_taiku":[14,39],"api_soukou":[6,19],"api_kaihi":[42,79],"api_taisen":[20,49],"api_sakuteki":[5,19],"api_lucky":[10,49],"api_locked":0,"api_locked_equip":0}';
    $new_ship = json_decode($new_ship);
	$new_ship->api_id = $ship_id ;
	}
	
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_kdock FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj0 = json_decode($result[0]);   
	$data = $obj0[$kdock_id];	
	$api_id =$data->api_created_ship_id;
	echo "$api_id ";
	for ($i=0;$i<=365;$i++){
		if($shipdata["$i"]["api_id"]==$api_id){
			$api_sortno=$shipdata["$i"]["api_sortno"];
			echo $shipdata["$i"]["api_id"];
			echo "$api_sortno";
			break;
		}
	}
	$new_ship->api_ship_id = $api_id ;
	$new_ship->api_sortno = $api_sortno ;
	$data->api_state = 0;
	$data->api_complete_time=0;
	$data->api_complete_time_str=0;
    $data->api_created_ship_id=0;	
    $data->api_item1=0;
    $data->api_item2=0;		
	$data->api_item3=0;	
	$data->api_item4=0;
	$data->api_item5=1;
	$obj0[$kdock_id] = $data;
	$req0 = json_encode($obj0);	
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_taik,api_souk,api_houg,api_raig,api_tyku,api_luck,api_leng,api_maxeq,api_backs,api_fuel_max,api_bull_max,api_slot_num FROM shipdata where api_sortno = $api_sortno");
    $stmt->execute();
    // 设置结果集为关联数组		
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll();	
	$res = $result[0];    	
	$new_ship->api_nowhp = (int)json_decode($res[api_taik])[0] ;	
	$new_ship->api_maxhp = (int)json_decode($res[api_taik])[0] ;
	$new_ship->api_leng = (int)$res[api_leng] ;
	$new_ship->api_onslot = json_decode($res[api_maxeq]);
	$new_ship->api_backs = (int)$res[api_backs] ;
	$new_ship->api_fuel = (int)$res[api_fuel_max] ;
	$new_ship->api_bull = (int)$res[api_bull_max] ;
	$new_ship->api_slotnum = (int)$res[api_slot_num] ;
	$new_ship->api_karyoku = json_decode($res[api_houg]) ;
	$new_ship->api_raisou = json_decode($res[api_raig]) ;
	$new_ship->api_taiku = json_decode($res[api_tyku]) ;
	$new_ship->api_soukou = json_decode($res[api_souk]) ;
	$new_ship->api_taisen = json_decode("[40,99]");	
	$new_ship->api_sakuteki = json_decode("[40,99]") ;	
	$new_ship->api_kaihi = json_decode("[50,99]") ;
    //print_r($new_ship);	
	/* api_slot
    api_kaihi
    api_taisen
    api_sakuteki */	
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_ship FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组		
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll();
	$res = $result[0];	
	$api_ship =json_decode($res["api_ship"]);	
	$api_ship[count($api_ship)] =$new_ship;	
	//var_dump($api_ship);		
	$req1 = json_encode($api_ship);
	//echo "svdata=$req1";		
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null;

$sql = "UPDATE userdata set api_kdock='$req0',api_ship='$req1',shipnum='$ship_id'
where uid=$uid1";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // use exec() because no results are returned
    $conn->exec($sql);
    //echo 'svdata={"api_result":1,"api_result_msg":"\u6210\u529f"}';
    $req3 = new req();
	$req3->api_data["api_id"] =$ship_id;
	$req3->api_data["api_ship_id"] =$new_ship->api_ship_id;
	$req3->api_data["api_kdock"]=$obj0;
	$req3->api_data["api_ship"] =$new_ship;
    $req3->api_data["api_slotitem"] = null;
	$req3 = json_encode($req3);	
	echo "svdata=$req3";
	}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

?>
