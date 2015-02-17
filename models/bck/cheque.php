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
		
class Modelcheque extends JModel{

	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Lista de cheques
	*/
	function listarcheques($filtro, $inicio, $registros){	
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbcheques = $db->nameQuote('#__zcheques');		
		
		$whereUsuario = ($user->id > 0) ?  " usuario = {$user->id} " : "";
		$wherelistar= "lower(descripcion) like lower('%s')";
		$query = "SELECT 
						*
				  FROM 
						$tbcheques as cheques
				  WHERE 
						$wherelistar
						AND activo = 1 AND
						$whereUsuario
				  ORDER BY
						fecha
						";
						
		$query = sprintf( $query, "%" . $filtro . "%" );
		$db->setQuery($query, $inicio, $registros);
	    $result = $db->loadObjectList();
		
		//Trae datos relacionados
		foreach( $result as $data){
			$data->gastado = Cheque::gastadoCheque($data->id) ;
		}

		return $result;
	}
	
	/**
	* Contar cheques
	*/
	function contarCheques($filtro){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbcheques = $db->nameQuote('#__zcheques');		
		
		$whereUsuario = ($user->id > 0) ?  "  usuario = {$user->id} " : "";
		$wherecontar="lower(descripcion) like lower('%s')";
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbcheques as cheques
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
	* Obtiene la cheque a traves del id
	*/
	function getCheque($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');
		$row = &JTable::getInstance('cheques', 'Table');
		$row->id = $id;
		$row->load();
		$row->gastado = Cheque::gastadoCheque($row->id) ;
		return $row;
	}
	
	/**
	* Guarda la cheque
	*/
	function guardarcheque(){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('cheques', 'Table');
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
	* Elimina cheque
	*/
	function eliminarcheque($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('cheques', 'Table');
		
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







