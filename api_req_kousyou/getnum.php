<?php
require "shipdata.php";
$api_id = 35;
for ($i=0;$i<=365;$i++){
		if($shipdata["$i"]["api_id"]==$api_id){
			$api_sortno=$shipdata["$i"]["api_sortno"];
			echo $shipdata["$i"]["api_id"];
			echo "$api_sortno";
			break;
		}
	}
?>