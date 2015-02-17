<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Date{

	CONST SEPARADOR = " de ";
	
	static function format($fecha){
		$meses = array("","ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
		$fecha = explode(" ", $fecha);
		$dia = $fecha[0];
		$dia = explode("-",$dia);
		$fechaFormato = $dia[2] . self::SEPARADOR . JText::_( $meses[$dia[1] + 0 ] . "" ) . self::SEPARADOR . $dia[0] . " " . $fecha[1] ;
		return $fechaFormato;
	}
	
	function nombreMes($mes){
		$meses = array("","ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
		return JText::_( $meses[$mes] );
	}
	
	function anoActual(){
		date_default_timezone_set('America/Bogota');
		$fecha = date('Y');
		return $fecha;
	}
	
}








