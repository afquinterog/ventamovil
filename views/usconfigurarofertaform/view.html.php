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
class ViewUsConfigurarOfertaForm extends JView
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
		$venta 	  = $this->getModel('Venta');

		$serviciosTO = $venta->getServiciosAdicionales("TO");
		$serviciosTV = $venta->getServiciosAdicionales("TV");
		$serviciosBA = $venta->getServiciosAdicionales("BA");
		
	
		//Calculo de totales
		$serviciosAdi 		= Session::getVar("venta_servicios_adicionales");
		$totalPlan 			= $venta->getTotalesOferta();
		$totalesAdicionales = $venta->getTotalesServiciosAdicionales();
		$totales 			= $venta->calcularTotalesVenta($totalPlan, $totalesAdicionales);
		$data               = $venta->getDatosClienteActual();
		
		
		//$oferta = Session::getVar("nuevaOferta");
		$this->assignRef('serviciosTO', $serviciosTO);
		$this->assignRef('serviciosTV', $serviciosTV);
		$this->assignRef('serviciosBA', $serviciosBA);
		$this->assignRef('serviciosAdi', $serviciosAdi);
		$this->assignRef('data', $data);
		
		//Totales 
		$this->assignRef('totalPlan', $totalPlan);
		$this->assignRef('totalesAdcionales', $totalesAdicionales);
		$this->assignRef('totales', $totales );
		
		parent::display($tpl);
	}

	
}







