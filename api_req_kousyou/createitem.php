<?php
//装备开发
require "slotitem.php";
include '../config.php';
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$api_item1 = $_REQUEST["api_item1"] ;
$api_item2 = $_REQUEST["api_item2"] ;
$api_item3 = $_REQUEST["api_item3"] ;
$api_item4 = $_REQUEST["api_item4"] ;

class req{ 	
	public $api_result=1;
	public $api_result_msg='成功';
	public $api_data;	
}
function getslotid(){
	$slot_id = mt_rand(0,128);
	return $slot_id;
}
$slot_id=getslotid();
$api_type3=json_decode($slotitem[$slot_id]["api_type"])[2];
$slot_id=$slotitem[$slot_id]["api_id"];


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT slotnum FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$api_slot_id = $result[0]+1	;
	$dsn = null;
    $new_slotitem = '{"api_create_flag":1,"api_shizai_flag":1,"api_slot_item":{"api_id":43,"api_slotitem_id":44},"api_material":[99999,99999,99999,99999,999,999,999,999],"api_type3":15,"api_unsetslot":[10,43]}';    
	$new_slotitem = json_decode($new_slotitem);
	$new_slotitem->api_slot_item->api_id = $api_slot_id ;
    $new_slotitem->api_slot_item->api_slotitem_id=(int)$slot_id;
    $new_slotitem->api_type3=$api_type3;	
	try {    
	
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT slot_item FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);	
	$unsetslot=array();
	for($i=0;$i<=count($obj)-1;$i++){
		if($obj[$i]->api_equipped==0){
			for($j=0;$j<=count($slotitem)-1;$j++){
				if($slotitem[$j]["api_id"]==$obj[$i]->api_slotitem_id){
					if($api_type3==json_decode($slotitem[$j]["api_type"])[2]){
						if(is_array($unsetslot)){						
						$coun = count($unsetslot);						
						$unsetslot[$coun]=$obj[$i]->api_id; 						
					    }
					    else{											
						$unsetslot=array($obj[$i]->api_id);
					    }
					}
					
				}				
			}			
		}
	}
    if(is_array($unsetslot)){						
	$coun = count($unsetslot);						
	$unsetslot[$coun]=$api_slot_id ; 						
	}
	else{											
	$unsetslot=array($api_slot_id);
	} 
    $new_slotitem->api_unsetslot=$unsetslot;	
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

	}
	
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT slot_item FROM userdata where uid = $uid1");
    $stmt->execute();
    $json0='{"api_id":10,"api_slotitem_id":56,"api_locked":0,"api_level":0,"api_equipped":0}';
	$obj = json_decode($json0);
	$obj->api_id = $api_slot_id;
	$obj->api_slotitem_id = $slot_id;
	// 设置结果集为关联数组		
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll();
	$res = $result[0];	
	$api_slot =json_decode($res["slot_item"]);	
	$api_slot[count($api_slot)]=$obj;    	
	//var_dump($api_ship);		
	$req1 = json_encode($api_slot);
	//echo "svdata=$req1";		
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null;



$sql = "UPDATE userdata set slot_item='$req1',slotnum='$api_slot_id'
where uid=$uid1";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // use exec() because no results are returned
    $conn->exec($sql);
    //echo 'svdata={"api_result":1,"api_result_msg":"\u6210\u529f"}';
    $req = new req();			
	$req->api_data=$new_slotitem;
	$req = json_encode($req);
	echo "svdata=$req";
	}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;


?>