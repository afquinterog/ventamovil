<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Log{

	private static $tabla = "#__zlog";
	
	
	
	
	/**
	* Recupera un valor en la tabla de configuración 
	*/
	public static function add($msg, $valor, $ant="", $nuevo=""){
	
		$db = & JFactory::getDBO();
		$tbLog = $db->nameQuote( Log::$tabla );
		$user = JFactory::getUser();
		
		$query = "
					INSERT INTO $tbLog(accion, valor, anterior, nuevo, usuario, username, fecha, ip)
					VALUES( '%s', '%s', '%s', '%s' , '%s', '%s', '%s', '%s')
						";
						
		$query = sprintf( $query, $msg, $valor, $ant, $nuevo, $user->id, $user->username, Configuration::getDate() , Configuration::getIp()  );			
		$db->setQuery($query);
		$result = $db->query();
		return $result;
	}
	
	
	
	
	
}








