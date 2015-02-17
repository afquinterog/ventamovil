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
class ViewUsFormularioOsfForm extends JView
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
		$mdVenta = $this->getModel('Venta');
		$tarifaActual       = $mdVenta->getTarifaActual();
		$totalMensual       = $mdVenta->getTotalMensual();
		$tiposSolicitud     = $mdVenta->getTiposSolicitud();
		$subCategoriaActual = $mdVenta->getSubCategoriaActualTexto();
		
		// Obtiene los datos del cliente actual
		$cliente = $mdVenta->getDatosClienteActual();		
		//Categoria
		$subcategoria = $mdVenta->getSubCategoriaActual();
		$this->assignRef('subcategoria', $subcategoria );
		
		if( $mdVenta->getTipoVenta() != "UP"){
			$result = JText::_('M_ERROR') . sprintf( JText::_('VENTA_DOWN_FACTURACION_ACTUAL') );
			Util::processResult($result);
			Util::redirect("index.php?option=com_ztadmin&task=usConfigurarOfertaForm");	
		}
		
		$this->assignRef('cliente', $cliente  );
		$this->assignRef('tiposSolicitud'    , $tiposSolicitud  );
		$this->assignRef('subCategoriaActual', $subCategoriaActual  );
	
		parent::display($tpl);
	}

	
}







