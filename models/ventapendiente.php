<?php
  
/**
* @version			1.0
* @package			TusConsultores
* @copyright		Copyright (C) 2014 Tusconsultores.com
* @Fecha			29/10/2014 09:19:05 a.m.
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class ModelVentaPendiente extends JModel{
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Listar Ventas
	*/
	function listarVentas(){	
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbVentas = $db->nameQuote('#__zventas');		
		
		$whereUsuario = ($user->id > 0) ?  " user = {$user->id} " : "";
		
		$query = "SELECT 
						*
				  FROM 
						$tbVentas as Ventas
				  WHERE 
						$whereUsuario
						AND estado = 'P'
				  ORDER BY
						fecha
						";
						
		$query = sprintf( $query, "%" . $filtro . "%" );
	
		$db->setQuery($query);
	
	    $result = $db->loadObjectList();

		return $result;
	}
	
	/**
	* Contar Ventas
	*/
	function contarVentas($filtro){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbVentas = $db->nameQuote('#__zventas');		
		
		$whereUsuario = ($user->id > 0) ?  "  usuario = {$user->id} " : "";
		$wherecontar="lower(cedula) like lower('%s')";
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbVentas as Ventas
				  WHERE 
						$whereUsuario
						AND estado = 'P'
						";
						
		$query = sprintf( $query, "%" . $filtro . "%" );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}

	
	/**
	* Obtiene Venta a través del id
	*/
	function getVenta($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');
		$row = &JTable::getInstance('Ventas', 'Table');
		$row->id = $id;
		$row->load();
		return $row;
	}
	
	/**
	* Guarda Venta
	*/
	function guardarVenta(){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Ventas', 'Table');
		$user = JFactory::getUser();
		
		if($row->bind(JRequest::get('post'))){
			$row->usuario = $user->id ;
			$row->activo = 1 ;
			if($row->store()){
				return JText::_('M_OK') . sprintf( JText::_('US_GUARDAR_OK') , $row->id );
			}
			else{
				return JText::_('M_ERROR'). JText::_('US_GUARDAR_ERROR');
			}
		
		}
	}
	
	/**
	* Elimina Venta
	*/
	function eliminarVenta($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Ventas', 'Table');
		
		$row->id     = $id;
		$row->activo = 0;
		if( $row->store() ){
			return JText::_('M_OK') . sprintf( JText::_('US_ELIMINAR_OK') , $row->id );
		}
		else{
			return JText::_('M_ERROR'). JText::_('US_ELIMINAR_ERROR');
		}
	}
	
}







