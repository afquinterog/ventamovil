<?php
/**
 * @version		$Id: controller.php 20553 2011-02-06 06:32:09Z infograf768 $
 * @package		Oru
 * @subpackage	Venta Movil
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');



require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Session.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Menu.php' );


require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'gui' . DS . 'PageHelper.php' );

require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Configuration.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'ZDBHelper.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Constantes.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Util.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'FileHelper.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'TiquetesHelper.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Editor.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'ZMailHelper.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'ZDateHelper.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Log.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'Validation.php' );
//require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'ZHelper.php' );

require_once( JPATH_COMPONENT . DS . 'helpers' . DS .  'ZExcelHelper.php' );

//Model
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'model' . DS . 'Listas.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'model' . DS . 'Entidades.php' );

require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'model' . DS . 'Cheque.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS .   'model' . DS . 'DashboardVendedor.php' );
require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'WebServices.php' );



/**
 * Base controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_ztelecliente
 * @since		1.6
 */
class SegurosController extends JController
{

	public function isLoggedUser(){
		$user = JFactory::getUser();
		if($user->id > 0 ){
			return true;
		}
		else{
			return false;
		}
	}

	
	/**
	 * Despliega un formulario de login
	 *
	 */
	public function userFormLogin(){	
		$user = JFactory::getUser();
		if($user->id > 0 ){
			$this->checkUserDashboard();
		}
		else{
			$document =& JFactory::getDocument();
			$viewName	= "userFormLogin";
			//$model = $this->getModel('ZMiUne' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
	}
	
	/**
	 * Login the user in the system joomla enabled
	 *
	 */
	public function userLogin(){
		JRequest::checkToken('post') or jexit(JText::_('JInvalid_Token'));	
		//print_r(JRequest::get('post'));
		$app = JFactory::getApplication();
	
		// Populate the data array:
		$data = array();
		$data['return'] = base64_decode(JRequest::getVar('return', '', 'POST', 'BASE64'));
		$data['username'] = JRequest::getVar('username', '', 'method', 'username');
		$data['password'] = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);

		// Set the return URL if empty.
		if (empty($data['return'])) {
			$data['return'] = 'index.php?option=com_ztadmin';
		}
		
		// Get the log in options.
		$options = array();
		$options['remember'] = JRequest::getBool('remember', false);
		$options['return'] = $data['return'];
		//$options['silent'] = 1;

		// Get the log in credentials
		$credentials = array();
		$credentials['username'] = $data['username'];
		$credentials['password'] = $data['password'];
		
		$error = $app->login($credentials, $options);
		
		// Check if the log in succeeded.
		if (!JError::isError($error)) {
			$app->setUserState('users.login.form.data', array());
			$user = JFactory::getUser();
			
			if($user->id > 0){
				//Get the  user type and redirect
				$this->checkUserDashboard();
			}
			else{
				$app->setUserState('users.login.form.data', $data);
				$app->redirect(JRoute::_('index.php?option=com_ztadmin&task=userFormLogin&error=2'));
			}
				
		} else {
			$data['remember'] = (int)$options['remember'];
			$app->setUserState('users.login.form.data', $data);
			$app->redirect(JRoute::_('index.php?option=com_ztadmin&task=userFormLogin&error=1'));
		}
	}
	
	/**
	 * Logout 
	 *
	*/ 
	public function userLogout(){
		$app = JFactory::getApplication();
		$error = $app->logout();
		$app->redirect('index.php?option=com_ztadmin');	
	}
	
	public function checkUserDashboard(){
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
	
		//Redirect depending of user
		if(isset($user->tipo) ){
			if($user->tipo == 'A'){
				$app->redirect(JRoute::_('index.php?option=com_ztadmin&task=adDashboard', false));	
			}
			else if ($user->tipo == 'V'){
				//$app->redirect(JRoute::_('index.php?option=com_ztadmin&task=veDashboard', false));	
				$app->redirect(JRoute::_('index.php?option=com_ztadmin&task=usDashboard', false));	
			}
		}
		else{
			$this->userFormLogin();
		}
		
	}
	
	/************************************ Acciones Genericas *************************************************/
	
