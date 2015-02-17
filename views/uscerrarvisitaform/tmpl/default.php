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
			
				
				<!-- Formulario de datos de cliente -->
				<div class="one-half-responsive">
				   
					<div class="container no-bottom">
						<div class="contact-form no-bottom"> 
						   						
								<form action="index.php" method="post" class="contactForm" id="contactForm">
									<fieldset>
											
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="contactNameField">Persona Visitada:<span></span></label>
											 <input type="text" name="nombre" value="" class="contactField requiredField" id="nombre"/>
										</div>
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="contactNameField">Teléfono:<span></span></label>
											 <input type="text" name="telefono" value="" class="contactField requiredField" id="telefono"/>
										</div>
										
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="operador">Operador:<span></span></label>
											<select name='operador' class="contactField requiredField">
											<option value="">Seleccione operador</option>
												<?php foreach($this->operador as $item){?>"
													<option value="<?php echo $item->id ?>"<?php echo ($item->id == $operador? "selected":""); ?>>
												<?php echo $item->descripcion;?>
											</option>
												<?php } ?>
											</select>
										</div>
										
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="rango">Rango:<span></span></label>
											<select name='rango' class="contactField requiredField">
												<option value='0 - 19000' <?php echo $visita->rango == '0 - 19000' ? "selected='selected'" : "" ?> >0 - 19000</option>
												<option value='20000 - 50000' <?php echo $visita->rango == '20000 - 50000' ? "selected='selected'" : "" ?> >20000 - 50000</option>
												<option value='51000 - 70000' <?php echo $visita->rango == '51000 - 70000' ? "selected='selected'" : "" ?> >51000 - 70000</option>
												<option value='71000 - 90000' <?php echo $visita->rango == '71000 - 90000' ? "selected='selected'" : "" ?> >71000 - 90000</option>
												<option value='91000 - en adelante' <?php echo $visita->rango == '91000 - en adelante' ? "selected='selected'" : "" ?> >91000 - en adelante</option>
											</select>
										</div>
											
										<!--<div class="formFieldWrap">
											<label class="field-title contactNameField" for="username">Nuevo estado:<span></span></label>
											<select name='estado' class="contactField requiredField">
												<option value='P' <?php echo $visita->estado == 'P' ? "selected='selected'" : "" ?> >Pendiente</option>
												<option value='T' <?php echo $visita->estado == 'T' ? "selected='selected'" : "" ?>>Terminada</option>
											</select>
										   
										</div>-->
										
										
										<div class="formFieldWrap">
											<label class="field-title contactNameField" for="contactNameField">Observaciones:<span></span></label>
											 <textarea name="observaciones" class="contactTextarea requiredField" id="observaciones"></textarea>
										</div>

										<div class="formSubmitButtonErrorsWrap">
											<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Guardar" data-formId="contactForm"/>
										</div>
									</fieldset>
									
									<input type="hidden" name="option" value="com_ztadmin" />
									<input type="hidden" name="task" value="usVisitaSave" />
									<input type="hidden" name="id" value="<?php echo $visita->id; ?>" />
									<?php echo JHtml::_( 'form.token' ); ?>
								</form>   
							
						</div>
					</div>
				</div>
			
		
            <!-- Fin Formulario de datos de cliente -->
    	
			
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>