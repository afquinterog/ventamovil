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
class ViewUsSeguimientoVisitaForm extends JView
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
		$visita = JRequest::getVar('visita');
		$visita = Entidades::getById("visitas", $visita);
		$visita->municipio = Entidades::getById("municipios", $visita->municipio);
		$visita->barrio = Entidades::getById("barrios", $visita->barrio); 		
		$mdVisitas = $this->getModel('Visitas');
		// Obtiene las listas de datos
		$operador = Listas::getOperadores();
		
		$historial = $mdVisitas->getHistorialVisita($visita->id);
		
		$this->assignRef('visita', $visita);
		$this->assignRef('historial', $historial );
		//$this->assignRef('municipio', $visita->municipio );
		//$this->assignRef('barrio', $visita->barrio );
		$this->assignRef('operador', $operador );
		
		parent::display($tpl);
	}

	
}







