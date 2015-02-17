<?php 
class TiquetesHelper{


	/**
	* Retorna los estados de los tiquetes
	*/
	function getEstados(){
		$db = JFactory::getDBO();
		$tbEstados = $db->nameQuote('#__zestados');
		
		$query = "SELECT 
						*
				  FROM 
						$tbEstados as e
				  ORDER BY id ASC
				 ";
						 
		//$query = sprintf( $query, $id );
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}
	
	/**
	* Retorna los estados de los tiquetes
	*/
	function getUsuarios(){
		$db = JFactory::getDBO();
		$tbUsuarios = $db->nameQuote('#__users');
		
		$query = "SELECT 
						*
				  FROM 
						$tbUsuarios 
				  ORDER BY username 
				 ";
						 
		//$query = sprintf( $query, $id );
		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}
	
	/**
	* Devuelve un estado a partir de su id
	*/
	function getEstado($id){
		$db = JFactory::getDBO();
		$tbEstados = $db->nameQuote('#__zestados');
		
		$query = "SELECT 
						descripcion
				  FROM 
						$tbEstados as e
				  WHERE 
						 id = %s";
						 
		$query = sprintf( $query, $id );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
}








