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
$tarea = $this->tarea;
$historial = $this->historial;
//print_r($historial);
?>
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une");?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'></h4>
                	<h4><?php echo $tarea->resumen; ?></h4>
                    <em>Fecha de Creaci&oacute;n: <?php echo $tarea->fecha_creacion; ?></em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<p><?php echo $tarea->descripcion; ?></p>
			<p><b>Fecha Entrega: </b><?php echo $tarea->fecha_entrega; ?></p>
			
			<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'></h4>
                	<h4>Historial</h4>
                    <em>Datos historicos de la tarea</em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<?php
				foreach($historial as $item){
			?>
					<p>
					<b style='margin-right:5px'><?php echo $item->fecha_registro . "  " . $item->username; ?></b>
					<?php echo $item->observaciones; ?></p>
			
			<?php
				}
			?>
			
			<form action="index.php" method="post" class="contactForm" id="contactForm">
			
				<fieldset>
					<div class="formSubmitButtonErrorsWrap">
						<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Actualizar datos" 
						data-formId="contactForm"/>
					</div>
				</fieldset>
									
				<input type="hidden" name="option" value="com_ztadmin" />
				<input type="hidden" name="task" value="usTareaForm" />
				<input type="hidden" name="tarea" value="<?php echo $tarea->id; ?>" />
			</form> 
			<div class="decoration"></div>
			
			<?php if($tarea->estado == 'P' ){?>
				<div class="container no-bottom">
					<div class="section-title">
						<h4 style='color:red'></h4>
						<h4>Actualizar tarea</h4>
						<em>Registro de informaci&oacute;n de seguimiento</em>
						<strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
					</div>
				</div>
				<div class="decoration"></div>
				
				
				<!-- Formulario de datos de cliente -->
				<div class="one-half-responsive">
				   
					<div class="container no-bottom">
						<div class="contact-form no-bottom"> 
						   
							
								<form action="index.php" method="post" class="contactForm" id="contactForm">
									<fieldset>
											
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="username">Nuevo estado:<span></span></label>
											<select name='estado' class="contactField requiredField">
												<option value='P' <?php echo $tarea->estado == 'P' ? "selected='selected'" : "" ?> >Pendiente</option>
												<option value='T' <?php echo $tarea->estado == 'T' ? "selected='selected'" : "" ?>>Terminada</option>
											</select>
										   
										</div>
										
										
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="contactNameField">Descripci&oacute;n:<span></span></label>
											 <textarea name="observaciones" class="contactTextarea requiredField" id="observaciones"></textarea>
										</div>

										<div class="formSubmitButtonErrorsWrap">
											<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Guardar" data-formId="contactForm"/>
										</div>
									</fieldset>
									
									<input type="hidden" name="option" value="com_ztadmin" />
									<input type="hidden" name="task" value="usTareaSave" />
									<input type="hidden" name="tarea" value="<?php echo $tarea->id; ?>" />
									<input type="hidden" name="tipo" value="T" />
									<?php echo JHtml::_( 'form.token' ); ?>
								</form>   
							
						</div>
					</div>
				</div>
			
			<?php } ?>
            <!-- Fin Formulario de datos de cliente -->
    	
			
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>