<?php 

class Entidades{

	function getById($table, $id){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbName = "#__z" . $table ;
		$tbData = $db->nameQuote( $tbName );			
		
		$query = "SELECT 
						*
				  FROM 
						$tbData a
				  WHERE
						a.id = %s
						";
						
		$query = sprintf($query, $id);
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return isset($result[0]) ? $result[0] : "" ;	
	}
	
	function getByCodigo($table, $codigo){
	  $db = JFactory::getDBO();
	  $user = JFactory::getUser();
	  $tbName = "#__z" . $table ;
	  $tbData = $db->nameQuote( $tbName );   
	  
	  $query = "SELECT 
		  *
		  FROM 
		  $tbData a
		  WHERE
	   
		  a.codigo = %s
		  ";
		  
	  $query = sprintf($query, $codigo);
	  $db->setQuery($query);
	  $result = $db->loadObjectList();
	  return isset($result[0]) ? $result[0] : "" ; 
	 }
}