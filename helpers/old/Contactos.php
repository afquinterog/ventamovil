<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Contactos{
	
	
	function getContacto($id){
		$db = Configuration::getTiendaDB();

		$tbContacts = $db->nameQuote('#__zcontactos');
		$query = "SELECT 
						* 
				  FROM 
						$tbContacts
				  WHERE 
						id = $id";
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result[0];
	}
	
	
	function lista(){
		$db = Configuration::getTiendaDB();

		$tbContact = $db->nameQuote('#__zcontactos');
		$query = "SELECT 
						id as id, nombre as title
				  FROM 
						$tbContact
				  ORDER BY 
						nombre
						";
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	
	/*function categorias(){
		$db = Configuration::getTiendaDB();

		$tbCategories = $db->nameQuote('#__categories');
		$query = "SELECT 
						* 
				  FROM 
						$tbCategories
				  WHERE 
						published = 1
				  ORDER BY 
						title
						";
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	*/
	
	
}








