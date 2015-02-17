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
		
class ModelVisitas extends JModel{

	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	
	/**
	* Guarda la tarea
	*/
	function guardarVisita(){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Visitas', 'Table');
		$user = JFactory::getUser();
		
		if($row->bind(JRequest::get('post'))){
			//$row->usuario = $user->id ;
			//$row->responsable = $user->id ;
			//$row->activo = 1 ;
			$row->estado = 'T' ;
			//$row->fecha_registro =  date('Y-m-d H:i:s');
			//print_r ($row);
			//exit;
			if($row->store()){
				return JText::_('M_OK') . sprintf( JText::_('US_GUARDAR_OK') , $row->id );
			}
			else{
				return JText::_('M_ERROR'). JText::_('US_GUARDAR_ERROR');
			}
		
		}
	}
	
	
	function getHistorialVisita($tarea){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbTareas = $db->nameQuote('#__ztareas_registro');	
		$tbUsuarios = $db->nameQuote('#__users');	
		
		$query = "SELECT 
						t.*, u.username
				  FROM 
						$tbTareas as t,
						$tbUsuarios as u
				  WHERE 
						tarea = %s AND
						t.activo = 1  AND
						t.responsable = u.id AND
						t.tipo='V'
				  ORDER BY
						t.fecha_registro DESC
						";
						
		$query = sprintf( $query, $tarea );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	
	
}







