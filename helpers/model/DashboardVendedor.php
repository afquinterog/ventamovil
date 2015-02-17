<?php 

class DashboardVendedor{

	function contarVisitasPendientes(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbVisitas = $db->nameQuote('#__zvisitas');
		$fechaHoy = date('Y-m-d');
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbVisitas as visitas
				  WHERE 
						vendedor = %s
						AND activo = 1 
						AND estado = 'P'
						AND fecha_vencimiento >= '%s'
						";
		
		$query = sprintf( $query, $user->id , $fechaHoy);
		//echo $query;
		//exit;
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function contarVisitasVencidas(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbVisitas = $db->nameQuote('#__zvisitas');
		$fechaHoy = date('Y-m-d');
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbVisitas as visitas
				  WHERE 
						vendedor = %s
						AND activo = 1 
						AND estado = 'P'
						AND fecha_vencimiento < '%s'
						";
		
		$query = sprintf( $query, $user->id , $fechaHoy);
		//echo $query;
		//exit;
		$db->setQuery($query);
	    $result = $db->loadResult();
	
		return $result;
	}
	
	function tareasVencidas($tam = 3){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbTareas = $db->nameQuote('#__ztareas');
		$fechaHoy = date('Y-m-d');
		
		$query = "SELECT 
						*
				  FROM 
						$tbTareas as t
				  WHERE 
						vendedor = %s
						AND activo = 1 
						AND estado = 'P'
						AND fecha_entrega < '%s'
				  ORDER BY
						fecha_entrega
						";
		
		$query = sprintf( $query, $user->id , $fechaHoy);
		$db->setQuery($query, 0, $tam);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function tareasPendientes($tam = 3){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbTareas = $db->nameQuote('#__ztareas');
		$fechaHoy = date('Y-m-d');
		
		$query = "SELECT 
						*
				  FROM 
						$tbTareas as t
				  WHERE 
						vendedor = %s
						AND activo = 1 
						AND estado = 'P'
						AND fecha_entrega >= '%s'
				  ORDER BY
						fecha_entrega
						";
		
		$query = sprintf( $query, $user->id , $fechaHoy);
		$db->setQuery($query, 0, $tam);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function visitasVencidas($tam = 3){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbVisitas = $db->nameQuote('#__zvisitas');
		$fechaHoy = date('Y-m-d');

		$query = "SELECT 
		  *
		  FROM 
			$tbVisitas as v
		  WHERE 
				vendedor = %s
				AND activo = 1 
				AND estado = 'P'
				AND fecha_vencimiento < '%s'
		ORDER BY
			fecha_vencimiento, direccion
		  ";

		$query = sprintf( $query, $user->id , $fechaHoy);
		$db->setQuery($query, 0, $tam);
		$result = $db->loadObjectList();

		//Trae datos relacionados
		foreach( $result as $data){
			$data->municipio = Entidades::getById("municipios", $data->municipio); 
			$data->barrio = Entidades::getById("barrios", $data->barrio); 
		}
		return $result;
	}
	
	function visitasPendientes($tam = 3){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbVisitas = $db->nameQuote('#__zvisitas');
		$fechaHoy = date('Y-m-d');

		$query = "	SELECT 
						*
					FROM 
						$tbVisitas as v
					WHERE 
						vendedor = %s
						AND activo = 1 
						AND estado = 'P'
						AND fecha_vencimiento >= '%s'
					ORDER BY
						fecha_vencimiento, direccion
		  ";

		$query = sprintf( $query, $user->id , $fechaHoy);
		$db->setQuery($query, 0, $tam);
		$result = $db->loadObjectList();
		//Trae datos relacionados
		foreach( $result as $data){
			$data->municipio = Entidades::getById("municipios", $data->municipio); 
			$data->barrio = Entidades::getById("barrios", $data->barrio); 
		}
		return $result;
	}

	
	
	
	
		
}








