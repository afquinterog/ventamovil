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
class ViewUsBuscarServicios extends JView
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
		$cedula   = JRequest::getVar("cedula");
		$servicio = JRequest::getVar("servicio");
		$direccion = JRequest::getVar("direccion");
		
		//print_r($direccion);
		if(isset($servicio) && $servicio != ""){
			$direccion = $venta->consultarDireccionServicio($servicio);
			$data      = $venta->buscarPaquetesPorDireccion($direccion);
			//print_r($data[0]->cliente);
			if( isset($data[0]->cliente) ){
				$cedula = $data[0]->cliente;
				$data[0]->cedula = $data[0]->cliente;
			}
		}
		else if(isset($cedula) && $cedula != ""){
			$data = $venta->buscarPaquetesPorCedula($cedula);
		} 
		else if(isset($direccion) && $direccion != ""){
			$data = $venta->buscarPaquetesPorDireccion($direccion);
			if( isset($data[0]->cliente) ){
				$cedula = $data[0]->cliente;
				$data[0]->cedula = $data[0]->cliente;
			}else{
				$cobertura = $venta->consultarCobertura($direccion);
				$cobertura = $cobertura== "NG" && $cobertura != "Fibra" ? "Sin Informaci&oacute;n" : $cobertura;
				if (strpos($cobertura,"|")){
					$tecnologias = explode('|', $cobertura);
					$cobertura = ($tecnologias[0] == "S" ? "- HFC " : "") . ($tecnologias[1] == "S" ? " - Cobre -" : "");
				}
			}
			
				
		} 
		else{
			$data = Session::getVar('infoCliente');
		}
		
		if($cedula != ""){
			$scoring = $venta->consultarScoring($cedula);
			Session::setVar('scoring', $scoring);
			$this->assignRef('scoring', $scoring);
		}

		// Quitar iva BA en estratos 1,2,3
		foreach($data as &$item){
			$subcategoria = explode("-", $item->subcategoria ) ;
			//print_r($item);
			//exit;
			$iva = $item->tarifa_to  + $item->tarifa_tv ;
			$item->subsidioIva = "SI";
			if( strpos($subcategoria[0], "1" ) === FALSE && 
				strpos($subcategoria[0], "2" ) === FALSE && 
				strpos($subcategoria[0], "3" ) === FALSE   ){
				$iva = $iva + $item->tarifa_ba  ;
				$item->subsidioIva = "NO";
			}
			//echo $iva;
			//exit;
			$item->iva = $iva * 16/100 ;
			
		}
		
		Log::add("BUSCAR_CEDULA", $cedula);
		Session::setVar('infoCliente', $data);
		
		
		foreach($data as $item){ 
			$otros = explode ('|',$venta->consultarProdRetenFinan($item->producto));
			$otrosDetalles["PlanProm"][$item->producto] 	= $otros[0];
			$otrosDetalles["Reten"][$item->producto] 		= $otros[1];
			$otrosDetalles["Finan"][$item->producto] 		= $otros[2];
			$otrosDetalles["Cobertura"][$item->producto]	= $item->id_mpio == 73001 ? "Fibra" : $venta->consultarCobertura($item->id_direccion);
			$otrosDetalles["Cobertura"][$item->producto] = $otrosDetalles["Cobertura"][$item->producto] == "NG" && $otrosDetalles["Cobertura"][$item->producto] != "Fibra" ? "Sin Informaci&oacute;n" : $otrosDetalles["Cobertura"][$item->producto];
			if (strpos($otrosDetalles["Cobertura"][$item->producto],"|")){
				$tecnologias = explode('|', $otrosDetalles["Cobertura"][$item->producto]);
				$otrosDetalles["Cobertura"][$item->producto] = ($tecnologias[0] == "S" ? "- HFC " : "") . ($tecnologias[1] == "S" ? " - Cobre -" : "");
			}
		}
		
		$this->assignRef('data', $data);
		$this->assignRef('otrosDetalles', $otrosDetalles);
		$this->assignRef('cobertura', $cobertura);
		
		parent::display($tpl);
	}

	
}







