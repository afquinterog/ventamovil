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
		
class ModelGasto extends JModel{

	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Lista de gastos
	*/
	function listarGastos($filtro, $tipo, $inicio, $registros){	
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbGastos  = $db->nameQuote('#__zgastos');	
		$tbEquipos = $db->nameQuote('#__zequipos');		
		$filtro    = "%" . $filtro . "%" ;	
		
		$whereUsuario = ($user->id > 0) ?  " gastos.usuario = {$user->id} " : "";
		$whereTipo    = ($tipo > 0) ?  " gastos.tipo = $tipo AND " : "" ;
		$whereListar= " (lower(tipo) like lower('%s') OR 
						lower(equipos.descripcion) like lower('%s') ) 
		                ";
		$query = "SELECT 
						gastos.*
				  FROM 
						$tbGastos as gastos,
						$tbEquipos as equipos
				  WHERE 
						gastos.equipo = equipos.id AND
						$whereListar
						AND gastos.activo = 1 AND
						$whereTipo
						$whereUsuario
				  ORDER BY
						fecha DESC, cheque, gastos.descripcion
						";
						
		$query = sprintf( $query, $filtro, $filtro, $tipo );
		$db->setQuery($query, $inicio, $registros);
	    $result = $db->loadObjectList();
		
		//Trae datos relacionados
		if(isset($result)){
			foreach( $result as $data){
				if($data->id > 0 ){
					$data->tipo   = Entidades::getById("tipos", $data->tipo); 
					$data->equipo = Entidades::getById("equipos", $data->equipo); 
					$data->cheque = Entidades::getById("cheques", $data->cheque); 
					
					$data->gastado = Cheque::gastadoCheque($data->id) ;
				}
			}
		}

		return $result;
	}
	
	/**
	* Contar gastos
	*/
	function contarGastos($filtro, $tipo){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbGastos = $db->nameQuote('#__zgastos');	
		$tbEquipos = $db->nameQuote('#__zequipos');				
		$filtro   = "%" . $filtro . "%" ;	
		
		$whereUsuario = ($user->id > 0) ?  "  gastos.usuario = {$user->id} " : "";
		$whereTipo    = ($tipo > 0) ?  "gastos.tipo = $tipo AND " : "" ;
		$whereContar =" (lower(tipo) like lower('%s') OR 
				        lower(equipos.descripcion) like lower('%s') )";
		
		$query = "SELECT 
						count(*)
				  FROM 
						
						$tbGastos as gastos,
						$tbEquipos as equipos
				  WHERE 
						gastos.equipo = equipos.id AND
						$whereContar AND 
						gastos.activo = 1 AND
						$whereTipo
						$whereUsuario
						";
						
		$query = sprintf( $query, $filtro, $filtro, $tipo);
		$db->setQuery($query);
	    $result = $db->loadResult();
		return $result;
	}

	
	/**
	* Obtiene la gasto a traves del id
	*/
	function getGasto($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');
		$row = &JTable::getInstance('gastos', 'Table');
		$row->id = $id;
		$row->load();
		return $row;
	}
	
	/**
	* Guarda el gasto
	*/
	function guardarGasto(){
		$db = JFactory::getDBO();
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('gastos', 'Table');
		$user = JFactory::getUser();
		
		ZDBHelper::initTransaction($db);
		
		$cheque = JRequest::getVar('cheque');
		$valor  = JRequest::getVar('valor');
		$valor  = str_replace(",", ".", $valor );
		$result = Cheque::guardarEntrega($cheque, $valor);
		
		if($result == 1){
			if($row->bind(JRequest::get('post'))){
				$row->usuario = $user->id ;
				$row->activo = 1 ;
				if($row->store()){
					ZDBHelper::commit($db);
					return JText::_('M_OK') . sprintf( JText::_('US_GUARDAR_OK') , $row->id );
				}
				else{
					ZDBHelper::rollBack($db);
					return JText::_('M_ERROR'). JText::_('US_GUARDAR_ERROR');
				}			
			}
		}
		else if( $result == 0){
			return JText::_('M_ERROR'). JText::_('US_CHEQUE_SALDO_INSUFICIENTE');
		}
		else if( $result == -1){
			return JText::_('M_ERROR'). JText::_('US_CHEQUE_ERROR_OPERACION');
		}
	}
	
	/**
	* Elimina gasto
	*/
	function eliminarGasto($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('gastos', 'Table');
		
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







