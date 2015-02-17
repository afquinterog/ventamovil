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
		
class ModelEntrega extends JModel{

	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Lista de entregas
	*/
	function listarEntregas($filtro, $inicio, $registros){	
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbentregas = $db->nameQuote('#__zentregas');		
		
		$whereUsuario = ($user->id > 0) ?  " usuario = {$user->id} " : "";
		$wherelistar= "lower(tipo) like lower('%s')";
		$query = "SELECT 
						*
				  FROM 
						$tbentregas as entregas
				  WHERE 
						$wherelistar
						AND activo = 1 AND
						$whereUsuario
				  ORDER BY
						fecha DESC
						";
						
		$query = sprintf( $query, "%" . $filtro . "%" );
		$db->setQuery($query, $inicio, $registros);
	    $result = $db->loadObjectList();
		
		//Trae datos relacionados
		foreach( $result as $data){
			$data->responsable = Entidades::getById("responsables", $data->responsable); 
			$data->tipo = Entidades::getById("tipos", $data->tipo); 
			$data->cheque = Entidades::getById("cheques", $data->cheque); 
		}

		return $result;
	}
	
	/**
	* Contar entregas
	*/
	function contarEntregas($filtro){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbentregas = $db->nameQuote('#__zentregas');		
		
		$whereUsuario = ($user->id > 0) ?  "  usuario = {$user->id} " : "";
		$wherecontar="lower(tipo) like lower('%s')";
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbentregas as entregas
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
	* Obtiene la entrega a traves del id
	*/
	function getEntrega($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');
		$row = &JTable::getInstance('Entregas', 'Table');
		$row->id = $id;
		$row->load();
		return $row;
	}
	
	/**
	* Guarda la entrega
	*/
	function guardarEntrega(){
		$db = JFactory::getDBO();
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Entregas', 'Table');
		$user = JFactory::getUser();
		
		ZDBHelper::initTransaction($db);
		
		$cheque = JRequest::getVar('cheque');
		$valor  = JRequest::getVar('valor');
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
	
	function legalizarEntrega(){
		$db = JFactory::getDBO();
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Entregas', 'Table');
		$user = JFactory::getUser();

		if( $this->validarEntrega() ){
			
			return $this->guardarGastosEntrega();
			/*if($row->bind(JRequest::get('post'))){
				$row->fecha_legalizacion = date('Y-m-d') ;
				$row->estado = 'L';
				if($row->store()){
					return JText::_('M_OK') . sprintf( JText::_('US_GUARDAR_OK') , $row->id );
				}
				else{
					return JText::_('M_ERROR'). JText::_('US_GUARDAR_ERROR');
				}
			
			}*/
		}
		else{
			return JText::_('M_ERROR'). JText::_('US_GASTOS_NO_COINCIDEN');
		}
	}
	
	function guardarGastosEntrega(){
		$db = JFactory::getDBO();
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		
		$id 	 = JRequest::getVar('id');
		$entrega = $this->getEntrega($id);
		$user    = JFactory::getUser();
		
		ZDBHelper::initTransaction($db);
		
		// Guardar las entreguitas
		$row =& JTable::getInstance('Entregas', 'Table');
		
		$index = 0;
		$tipos         = JRequest::getVar('tipo');
		$valores       = JRequest::getVar('valor');
		$descripciones = JRequest::getVar('descripcion');
		$observaciones = JRequest::getVar('observaciones');
		
		foreach($tipos as $tipo){
			if($tipo > 0 && isset($valores[$index]) && isset($descripciones[$index]) ){
			
				$row = JTable::getInstance('Entregas', 'Table');
				$row->tipo = $tipo;
				$row->valor = $valores[$index];
				$row->descripcion = $descripciones[$index];
				$row->responsable = $entrega->responsable;
				$row->cheque = $entrega->cheque;
				$row->fecha = $entrega->fecha;
				$row->fecha_legalizacion = date('Y-m-d');
				$row->activo = 1;
				$row->observaciones  = $observaciones;
				$row->estado = 'L';
				$row->usuario = $user->id ;
				
				if(!$row->store()){
					ZDBHelper::rollBack($db);
					return JText::_('M_ERROR'). JText::_('US_LEGALIZAR_ENTREGA_ERROR');
				}
			}
						
			$index ++ ;
		}

		// Borrar el registro de entrega 
		$row = JTable::getInstance('Entregas', 'Table');
		$row->id = $entrega->id ;
		if( !$row->delete() ){
			ZDBHelper::rollBack($db);
			return JText::_('M_ERROR'). JText::_('US_ELIMINAR_ERROR');
		}
		
		ZDBHelper::commit($db);
		return JText::_('M_OK') . sprintf( JText::_('US_LEGALIZAR_ENTREGA_OK') , $row->id );
	}
	
	function validarEntrega(){
		// Cargar los datos de la entrega de la bd
	    $id = JRequest::getVar('id');
		$entrega = $this->getEntrega($id);
		//echo "valor =" . $entrega->valor ;
	
		// Encontrar la suma de los valores de la entrega
		$suma = 0;
		$valores = JRequest::getVar('valor');
		foreach($valores as $valor){
			if( isset($valor) && $valor > 0 ){
				$suma = $suma + $valor;
			}
		}
		//echo "suma =" . $suma;
		
		if( $entrega->valor == $suma ){
			return true;
		}
		return false;
	}
	
	/**
	* Elimina entrega
	*/
	function eliminarEntrega($id){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Entregas', 'Table');
		
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







