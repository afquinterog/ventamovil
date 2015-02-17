<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class WebServices{

	//private static $tabla = "#__zlog";
	
	
	public static function consultarInformacionCedula($cedula){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 $result = $client->consultarInformacionCedula($cedula);
		 return $result;
	
	}
	
	
	public static function consultarInformacionDireccion($idDireccion){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 $result = $client->consultarInformacionDireccion($idDireccion);
		 return $result;
		//print_r($result);
		//exit;
	}
	
	
	public static function consultarDireccionServicio($servicio){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 $result = $client->consultarDireccionServicio($servicio);
		 return $result;
		//print_r($result);
		//exit;
	}
	
	
	
	public static function consultarScoring($cedula){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 $result = $client->consultarScoring($cedula);
		 return $result;
		 // Retorna N no hay datos
		 // Retorna vacio esta bien
		 // Retorna datos separados con | tiene deudas pendientes
		 
		//print_r($result);
		//exit;
	}
	
	public static function consultarServAdicPaq($param){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 $result = $client->consultarServAdicPaq($param);
		 return $result;
	}
	
	public static function consultarOfertasCliente($iMpio, $iEstrato, $iVlrsAct, $iProdsAct, $iMinAct, $iVelAct, $iVlrsAdiAct, $idGrpMpio, $idGrpOferta, 											   $tarifaPaq ){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 
		 /*echo  $iMpio       . " - " .  
		       $iEstrato    . " - " .
		       $iVlrsAct    . " - " .
		       $iProdsAct   . " - " .
		       $iMinAct     . " - " .
		       $iVelAct     . " - " .
		       $iVlrsAdiAct . " - " .
		       $idGrpMpio   . " - " .
		       $idGrpOferta . " - " .
		       $tarifaPaq  ;*/
	    //exit;
			   
		 $result = $client->consultarOfertaClientes( $iMpio      , 
													 $iEstrato   , 
													 $iVlrsAct   , 
													 $iProdsAct  , 
													 $iMinAct    , 
													 $iVelAct    , 
													 $iVlrsAdiAct, 
													 $idGrpMpio  , 
													 $idGrpOferta, 
													 $tarifaPaq  );
		 return $result;
	}
	
	
	
	public static function consultarServAdicOferta( $idOferta, $iMunicipio, $iEstrato, $iValoresActuales, $iProductos, $iVlrAdicActuales, $iMinutos,   
	                                                $iVelocidad  ){
		 $client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		 $result = $client->consultarServAdicOferta( $idOferta, 
													 $iMunicipio, 
													 $iEstrato, 
													 $iValoresActuales, 
													 $iProductos,
													 $iVlrAdicActuales, 
													 $iMinutos, 
													 $iVelocidad );
		 return $result;
	}
	
	
	public static function consultarMinutosOferta($idOferta, $iTipo, $opcion, $iValoresActuales, $iProductos, $minutos, $velocidad){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->consultarMinutosOferta( $idOferta, $iTipo, $opcion, $iValoresActuales, $iProductos, $minutos, $velocidad );
		return $result;
	}
	
	public static function consultarVelocidadOferta($idOferta, $opcion, $iValoresActuales, $iProductos, $minutos, $velocidad ){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->consultarVelocidadOferta( $idOferta, $opcion, $iValoresActuales, $iProductos, $minutos, $velocidad );
		return $result;
	}
	
	public static function getTarifaPlan($iMunicipio, $iEstrato, $tipoProd, $grupoMpio, $codPlan){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->getTarifaPlan( $iMunicipio, $iEstrato, $tipoProd, $grupoMpio, $codPlan );
		return $result;
	}
	
	
	public static function chequearDireccion($idireccion,$ilocalidad,$ibarrio){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->chequearDireccion($idireccion,$ilocalidad,$ibarrio);
		return $result;
	}
	
	public static function insertarDireccion($idireccion,$ilocalidad,$ibarrio){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->insertarDireccion($idireccion,$ilocalidad,$ibarrio);
		return $result;
	}
	
	public static function consultarDireccionPorId($iData){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->consultarDireccionPorId( $iData );
		return $result;
	}
	
	public static function 	getPlanProducto($iProducto){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->getPlanProducto($iProducto);
		return $result;
	}
	
	public static function 	registrarNuevaVenta($iData,$iData2,$iData3,$iData4,$iData5,$iData6){
		ini_set("soap.wsdl_cache_enabled", "0");
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);

		try{
			$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
			$result = $client->registrarNuevaVenta($iData,$iData2,$iData3,$iData4,$iData5,$iData6);
			return $result;
		} catch (SoapFault $fault) {
			print_r($fault);
			trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		}
	}
	
	
	public static function 	getLinAdicAct($iProducto, $cant){
		$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
		$result = $client->getLinAdicAct($iProducto, $cant);
		return $result;
	}
	
	public static function consultarDatosMotivo($motivo){
		ini_set("soap.wsdl_cache_enabled", "0");
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);

		try{
			$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
			$result = $client->consultarDatosMotivo($motivo);
			return $result;
		} catch (SoapFault $fault) {
			print_r($fault);
			trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		}
	}
	
	public static function consultarProdRetenFinan($producto){
		ini_set("soap.wsdl_cache_enabled", "0");
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);

		try{
			$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
			$result = $client->consultarRetenFinan($producto);
			return $result;
		} catch (SoapFault $fault) {
			print_r($fault);
			trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		}
	}
	
	public static function getProdFeIn($producto){
		ini_set("soap.wsdl_cache_enabled", "0");
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);

		try{
			$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
			$result = $client->getFeIn($producto);
			return $result;
		} catch (SoapFault $fault) {
			print_r($fault);
			trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		}
	}
	
	public static function consultarCobertura($idDireccion){
		ini_set("soap.wsdl_cache_enabled", "0");
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);

		try{
			$client = new SoapClient("http://10.4.251.17/etp/ws/ventamovil/ventamovil.php?wsdl");
			$result = $client->getCoberturaDir($idDireccion);
			return $result;
		} catch (SoapFault $fault) {
			print_r($fault);
			trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		}
	}	
}








