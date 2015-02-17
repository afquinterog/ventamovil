<?php
/**
* @version			1.0
* @package			TusConsultores
* @copyright		Copyright (C) 2014 Tusconsultores.com
* @Fecha			11/08/2014 08:10:16 p.m.
*/


defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class ViewUsTareas_registrosave extends JView
{
	protected $form;
	protected $params;
	protected $state;
	protected $user;

	/**
	 * Method to display the view.
	 *
	 * @param	string	The template file to include
	 * @since	1.5
	 */
	public function display($tpl = null)
	{
		JRequest::checkToken() or die( 'Token Invalido' );

		$model 	= $this->getModel('Tareas');	
		
		$result = $model->guardarTareas_registro();
		Util::processResult($result);
		parent::display($tpl);
	}

	
}









