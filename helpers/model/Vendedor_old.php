?php 
class Vendedor{

	function getMensajes($user){
		$db = JFactory::getDBO();
		$tbUsers = $db->nameQuote('#__users');		
		
		//$whereGrupo 	  = ($grupo > 0) ?       " AND r.grupo= $grupo " : "";
		
		$query = "SELECT 
						mensajes
				   FROM 
						$tbUsers as u
				   WHERE 
						 u.id = %s
						";
		$query = sprintf( $query, $user);
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
}








