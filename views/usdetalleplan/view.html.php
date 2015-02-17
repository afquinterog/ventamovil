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
class ViewUsDetallePlan extends JView
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
		$subCategoria = JRequest::getVar('subCategoria', "");
		$producto = JRequest::getVar('producto', "");
		Session::setVar("productoActual", $producto);
		$data = $venta->getDatosClienteActual();
		
		if($subCategoria != "" && $subCategoria > 0){
			$subCategoria = Entidades::getById("subcategorias", $subCategoria);
			if( isset($subCategoria->sucacodi) && $subCategoria->sucacodi > 0  ){
				Session::setVar('nuevoEstrato', $subCategoria->sucacodi);
			}
		}
		
		$prods = explode('-',$data->productos);
		
		foreach($prods as $item){ 
			
			$items 	= explode('=',$item);
			$otros 	= explode ('|',$venta->consultarProdRetenFinan($items[1]));
			$otrosDetalles["PlanProm"][$items[0]] 	= $otros[0];
			$otrosDetalles["Reten"][$items[0]] 		= $otros[1];
			$otrosDetalles["Finan"][$items[0]] 		= $otros[2];
			$otrosDetalles["FeIn"][$items[0]] 		= $venta->consultarProdFeIn($items[1]);
		}

		$ofertas = $venta->buscarOfertas($data);
		Session::setVar('ofertas', $ofertas);
		$this->assignRef('ofertas', $ofertas);
		$this->assignRef('otrosDetalles', $otrosDetalles);
		$this->assignRef('data', $data);
		parent::display($tpl);
	}

	
}







