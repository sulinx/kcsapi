<?php
// 船只解体
$a = "\"";
$uid = $_REQUEST["api_token"] ;
$uid1 = $a.$uid.$a;
$api_ship_id =$_REQUEST["api_ship_id"];
$servername = "localhost";
$username = "kancolleadmin";
$password = "?AloDp.W7M=)";
$dbname = "kancolle";
//echo "$uid $api_ship_id $api_id $api_ship_idx";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT api_ship FROM userdata where uid = $uid1");
    $stmt->execute();
    // 设置结果集为关联数组    
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);  
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 	
	$obj = json_decode($result[0]);
	for ($i=0;$i<=count($obj)-1;$i++){		
		if($obj[$i]->api_id==$api_ship_id){
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
    $json = json_encode($obj);
	$dsn = null;
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
	
$conn = null;
$sql = "UPDATE userdata set api_ship='$json'
where uid=$uid1";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // use exec() because no results are returned
    $conn->exec($sql);
    echo 'svdata={"api_result":1,"api_result_msg":"\u6210\u529f","api_data":{"api_material":[99999,99999,99999,99999]}}';
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;


?>


