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
class ViewUsCrearOfertaForm extends JView
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
		$subCategoria = JRequest::getVar('subCategoria');
		$barrio = JRequest::getVar('barrio');
		
		
		if( $barrio > 0 && $subCategoria > 0){
			$barrio = Entidades::getByCodigo("barrios", $barrio);
			$subCategoria = Entidades::getById("subcategorias", $subCategoria);
		}
		else{
			$data = $venta->getDatosClienteActual();
			$subCategoria = $data->estrato;
			$barrio = new stdClass();
			$barrio->municipio = $data->id_mpio;
		}


		//Obtiene cliente actual
		$data = $venta->getDatosClienteActual();
		if( ! isset($data->producto) ){
			// Si no existe los datos  crea un producto con id -1 para realizar la venta
			$venta->crearProductoVacio();
			$data = $venta->getDatosClienteActual();
		}

		// Guarda subcategoria en sesion
		if( isset($subCategoria->sucacodi) && $subCategoria->sucacodi > 0  ){	
			$data->categoria = $subCategoria->sucacate ;
			$data->subcategoria = $subCategoria->sucacodi ;
			if( isset($data->producto) ){
				$data->estrato = $subCategoria->sucacodi;	
			}
		}
		
		if( isset($barrio->municipio) ){
			if( isset($data->producto) ){
				$data->id_mpio = $barrio->municipio;
			}
		}

		$venta->setDatosClienteActual($data);
		$data  = $venta->getDatosClienteActual();
		$grupo = $venta->getGrupoMpio($barrio->municipio);
	
		$planesTO = $venta->getPlanesIndActuales('TO', $grupo );
		$planesTV = $venta->getPlanesIndActuales('TV', $grupo );
		$planesBA = $venta->getPlanesIndActuales('BA', $grupo );
		
		$this->assignRef('planesTO', $planesTO);
		$this->assignRef('planesTV', $planesTV);
		$this->assignRef('planesBA', $planesBA);
		
		parent::display($tpl);
	}

	
}







