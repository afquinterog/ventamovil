<?php
include_once('db.php');

$con = conectDB();

//print_r($_POST);
$filter = isset( $_GET["q"] ) ? $_GET["q"] : "";
$filter = str_replace(" ", "", $filter);
//$user = isset($_GET["user"] ) ? $_GET["user"] : "";
$tbarrio = isset($_GET["addData"] ) ? $_GET["addData"] : "" ;

$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
$filter = trim($filter);
//$filter = str_replace(".", " ", $filter);
$result = $client->consultarDireccionAC($filter, $tbarrio, "20");


$result = explode("<fin>", $result);
foreach($result as $data){
	$data = explode("|", $data);
	$autocomplete = new stdClass();
	if( $data[0] != ""  && $data[2] != "" ){
		$autocomplete->id   = utf8_encode( $data[0] );
		//$autocomplete->name = utf8_encode( $data[2]) ."<p style='font-size:9px'>". $data[5] . " " . $data[6] ."</p>"  ;
		$autocomplete->name = utf8_encode( $data[2] )   ;
		$info[] = $autocomplete;
	}
}

echo json_encode($info);

?>

