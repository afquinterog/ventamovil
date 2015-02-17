<?php
/**
 * @version		$Id: view.html.php 21023 2011-03-28 10:55:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
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
class ViewUsBuscarMotivo extends JView
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
		$venta 	= $this->getModel('Venta');	
		$motivo = JRequest::getVar("motivo");
		$data = $venta->buscarMotivo($motivo);
		
		Log::add("BUSCAR_MOTIVO", $motivo);
	
			//$data = $motivo."|".$motivo."|".$motivo."|".$motivo."|".$motivo."|".$motivo."|".$motivo;
		$this->assignRef('data', $data);
		//$this->assignRef('scoring', $scoring);
		print ($data);
		parent::display($tpl);
	}

	
}







