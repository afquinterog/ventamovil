<?php
  
/**
 * User Model
 *
 * @version $Id:  
 * @author Claudia Elena Duque
 * @package Joomla
 * @subpackage zschool
 * @license GNU/GPL
 *
 * Allows to manage user data
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

//require_once( JPATH_COMPONENT . DS .'models' . DS . 'zteam.php' );

/**
 * Mensaje
 *
 * @author      Claudia Elena Duque
 * @package		Joomla
 * @since 1.6
 */
		
class Modeltipo extends JModel{

	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Lista de tipos
	*/
	function listartipos($filtro, $inicio, $registros){	
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbtipos = $db->nameQuote('#__ztipos');		
		
		$whereUsuario = ($user->id > 0) ?  " usuario = {$user->id} " : "";
		$wherelistar= "lower(descripcion) like lower('%s')";
		$query = "SELECT 
						*
				  FROM 
						$tbtipos as tipos
				  WHERE 
						$wherelistar
						AND activo = 1 AND
						$whereUsuario
				  ORDER BY
						descripcion
						";
						
		$query = sprintf( $query, "%" . $filtro . "%" );
		$db->setQuery($query, $inicio, $registros);
	    $result = $db->loadObjectList();
		
		return $result;
	}
	
	/**
	* Contar tipos
	*/
	function contartipos($filtro){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbtipos = $db->nameQuote('#__ztipos');		
		
		$whereUsuario = ($user->id > 0) ?  "  usuario = {$user->id} " : "";
		$wherecontar="lower(descripcion) like lower('%s')";
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbtipos as tipos
				  WHERE 
						$wherecontar
						AND activo = 1 AND
						$whereUsuario
						";
						
		$query = sprintf( $query, "%" . $filtro . "%" );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}

	
	/**
	* Obtiene la tipo a traves del id
	*/
	function gettipo($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');
		$row = &JTable::getInstance('tipos', 'Table');
		$row->id = $id;
		$row->load();
		return $row;
	}
	
	/**
	* Guarda la tipo
	*/
	function guardartipo(){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('tipos', 'Table');
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
	* Elimina tipo
	*/
	function eliminartipo($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('tipos', 'Table');
		
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







