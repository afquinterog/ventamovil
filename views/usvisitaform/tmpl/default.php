<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
$visita = $this->visita;
$historial = $this->historial;
$operador= $this->operador;
//print_r($historial);
?>
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une");?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'></h4>
                	<h4><?php echo $visita->direccion."-".$visita->barrio->descripcion."-".$visita->municipio->descripcion; ?></h4>
					<p>Fecha de Creaci&oacute;n: <?php echo $visita->fecha_creacion; ?></p>
                    <em>Fecha Vencimiento: </b><?php echo $visita->fecha_vencimiento; ?></em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<p><?php echo (isset($visita->estrato)? ("Estrato: ".$visita->estrato) :"") ; ?></p>
			<p><?php echo (isset($visita->nombre)? ("Cliente: ".$visita->nombre) :"") ; ?></p>
			<p><?php echo (isset($visita->servicios_activos)? ("Servicios Activos: ".$visita->servicios_activos) :"") ; ?></p>
			<p><?php echo (isset($visita->descripcion)? ("Observaciones: ".$visita->descripcion) :"") ; ?></p>
			
			
			
			<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'></h4>
                	<h4>Historial</h4>
                    <em>Datos históricos de la visita</em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
         
			
			<?php
				foreach($historial as $item){
			?>
					<p>
					<b style='margin-right:5px'><?php echo $item->fecha_registro . "  " . $item->username; ?></b>
					<?php echo $item->observaciones; ?></p>
			
			<?php
				}
			?>
			   <div class="decoration"></div>
			<form action="index.php" method="post" class="contactForm" id="contactForm">
				<fieldset>
					<div class="formSubmitButtonErrorsWrap">
						<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Registrar Seguimiento" 
						data-formId="contactForm"/>
					</div>
				</fieldset>
									
				<input type="hidden" name="option" value="com_ztadmin" />
				<input type="hidden" name="task" value="usSeguimientoVisitaForm" />
				<input type="hidden" name="visita" value="<?php echo $visita->id; ?>" />
			</form> 
			<form action="index.php" method="post" class="contactForm" id="contactForm">
				<fieldset>
					<div class="formSubmitButtonErrorsWrap">
						<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Formulario Visitas" 
						data-formId="contactForm"/>
					</div>
				</fieldset>
									
				<input type="hidden" name="option" value="com_ztadmin" />
				<input type="hidden" name="task" value="usCerrarVisitaForm" />
				<input type="hidden" name="visita" value="<?php echo $visita->id; ?>" />
			</form> 

		
<?php echo PageHelper::endPage();?>