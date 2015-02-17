<?php 

class Listas{

	function getOperadores(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbOperadores = $db->nameQuote('#__zoperadores');			
		
		$query = "SELECT 
						*
				  FROM 
						$tbOperadores a
				  WHERE
						a.activo = 1
				  ORDER BY
						id
						";
						
		$query = sprintf($query, $user->id);
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	

	
		
}








