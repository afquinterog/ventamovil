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

// print_r($data);
	$data = explode('|',$this->data) ;

//$scoring = $this->scoring;

// Datos motivo

$motivo		= isset($data[0]) ? $data[0] : "&nbsp;";
$cedula		= isset($data[1]) ? $data[1] : "&nbsp;";
$nombre		= isset($data[2]) ? $data[2] : "&nbsp;";
$apellido	= isset($data[3]) ? $data[3] : "&nbsp;";
$tyMotivo	= isset($data[4]) ? $data[4] : "&nbsp;";
$tyServicio	= isset($data[5]) ? $data[5] : "&nbsp;";
$estaMoti	= isset($data[6]) ? $data[6] : "&nbsp;";

// Datos del Motivo
?>  
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une", true);?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'>Resultados</h4>
                	<h4></h4>
                    <em>Resultados de la b&uacute;squeda</em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
			
			
            <div class="decoration"></div>
			
			
			<?php if($data == ""){ ?>
				
				<div class="one-half-responsive">
                    <div class="static-notification-red">
                        <p class="center-text uppercase">No se encontr&oacute; informaci&oacute;n!</p>
                    </div>
                </div>
				<div style='min-height:220px'></div>	
				
			
			<?php }else{ 
			
							
			?>
			
				<!-- Formulario de datos de cliente -->
				<div class="one-half-responsive last-column">
					<div class="container">
						<div class="toggle-1">
							<a href="#" class="deploy-toggle-1">Datos del motivo</a>
							<div class="toggle-content">
								
									<div class="one-half">
										<p><b>Motivo</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $motivo; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>C&eacute;dula</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $cedula; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Nombre</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $nombre; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Apellido</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $apellido; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Tipo Motivo</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $tyMotivo; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Tipo Servicio</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $tyServicio; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Estado Motivo</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $estaMoti; ?></p>        
									</div>
									
							</div>
						</div>
					</div>
					<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">
									Regresar
					</a>
					<?php } ?>
				</div>
				<!-- Fin Formulario de datos de cliente -->
	
			
			
    	
			<div style='min-height:150px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>