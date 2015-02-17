<?php 
class Session{

	
	/**
	* Obtiene el valor de la variable de la peticion 
	* si no esta definida en la peticion la obtiene de la sesion
	* si esta definida en la peticion la guarda en la sesion
	*
	* La prioridad es la peticion despues la sesion.
	*/
	public static function getVar( $var , $default=NULL ){
		$session = JFactory::getSession();
		$value = JRequest::getVar($var);
		if( (!array_key_exists( $var, JRequest::get('get') ) && !array_key_exists( $var, JRequest::get('post') ) ) ){
			$value = $session->get($var);
			if($value == ""){
				return $default;
			}
		}
		else{
			$session->set($var, $value);
		}
		return $value;
	}
	
	public static function getVarDB($var, $default=NULL){
		$value = Session::getVar($var,$default);
		return mysql_real_escape_string($value);
	}
	
	public static function setVar($var, $value){
		$session =& JFactory::getSession();
		$session->set($var, $value);
	}
	
	public static function mensajeOk($msg){
		echo "<p class='gkTips1'>{$msg}</p>";
	}
	
	public static function mensajeNOk($msg){
		echo "<p class='gkWarning1'>{$msg}</p>";
	}
	

	
}








