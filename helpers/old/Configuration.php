<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Configuration{

	private static $tabla = "#__zconfiguracion";
	
	
	const ENLACES_INFERIORES_INI = 467;
	const PEDIDO_PENDIENTE = 'P';
	const PEDIDO_COMPLETO = 'C';
	const PEDIDO_ENVIADO = 'S';
	
	/*Ruta a las imagenes*/
	public static function rutaImagenes(){
		//$ruta = "components/com_ztadmin/images/";
		$ruta = Configuration::getValue("RUTA_IMAGENES");
		return $ruta;
	}
	
	
	/*Ruta a las imagenes*/
	public static function rutaImagenesTemp(){
		//$ruta = "components/com_ztadmin/images/temp/";
		$ruta = Configuration::getValue("RUTA_IMAGENES_TEMP");
		return $ruta;
	}
	
	/*Ruta a las imagenes*/
	public static function rutaImagenesTienda(){
		//$ruta = "../celured/";
		//$ruta = "http://celured.tusconsultores.com/";
		$ruta = Configuration::getValue("RUTA_IMAGENES_TIENDA_URL");
		return $ruta;
	}
	
	/*Ruta a las imagenes*/
	public static function rutaImagenesTiendaArchivos(){
		//$ruta = "../celured/";
		$ruta = Configuration::getValue("RUTA_IMAGENES_TIENDA_FILES");
		return $ruta;
	}
	
	
	
	
	/**
	* Recupera un valor en la tabla de configuración 
	*/
	public static function getValue($param){
	
		$db = & JFactory::getDBO();
		$tbConfiguracion = $db->nameQuote( Configuration::$tabla );
		
		$query = "
					SELECT
						valor
					FROM 
						$tbConfiguracion
					WHERE
						parametro = '$param'
						";
						
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
	
	/*
	* Actualiza un valor en la tabla de configuracion
	*/
	public static function setValue($param, $value){
		$db = & JFactory::getDBO();
		$tbConfiguracion = $db->nameQuote( Configuration::$tabla );
		
		$query = "
					UPDATE
						$tbConfiguracion
					SET 
						valor = '$value'		
					WHERE
						parametro = '$param'
						";
						
		$db->setQuery($query);
		$result = $db->query();
		return $result;
	}
	
	function getTiendaDB(){
		//Conectar a base de datos tienda
		$option = array(); //prevent problems
	
		
		/*$option['driver']   = 'mysql';            // Database driver name
		$option['host']     = 'celured.db.3386082.hostedresource.com';    // Database host name
		$option['user']     = 'celured';       // User for database authentication
		$option['password'] = 'CeluredSite1!';   		// Password for database authentication
		$option['database'] = 'celured';      // Database name
		$option['prefix']   = 'eucwg_';             // Database prefix (may be empty)
		*/
		
		
		//Local
		
		/*$option['driver']   = 'mysql';            // Database driver name
		$option['host']     = 'localhost';    // Database host name
		$option['user']     = 'root';       // User for database authentication
		$option['password'] = '';   		// Password for database authentication
		$option['database'] = 'celured';      // Database name
		$option['prefix']   = 'eucwg_';             // Database prefix (may be empty)
		*/
		
		//Ajustar BD
		$option['driver']   = 'mysql';  
		$option['host'] = Configuration::getValue("TIENDA_DB_HOST");
		$option['user'] = Configuration::getValue("TIENDA_DB_USER");
		$option['password'] = Configuration::getValue("TIENDA_DB_PASSW");
		$option['database'] = Configuration::getValue("TIENDA_DB_NAME");
		$option['prefix'] = Configuration::getValue("TIENDA_DB_PREFIX");
		
		$db = & JDatabase::getInstance( $option );
		return $db;
	}
		
	
	
	
}








