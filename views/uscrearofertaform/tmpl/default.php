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

?>  
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une");?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'>Crear nueva oferta</h4>
                	<h4></h4>
                    <em>Seleccione los planes de la oferta</em>
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
                                    <label class="field-title contactNameField" for="cedula">Plan TO:<span></span></label>
									<select name="to" class="contactField requiredField">
										<option value="">Seleccione el plan de TO</option>
										<?php foreach($this->planesTO as $item){?>
											<option value="<?php echo $item->codplan ?>" >
												<?php echo $item->nomplan . " [ {$item->codplan} ] $" . Util::number_format($item->valor); ?>
											</option>
										<?php } ?>
									</select>
                                </div>
								
								<div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="cedula">Plan TV:<span></span></label>
									<select name="tv" class="contactField requiredField">
										<option value="">Seleccione el plan de TV</option>
										<?php foreach($this->planesTV as $item){?>
											<option value="<?php echo $item->codplan ?>" >
												<?php echo $item->nomplan . " [ {$item->codplan} ] $" . Util::number_format($item->valor);  ;?>
											</option>
										<?php } ?>
									</select>
                                </div>
								
								<div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="cedula">Plan BA:<span></span></label>
									<select name="ba" class="contactField requiredField">
										<option value="">Seleccione el plan de BA</option>
										<?php foreach($this->planesBA as $item){?>
											<option value="<?php echo $item->codplan ?>" >
												<?php echo $item->nomplan . " [ {$item->codplan} ] $" . Util::number_format($item->valor); ;?>
											</option>
										<?php } ?>
									</select>
                                </div>
							
                                <div class="formSubmitButtonErrorsWrap">
                                    <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Crear" data-formId="contactForm"/>
                                </div>
								
								<a href="index.php?option=com_ztadmin&task=usSeleccionarEstratoForm" class="button button-red contactSubmitButton">
									Regresar
								</a>
                            </fieldset>
							
							<input type="hidden" name="option" value="com_ztadmin" />
							<input type="hidden" name="task" value="usCrearOferta" />
							<?php echo JHtml::_( 'form.token' ); ?>
                        </form>       
                    </div>
                </div>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:400px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>