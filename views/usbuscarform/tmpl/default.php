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
					<h4 style='color:red'>Buscar cliente</h4>
                	<h4></h4>
                    <em>Ingrese la c&eacute;dula del cliente</em>
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
                                    <label class="field-title contactNameField" for="username">C&eacute;dula:<span></span></label>
                                    <input type="text" name="cedula" value="" class="contactField requiredField" id="username"/>
                                </div>
							
                                <div class="formSubmitButtonErrorsWrap">
                                    <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="paso1Btn" value="Buscar" data-formId="contactForm"/>
                                </div>
                            </fieldset>
							
							<input type="hidden" name="option" value="com_ztadmin" />
							<input type="hidden" name="task" value="usBuscarCedula" />
							<?php echo JHtml::_( 'form.token' ); ?>
                        </form>       
                    </div>
                </div>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:400px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>