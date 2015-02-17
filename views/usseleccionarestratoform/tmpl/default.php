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
					<h4 style='color:red'>Seleccionar estrato</h4>
                	<h4></h4>
                    <em>Seleccione el estrato de su oferta</em>
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
                                    <label class="field-title contactNameField" for="cedula">Estrato:<span></span></label>
									<input type="text" name="subCategoria" value="" id="subCategoria" class="contactField requiredField" /> 
                                </div>
								
								<div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="cedula">Barrio:<span></span></label>
									<input type="text" name="barrio" value="" id="barrio" class="contactField requiredField" /> 
                                </div>
								
								
                                <div class="formSubmitButtonErrorsWrap" style='margin-top:20px'>
                                    <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Crear" data-formId="contactForm"/>
                                </div>
								
								<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">
									Regresar
								</a>
                            </fieldset>
							
							<input type="hidden" name="option" value="com_ztadmin" />
							<input type="hidden" name="task" value="usCrearOfertaForm" />
							<?php echo JHtml::_( 'form.token' ); ?>
                        </form>       
                    </div>
                </div>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:400px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>


<script src="templates/chronos/plugins/jquerytokeninput/js/jquery.tokeninput.js" type="text/javascript" ></script> 

<script type='text/javascript'>
jQuery(document).ready(function(){  

	jQuery("#subCategoria").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>/components/com_ztadmin/autocomplete/categorias.php", 
        {
         theme: "facebook",
         hintText: "Elija la categoria",
         noResultsText: "No existen categorias con estos datos ...",
         searchingText: "Buscando ....",
         minChars: 0,
         showing_all_results: true,
         tokenLimit: 1,
         preventDuplicates: true 
        }
	);
	
	jQuery("#barrio").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php?user=65&&addData=0<?php //echo $user->id; ?>", 
		{
			theme: "facebook",
			hintText: "Escriba el barrio",
			noResultsText: "No existen barrios con estos datos ...",
			searchingText: "Buscando ....",
			minChars: 3,
			showing_all_results: true,
			tokenLimit: 1,
			preventDuplicates: true
		}
	);
	
	jQuery("#content").css("z-index", "1");
	jQuery("#sidebar").css("z-index", "0");
	
	
});
</script>