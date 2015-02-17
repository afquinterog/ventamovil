<?php 
class Mensajes{

	
	function esNumeroValido($number){
		if( is_numeric( $number) ){
			return true;
		}
		else{
			return false;
		}
	}
	
	function limpiarNumero($numero){
		$numero = trim($numero);
		$numero = str_replace('.', '', $numero);
		$numero = str_replace('+', '', $numero);
		$numero = str_replace('-', '', $numero);
		$numero = str_replace(',', '', $numero);
                $numero = str_replace(' ', '', $numero);
		return $numero;
	}
	
	function existeContacto($movil){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbContactos = $db->nameQuote('#__zmcontactos');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbContactos c
				  WHERE 
						c.movil = %s AND
						c.usuario = %s
						";
						 
		$query = sprintf( $query, $movil, $user->id );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return ($result > 0 ? true : false );
	}
   
   function getContacto($movil){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbContactos = $db->nameQuote('#__zmcontactos');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbContactos c
				  WHERE 
						c.movil = '%s' AND
						c.usuario = %s
						";
						 
		$query = sprintf( $query, $movil, $user->id );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return isset($result[0]) ? $result[0] : 0;
	}
	
	function contarMensajesEntrada(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbInbox = $db->nameQuote('inbox');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbInbox i
				  WHERE 
						i.username = '%s' AND
						activo = 1
						";
						 
		$query = sprintf( $query, $user->username );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function contarMensajesSalida(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbMensajes = $db->nameQuote('outbox');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbMensajes m
				 WHERE 
						 m.user = %s AND
						 m.status in ('ACCEPTED', 'sending') 
						";
						 
		$query = sprintf( $query, $user->id );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function contarMensajesEnviados(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$fechaHoy = Configuration::getDate();	
		$tbMensajes = $db->nameQuote('outbox');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbMensajes m
				 WHERE 
						 m.user = %s AND
						 m.status in ('sent', 'undelivered', 'delivered')
						";
						 
		$query = sprintf( $query, $user->id, $fechaHoy );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function contarMensajesNoEnviados(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$fechaHoy = Configuration::getDate();	
		$tbMensajes = $db->nameQuote('outbox');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbMensajes m
				 WHERE 
						 m.user = %s AND
						 m.status in ('notsent')
						";
						 
		$query = sprintf( $query, $user->id);
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function contarMensajesProgramados(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbMensajes = $db->nameQuote('outbox');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbMensajes m
				 WHERE 
						 m.user = %s AND
						 m.status in ('program') 
						";
						 
		$query = sprintf( $query, $user->id );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	function contarMensajesEliminados(){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$fechaHoy = Configuration::getDate();	
		$tb = $db->nameQuote('outbox');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tb o
				  WHERE 
						o.user = %s AND
						o.status = 'deleted'
						";
						 
		$query = sprintf( $query, $user->id );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}
	
	 
}








