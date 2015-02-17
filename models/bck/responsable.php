<?php
  
/**
 * User Model
 *
 * @version $Id:  
 * @author claudia duque
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
 * @author      claudia duque
 * @package		Joomla
 * @since 1.6
 */
		
class Modelresponsable extends JModel{

	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Lista de responsables
	*/
	function listarresponsables($filtro, $inicio, $registros){	
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbresponsables = $db->nameQuote('#__zresponsables');		
		
		$whereUsuario = ($user->id > 0) ?  " usuario = {$user->id} " : "";
		$wherelistar= "lower(descripcion) like lower('%s')";
		$query = "SELECT 
						*
				  FROM 
						$tbresponsables as responsables
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
		
		//Trae datos relacionados
		foreach( $result as $data){
			
		}

		return $result;
	}
	
	/**
	* Contar responsables
	*/
	function contarresponsables($filtro){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbresponsables = $db->nameQuote('#__zresponsables');		
		
		$whereUsuario = ($user->id > 0) ?  "  usuario = {$user->id} " : "";
		$wherecontar="lower(descripcion) like lower('%s')";
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbresponsables as responsables
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
	* Obtiene la responsable a traves del id
	*/
	function getresponsable($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');
		$row = &JTable::getInstance('responsables', 'Table');
		$row->id = $id;
		$row->load();
		return $row;
	}
	
	/**
	* Guarda la responsable
	*/
	function guardarresponsable(){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('responsables', 'Table');
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
	* Elimina responsable
	*/
	function eliminarresponsable($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('responsables', 'Table');
		
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







