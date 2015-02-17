<?php
/**
 * @version		1.0
 * @package		Tusconsultores.com
 * @subpackage	
 * @copyright	Copyright (C) 2005 - 2014 Tusconsultores.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Form login
 *
 * @package		
 * @subpackage	
 * @since		
 */
class ViewUsVisitaSave extends JView
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
		
		$model 	= $this->getModel('Visitas');	
		//print_r(JRequest::get('post'));
		$result = $model->guardarVisita();
		Util::processResult($result);
		parent::display($tpl);
	}

	
}









