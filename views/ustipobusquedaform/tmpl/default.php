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
					<h4 style='color:red'>Tipo de b&uacute;squeda</h4>
                	<h4></h4>
                    <em>Seleccione el tipo de b&uacute;squeda</em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
			
			
            <div class="decoration"></div>
			
			<!-- Formulario de datos de cliente -->
			<div class="one-half-responsive">
               
                <div class="container no-bottom">
                    <div class="contact-form no-bottom"> 
                       
					   
					   
						<a href="index.php?option=com_ztadmin&task=usBuscarCedulaForm" class="button button-red contactSubmitButton">
							Buscar por c&eacute;dula
						</a>
						<a href="index.php?option=com_ztadmin&task=usBuscarServicioForm" class="button button-red contactSubmitButton">
							Buscar por n&uacute;mero de servicio
						</a>
						<a href="index.php?option=com_ztadmin&task=usBuscarDireccionForm" class="button button-red contactSubmitButton">
							Buscar por direcci&oacute;n
						</a>
						
						<a href="index.php?option=com_ztadmin&task=usBuscarMotivoForm" class="button button-red contactSubmitButton">
							Consulta Estado Motivo 
						</a>
						
						<a href="index.php?option=com_ztadmin&task=usSeleccionarEstratoForm" class="button button-red contactSubmitButton">
							Crear oferta 
						</a>
						
						<a href="index.php?option=com_ztadmin&task=usDashboard" class="button button-red contactSubmitButton">
							Regresar
						</a>
                    
                      
                    </div>
                </div>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:400px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>