?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class CRPlanes{
	
	
	function getPlanes(){
		$db = Configuration::getTiendaDB();
		$tbPlanes = $db->nameQuote('#__zplanes');
		
		$query = "SELECT 
						*
				  FROM 
						$tbPlanes as p
				  ORDER BY
						descripcion
						";
		$query = sprintf( $query);
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function getEquipos(){
		$db = Configuration::getTiendaDB();
		$tbEquipos = $db->nameQuote('#__virtuemart_products_es_es');
		
		$query = "SELECT 
						*
				  FROM 
						$tbEquipos as e
				  ORDER BY
						product_s_desc
						";
		$query = sprintf( $query);
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	
}








