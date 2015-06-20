<?php
// 装备拆解
include '../config.php';
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$api_slotitem_ids =$_REQUEST["api_slotitem_ids"];
$api_slotitem_ids =explode(',',$api_slotitem_ids);

function delete($api_id,$obj){
	for ($i=0;$i<=count($obj)-1;$i++){		
		if($obj[$i]->api_id==$api_id){
        $a[]=$obj[$i]->api_slotitem_id;			
		if($i == 0){
			array_shift($obj);
		}
        else if($i == count($obj)-1 ){
			array_pop($obj);
		}
        else{
			for($j=$i;$j<=count($obj)-2;$j++){
				
				$obj[$j]=$obj[$j+1];
				array_pop($obj);
			}
		}						
		}
	}
    $a[] = $obj;	
	return $a;
}
function sql($id){	
	$servername = "localhost";
$username = "kancolleadmin";
$password = "?AloDp.W7M=)";
$dbname = "kancolle";
	try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_broken FROM slotitem where api_id =$id");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);
    //print_r($obj);
	return $obj;
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null;
}
//echo "$uid $api_ship_id $api_id $api_ship_idx";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT slot_item FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);
    foreach($api_slotitem_ids as $x=>$x_value)
{
$obj=delete($x_value,$obj);
 $ids[]=$obj[0];
$obj=$obj[1];
}
	$res=array(0,0,0,0);
for($j=0;$j<=count($ids)-1;$j++){
	$list[]=sql($ids[$j]);	
	$res[0]=$res[0]+$list[$j][0];
	$res[1]=$res[1]+$list[$j][1];
	$res[2]=$res[2]+$list[$j][2];
	$res[3]=$res[3]+$list[$j][3];
}
    $json = json_encode($obj);	
	$res = json_encode($res);
	//print_r($res); 
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null;

$sql = "UPDATE userdata set slot_item='$json' where uid=$uid1";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // use exec() because no results are returned
    $conn->exec($sql);
    echo 'svdata={"api_result":1,"api_result_msg":"\u6210\u529f","api_data":{"api_get_material":';
	echo $res;
	echo '}}';
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null; 


?>

