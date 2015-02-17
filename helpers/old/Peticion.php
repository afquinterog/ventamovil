<?php 
class Peticion{

	
	/**
	* Obtiene el valor de la variabla en la peticion actual de manera segura para la base de datos
	*
	*/
	public static function getVar( $var , $default=NULL ){
		$value = JRequest::getVar( $var );
		$value = mysql_real_escape_string( $value );
		return $value;
	}
	
}








