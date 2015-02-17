?php
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
class ViewUsBuscarCedula extends JView
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
		$cedula = JRequest::getVar("cedula");
		
		$data = $venta->buscarCedula($cedula);
		//Consulta Scoring
		$scoring = $venta->consultarScoring($cedula);
		Log::add("BUSCAR_CEDULA", $cedula);
	
		Session::setVar('infoCliente', $data);
		Session::setVar('scoring', $scoring);
			
		$this->assignRef('data', $data);
		$this->assignRef('scoring', $scoring);
		
		parent::display($tpl);
	}

	
}