	public function geCambiarClaveForm(){
		$user = JFactory::getUser();
		if($user->id > 0 ){
			$document =& JFactory::getDocument();
			$viewName	= "geCambiarClaveForm";
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function geCambiarClaveSave(){
		$user = JFactory::getUser();
		if($user->id > 0 ){
			//$this->userFormLogin();	
			$document =& JFactory::getDocument();
			$viewName	= "geCambiarClaveSave";
			$model = $this->getModel('Generico' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}

	public function userFormRecuperarClave(){	
		$user = JFactory::getUser();
		if($user->id > 0 ){
			$this->checkUserDashboard();
		}
		else{
			$document =& JFactory::getDocument();
			$viewName	= "userFormRecuperarClave";
			//$model = $this->getModel('ZMiUne' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
	}
	
	public function userFormCrearUsuario(){	
		$user = JFactory::getUser();
		if($user->id > 0 ){
			$this->checkUserDashboard();
		}
		else{
			$document =& JFactory::getDocument();
			$viewName	= "userFormCrearUsuario";
			//$model = $this->getModel('ZMiUne' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
	}
	

	/*************************************************************** Opciones venta movil********************************************/
	
	public function usDashboard(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			//$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );		
			$viewName	= "usDashboard";
			//$model = $this->getModel('Usuario' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	
	
	/**
	* Formulario para seleccionar tipo de busqueda: cedula, servicio, direccion
	*/
	public function usTipoBusquedaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usTipoBusquedaForm";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario para buscar cliente por cedula
	*/
	public function usBuscarCedulaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usBuscarCedulaForm";
			//$model = $this->getModel('Usuario' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario para buscar cliente por numero de servicio
	*/
	public function usBuscarServicioForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usBuscarServicioForm";
			//$model = $this->getModel('Usuario' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario para buscar cliente por numero de servicio
	*/
	public function usBuscarDireccionForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usBuscarDireccionForm";
			//$model = $this->getModel('Usuario' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario para buscar cliente por cedula o direccion
	*/
	public function usBuscarServicios(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usBuscarServicios";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Muestra la informacion detallada de un plan y sus ofertas asociadas
	*/
	public function usDetallePlan(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usDetallePlan";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Selecciona una oferta y redirige para realizar la configuracion adicional
	*/
	public function usSeleccionarOferta(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usSeleccionarOferta";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario para crear una nueva oferta seleccionando los planes de 
	* to, tv y ba
	*/
	public function usCrearOferta(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usCrearOferta";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	
	/**
	* Guarda los datos de la oferta y lo redirecciona a la configuracion de servicios adicionales 
	* de la oferta
	*/
	public function usSeleccionarEstratoForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usSeleccionarEstratoForm";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Guarda los datos de la oferta y lo redirecciona a la configuracion de servicios adicionales 
	* de la oferta
	*/
	public function usCrearOfertaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usCrearOfertaForm";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	
	/**
	* Formulario para configurar servicios adicionales de la oferta
	* to, tv y ba
	*/
	public function usConfigurarOfertaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usConfigurarOfertaForm";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Agrega un nuevo servicio adicional a la oferta actual
	*/
	function usNuevoServicioAdicional(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usNuevoServicioAdicional";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Elimina un servicio adicional de la oferta actual
	*/
	function usEliminarServicioAdicional(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usEliminarServicioAdicional";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario de registro de Venta en OSF
	*/
	function usFormularioOsfForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usFormularioOsfForm";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario de registro de Venta en OSF
	*/
	function usFormularioOsfSave(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usFormularioOsfSave";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	

	/*************************************************************** Opciones tareas  ********************************************/
	public function usTareaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName	= "usTareaForm";
			$model      = $this->getModel('Tareas' , 'Model');
			$viewType	= $document->getType();
			$view 		= &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usTareaList(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName	= "usTareaList";
			$model      = $this->getModel('Tareas' , 'Model');
			$viewType	= $document->getType();
			$view 		= &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usTareas_registroSave(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			//$this->userFormLogin();	
			$document =& JFactory::getDocument();
			$viewName	= "usTareas_registroSave";
			$model = $this->getModel('Tareas' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usVisitasList(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName	= "usVisitasList";
			$model      = $this->getModel('Tareas' , 'Model');
			$viewType	= $document->getType();
			$view 		= &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usTareaSave(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName	= "usTareaSave";
			$model      = $this->getModel('Tareas' , 'Model');
			$viewType	= $document->getType();
			$view 		= &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	
	/*************************************************************** Opciones visitas  ********************************************/
	public function usVisitaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usVisitaForm";
			$model      = $this->getModel('Visitas' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usSeguimientoVisitaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usSeguimientoVisitaForm";
			$model      = $this->getModel('Visitas' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usCerrarVisitaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usCerrarVisitaForm";
			$model      = $this->getModel('Visitas' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usVisitaList(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usVisitaList";
			//$model      = $this->getModel('Visitas' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	public function usVisitaSave(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usVisitaSave";
			$model      = $this->getModel('Visitas' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	
	 public function usVentasList(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usVentasList";
			$model      = $this->getModel('VentaPendiente' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
 
	 public function usEnviarVentaForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usEnviarVentaForm";
			$model      = $this->getModel('VentaPendiente' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
 
 
	public function usVentaSave(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usVentaSave";
			$model      = $this->getModel('VentaPendiente' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/*************************************************************** Opcion cambio de clave ********************************************/
	public function usClaveForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document   = &JFactory::getDocument();
			$viewName = "usClaveForm";
			$model      = $this->getModel('Users' , 'Model');
			$viewType = $document->getType();
			$view   = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display(); 
		}
		else{
			$this->userFormLogin();
		}
	}
	
	
	
	/**
	 * Table example
	 */
	public function tableExample(){	
		$user = JFactory::getUser();
		if($user->id > 0 ){
			$this->checkUserDashboard();
		}
		else{
			//$this->userFormLogin();	
			$document =& JFactory::getDocument();
			$viewName	= "tableExample";
			//$model = $this->getModel('ZMiUne' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
	}
	
	/**
	*Form example
	*/
	public function formExample(){	
		$user = JFactory::getUser();
		if($user->id > 0 ){
			//$this->userFormLogin();	
			$document =& JFactory::getDocument();
			$viewName	= "formExample";
			//$model = $this->getModel('ZMiUne' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	*Form example
	*/
	public function formWizard(){	
		$user = JFactory::getUser();
		if($user->id > 0 ){
			$this->checkUserDashboard();
		}
		else{
			//$this->userFormLogin();	
			$document =& JFactory::getDocument();
			$viewName	= "formWizard";
			//$model = $this->getModel('ZMiUne' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();
		}
	}
	
	
	
	/**
	* Include all needed libraries
	*/
	public function includeLibraries(){
		/*JHTML::script( 'custom/prototype/prototype-1.6.0.3.js' );
	    JHTML::script( 'custom/jquery/jquery-1.4.2.min.js' );
		JHTML::script( 'custom/jquery/jquery-ui-1.8.2.custom.min.js' );
		*/
		
		
		//JHTML::stylesheet( 'custom/tablehelper.css' );
		
		//Uploadify
		//JHTML::script( 'custom/uploadify/swfobject.js' );
		//JHTML::script( 'custom/uploadify/jquery.uploadify.v2.1.0.min.js' );

		
      
		
        $document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );		
	}
	
	/*============FVEGA========*/
		/**
	* Formulario para buscar datos del motivo
	*/
	public function usBuscarMotivo(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usBuscarMotivo";
			$model = $this->getModel('Venta' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}
	
	/**
	* Formulario para buscar detalles del motivo
	*/
	public function usBuscarMotivoForm(){
		$user = JFactory::getUser();
		if($user->id > 0  && $user->tipo=='V'){
			$document =& JFactory::getDocument();
			$viewName	= "usBuscarMotivoForm";
			//$model = $this->getModel('Usuario' , 'Model');
			$viewType	= $document->getType();
			$view = &$this->getView($viewName, $viewType , 'View');
			//$view->setModel($model , true);
			$view->display();	
		}
		else{
			$this->userFormLogin();
		}
	}

}
	
	
	



