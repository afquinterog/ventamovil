<?php 

class Cheque{

	function guardarEntrega($cheque, $valor){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbCheques = $db->nameQuote('#__zcheques');		
		
		$cheque = Entidades::getById("cheques", $cheque);
		$gastado = Cheque::gastadoCheque($cheque->id) ;
		
		if( $cheque->valor - $gastado >= $valor){
			// sumar valor a gastado 
			$query = "update $tbCheques set gastado = gastado + %s where id = %s";
			$query = sprintf($query, $valor, $cheque->id);
			$db->setQuery( $query );
			if($db->query()){
				return 1;
			}
		}
		else{
			return 0;
		}
		return -1;
	}
	
	function gastadoCheque($idCheque ){
		$total = round( Cheque::valorGastos( $idCheque) + Cheque::valorEntregas( $idCheque), 3 );
		return $total;
	}
	
	function valorGastos( $cheque ){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbGastos = $db->nameQuote('#__zgastos');		
		
		$query = "SELECT 
						sum(valor)
				  FROM 
						$tbGastos as gastos
				  WHERE 
						gastos.cheque = %s
						AND activo = 1 
						";
		
		$query = sprintf( $query, $cheque );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function valorEntregas( $cheque ){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbEntregas = $db->nameQuote('#__zentregas');		
		
		$query = "SELECT 
						sum(valor)
				  FROM 
						$tbEntregas as entregas
				  WHERE 
						entregas.cheque = %s
						AND activo = 1 
						";
		
		$query = sprintf( $query, $cheque );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	
	
		
}








