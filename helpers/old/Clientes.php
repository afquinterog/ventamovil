<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Clientes{
	
	
	function lista(){
		$db = Configuration::getTiendaDB();
		$tbUsers = $db->nameQuote('#__users');
		$query = "SELECT 
						* 
				  FROM 
						$tbUsers 
				 ";
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function getUsuarioById($id){
		$db = Configuration::getTiendaDB();
		$tbUsers = $db->nameQuote('#__users');
		$query = "SELECT 
						* 
				  FROM 
						$tbUsers 
				  where
					id = %s
				 ";
				 
		$query = sprintf($query, $id);
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result[0];
	}
}








