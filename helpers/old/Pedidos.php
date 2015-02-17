<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Pedidos{
	
	
	function estados(){
		$db = Configuration::getTiendaDB();
		$tbEstados = $db->nameQuote('#__virtuemart_orderstates');
		$query = "SELECT 
						* 
				  FROM 
						$tbEstados 
				 ";
		
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function descripcionEstado( $estado ){
		$db = Configuration::getTiendaDB();
		$tbEstados = $db->nameQuote('#__virtuemart_orderstates');
		$query = "SELECT 
						order_status_name 
				  FROM 
						$tbEstados 
			      WHERE
						order_status_code = '%s'
				 ";
				 
		$query = sprintf($query, $estado);
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function getColor($estado){
		$color = ($estado == 'P') ? "red" : ( ($estado == 'C') ? "orange" : (($estado == 'S') ? "green" : "blue" ) );
		return "style='color:$color'";
	}
}








