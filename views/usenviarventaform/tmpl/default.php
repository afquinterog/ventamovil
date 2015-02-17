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
$venta=$this->venta;

?>
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une", true);?>
        	<div class="decoration"></div>
				
			
			<div class="container no-bottom">
            	<div class="section-title">
                	<h2>Formulario de solicitud de venta</h2>
					<h4>Cliente: <?php echo $venta->nombres; ?> </h4>
					<em>Oferta:  <?php echo $venta->oferta; ?> </em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<form action="index.php" method="post" class="contactForm" id="contactForm">
		
		
			<!-- Datos de agendamiento -->
			   <div class="container">
				<div class="toggle-2">
				 <a href="#" class="deploy-toggle-1">Datos de agendamiento</a>
				 <div class="toggle-content">
				 
				  <div class="container no-bottom" ><p><b>Fecha</b></p></div>
				  <div class="container no-bottom" >
				   <input type="date" id="fecha" name="fecha" class="contactField requiredField"/>
				  </div>
				  
				  <div class="container no-bottom" ><p><b>Jornada</b></p></div>
				  <div class="container no-bottom" ><p>
				   <select name="buscarPor" class="contactField requiredField" id="buscarPor">
					 <option value="">Seleccione la jornada</option>
					 <option value="D">AM</option>
					 <option value="S">PM</option>
				   </select>
				   </p>
				  </div>
				  
				 </div>
				</div>
			
				<div class="formSubmitButtonErrorsWrap">
					<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Enviar" data-formId="contactForm"/>
				</div>
				<input type="hidden" name="option" value="com_ztadmin" />
				<input type="hidden" name="task" value="usRegistroOsf" />
				<?php echo JHtml::_( 'form.token' ); ?>
			</form>
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>

<script src="templates/chronos/plugins/jquerytokeninput/js/jquery.tokeninput.js" type="text/javascript" ></script> 

<script type='text/javascript'>
jQuery(document).ready(function(){  

	//http://localhost/appmensajes/components/com_ztadmin/autocomplete/grupos.php?user=
	//http://sms.smstechnosoft.com/components/com_ztadmin/autocomplete/contactos.php?user
	//http://localhost/appventamovilunem/components/com_ztadmin/autocomplete/direcciones.php?user=
	
	jQuery("#direccion").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/direcciones.php?user=65<?php //echo $user->id; ?>", 
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
	
	jQuery("#direccionCobro").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/direcciones.php?user=65<?php //echo $user->id; ?>", 
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
	
	jQuery("#barrio").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php", 
        {
         theme: "facebook",
         hintText: "Elija el barrio",
         noResultsText: "No existen barrios con estos datos ...",
         searchingText: "Buscando ....",
         minChars: 0,
         showing_all_results: true,
         tokenLimit: 1,
         preventDuplicates: true 
        }
	);
	
	jQuery("#barrioCobro").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php", 
        {
         theme: "facebook",
         hintText: "Elija el barrio",
         noResultsText: "No existen barrios con estos datos ...",
         searchingText: "Buscando ....",
         minChars: 0,
         showing_all_results: true,
         tokenLimit: 1,
         preventDuplicates: true 
        }
	);
	
	jQuery("#subCategoria").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/categorias.php", 
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
	
	jQuery("#referidor").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/referidores.php", 
        {
         theme: "facebook",
         hintText: "Elija el referidor",
         noResultsText: "No existen referidores con estos datos ...",
         searchingText: "Buscando ....",
         minChars: 0,
         showing_all_results: true,
         tokenLimit: 1,
         preventDuplicates: true 
        }
	);
	
	jQuery("#content").css("z-index", "1");
	jQuery("#sidebar").css("z-index", "0");
	
	// Despliega formulario de nueva direccion o de direccion existente
	jQuery('#chNuevaDireccion').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#divDireccionExistente").hide();
			jQuery("#divNuevaDireccionExistente").show();		
        }
		else{
			jQuery("#divDireccionExistente").show();
			jQuery("#divNuevaDireccionExistente").hide();
		}
    });
	
	// Despliega formulario de direccion de cobro
	jQuery('#chIgualDireccion').click(function() {
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#divDireccionCobro").hide();
        }
		else{
			jQuery("#divDireccionCobro").show();
		}
    });
	
	// Despliega formulario de nueva direccion o de direccion existente de cobro
	jQuery('#chNuevaDireccionCobro').click(function() {
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#divDireccionExistenteCobro").hide();
			jQuery("#divNuevaDireccionExistenteCobro").show();
			
        }
		else{
			jQuery("#divDireccionExistenteCobro").show();
			jQuery("#divNuevaDireccionExistenteCobro").hide();
		}
    });
	
	
	
	
	
});
</script>