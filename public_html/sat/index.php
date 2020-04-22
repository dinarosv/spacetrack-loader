<?php
ini_set('display_errors', 1);
header('Content-Type: application/json');

$file = NULL;
$noradId = NULL;

if (isset($_GET["FILE"])) {
	$file = htmlspecialchars($_GET["FILE"]);
}
if (isset($_GET["ID"])) {
	$noradId = htmlspecialchars($_GET["ID"]);
}

$filestream = fopen("../satellitedata.json", "r") or die("Unable to open file!");
$data = json_decode(fread($filestream, filesize("../satellitedata.json")));

$jsonarray = array();
if ($file){
	foreach ($data as $key => $value){
		if ($value->FILE > $file){
			$jsonarray[$value->NORAD_CAT_ID] = $value;
		}
	}
} else if ($noradId){
	if (array_key_exists($noradId, get_object_vars($data))){
		$jsonarray[$noradId] = $data->$noradId;
	} else {
		http_response_code(400);
		die("ID not found");
	}
} else {
	foreach ($data as $key => $value){
		if ($value->DECAYED == 0){
			$jsonarray[$value->NORAD_CAT_ID] = $value;
		}
	}
}
if (empty($jsonarray)) {
	echo '{}';
} else {
	echo json_encode($jsonarray);
}
fclose($filestream);
?>