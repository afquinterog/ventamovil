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
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une", true);?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'>Buscar cliente</h4>
                	<h4></h4>
                    <em>Ingrese la direccion del cliente</em>
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
                                	
								<div class="formFieldWrap"  style='margin-bottom:10px'>
                                    <label class="field-title contactNameField" for="barrio">Barrio:<span></span></label>
                                    <input type="text" name="barrio" value="" id="barrio" class="contactField requiredField" /> 
                                </div>
								
								<div class="formFieldWrap"  style='margin-bottom:10px'>
                                    <label class="field-title contactNameField" for="direccion">Direcci&oacute;n:<span></span></label>
                                    <input type="text" name="direccion" value="" id="direccion" class="contactField requiredField" /> 
                                </div>
								
                                <div class="formSubmitButtonErrorsWrap">
                                    <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Buscar" data-formId="contactForm"/>
                                </div>
								
								<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">
									Regresar
								</a>
								
                            </fieldset>
							
							<input type="hidden" name="option" value="com_ztadmin" />
							<input type="hidden" name="task" value="usBuscarServicios" />
							<input type="hidden" id="addData" name="addData" value="" />
							<?php echo JHtml::_( 'form.token' ); ?>
                        </form>       
                    </div>
                </div>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:400px'></div>
			 
		

<?php echo PageHelper::endPage();?>


<script src="templates/chronos/plugins/jquerytokeninput/js/jquery.tokeninput.js" type="text/javascript" ></script> 

<script type='text/javascript'>
jQuery(document).ready(function(){  

	//http://localhost/appmensajes/components/com_ztadmin/autocomplete/grupos.php?user=
	//http://sms.smstechnosoft.com/components/com_ztadmin/autocomplete/contactos.php?user
	//http://localhost/appventamovilunem/components/com_ztadmin/autocomplete/direcciones.php?user=
	
	jQuery("#barrio").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php?user=65&addData=0<?php //echo $user->id; ?>", 
		{
			theme: "facebook",
			hintText: "Escriba el barrio",
			noResultsText: "No existen barrios con estos datos ...",
			searchingText: "Buscando ....",
			minChars: 3,
			showing_all_results: true,
			tokenLimit: 1,
			preventDuplicates: true,
			onAdd: function (item) {
					jQuery("#addData").val(item.id);
            },
		}
	);
	
	jQuery("#direccion").tokenInput("<?php Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/direcciones.php?user=65&addData=0" , 
		{
			theme: "facebook",
			hintText: "Escriba la direcci&oacute;n",
			noResultsText: "No existen direcciones con estos datos ...",
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
