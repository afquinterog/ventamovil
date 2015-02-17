<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Productos{
	
	
	function getCategoria($id){
		$db = Configuration::getTiendaDB();

		$tbCategories = $db->nameQuote('#__virtuemart_categories_es_es');
		$query = "SELECT 
						* 
				  FROM 
						$tbCategories 
				  WHERE 
						virtuemart_category_id = $id";
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result[0];
	}
	
	function categorias(){
		$db = Configuration::getTiendaDB();

		$tbCategories = $db->nameQuote('#__virtuemart_categories_es_es');
		$query = "SELECT 
						virtuemart_category_id as id,  
						category_name as title
				  FROM 
						$tbCategories
				  ORDER BY 
					title
				";
						
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	
	
	
}








