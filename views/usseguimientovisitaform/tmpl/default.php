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
                    <em>Fecha de Creaci&oacute;n: <?php echo $visita->fecha_creacion; ?></em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<p><?php echo $visita->descripcion; ?></p>
			<p><b>Fecha Vencimiento: </b><?php echo $visita->fecha_vencimiento; ?></p>
			
			<div class="decoration"></div>

			<?php if($visita->estado == 'P' ){?>
				<div class="container no-bottom">
					<div class="section-title">
						<h4 style='color:red'></h4>
						<h4>Actualizar visita</h4>
						<em>Registro de informaci&oacute;n de seguimiento</em>
						<strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
						<form action="index.php" method="post" class="contactForm" id="contactForm">
									<fieldset>
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="contactNameField">Descripci&oacute;n:<span></span></label>
											 <textarea name="observaciones" class="contactTextarea requiredField" id="observaciones"></textarea>
										</div>

										<div class="formSubmitButtonErrorsWrap">
											<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Guardar" data-formId="contactForm"/>
										</div>
									</fieldset>
									
									<input type="hidden" name="option" value="com_ztadmin" />
									<input type="hidden" name="task" value="usTareas_registroSave" />
									<input type="hidden" name="tarea" value="<?php echo $visita->id; ?>" />
									<input type="hidden" name="tipo" value="V" />
									<?php echo JHtml::_( 'form.token' ); ?>
								</form>   
						
					</div>
				</div>
				<div class="decoration"></div>
		
			
			<?php } ?>
            <!-- Fin Formulario de datos de cliente -->
    	
			
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>