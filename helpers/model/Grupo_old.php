<?php 
class Grupo{

	
	function existeContacto($grupo, $contacto ){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbContactosGrupo = $db->nameQuote('#__zmgrupocontacto');	
      
		$query = "SELECT 
						count(*)
				  FROM 
						$tbContactosGrupo c
				  WHERE 
                  c.grupo = %s AND
						c.contacto = %s 
						";
						 
		$query = sprintf( $query, $grupo, $contacto );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return ($result > 0 ? true : false );
	}
   
  
	
	 
}








