<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Contenidos{
	
	
	function getContenido($id){
		$db = Configuration::getTiendaDB();

		$tbContent = $db->nameQuote('#__content');
		$query = "SELECT 
						* 
				  FROM 
						$tbContent
				  WHERE 
						id = $id";
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result[0];
	}
	
	function getCategoria($id){
		$db = Configuration::getTiendaDB();

		$tbCategories = $db->nameQuote('#__categories');
		$query = "SELECT 
						* 
				  FROM 
						$tbCategories
				  WHERE 
						id = $id";
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result[0];
	}
	
	
	function lista(){
		$db = Configuration::getTiendaDB();

		$tbContent = $db->nameQuote('#__content');
		$query = "SELECT 
						* 
				  FROM 
						$tbContent
				  WHERE 
						state = 1
				  ORDER BY 
						title
						";
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function categorias(){
		$db = Configuration::getTiendaDB();

		$tbCategories = $db->nameQuote('#__categories');
		$query = "SELECT 
						* 
				  FROM 
						$tbCategories
				  WHERE 
						published = 1 AND
						extension = 'com_content'
				  ORDER BY 
						title
						";
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	
	
}








