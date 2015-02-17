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
 
   
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une", false);?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'>Iniciar sesion</h4>
                	<h4></h4>
                    <em>Ingrese sus datos para iniciar sesi&oacute;n</em>
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
                                    <label class="field-title contactNameField" for="username">Usuario:<span></span></label>
                                    <input type="text" name="username" value="" class="contactField requiredField" id="username"/>
                                </div>
								
								
								<div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="contactNameField">Password:<span></span></label>
                                    <input type="password" name="password" value="" class="contactField requiredField" id="password"/>
                                </div>

                                <div class="formSubmitButtonErrorsWrap">
                                    <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Ingresar" data-formId="contactForm"/>
                                </div>
                            </fieldset>
							
							<input type="hidden" name="option" value="com_ztadmin" />
							<input type="hidden" name="task" value="userLogin" />
							<?php echo JHtml::_( 'form.token' ); ?>
                        </form>       
                    </div>
                </div>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:400px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>