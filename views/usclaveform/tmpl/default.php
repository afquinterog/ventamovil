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

$data = $this->data ;

// Datos genericos
$cedula    = isset($data[0]->cedula )     ? $data[0]->cedula    : "";
$nomcliente = isset($data[0]->nomcliente) ? $data[0]->nomcliente : "";
$segmento   = isset($data[0]->segmento)   ? $data[0]->segmento   : "" ;

// Datos de los paquetes
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
			
			<!-- Formulario de datos de cliente -->
			 <div class="decoration"></div>
			
			 <div class="one-half-responsive last-column">
                <div class="container">
                    <div class="toggle-1">
                        <a href="#" class="deploy-toggle-1">Datos del cliente</a>
                        <div class="toggle-content">
							
								<div class="one-half">
									<p><b>Cedula cliente</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $cedula; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Nombres</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $nomcliente; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Segmento</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $segmento; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Scoring</b></p>
								</div>
								<div class="two-half last-column">
									<p>A</p>        
								</div>
								
                        </div>
                    </div>
                </div>
                
				<?php foreach($data as $item){ ?>
				
                <div class="container">
                    <div class="toggle-2">
                        <a href="#" class="deploy-toggle-1"><?php echo $item->plan; ?></a>
                        <div class="toggle-content">
                           
								<div class="one-half">
									<p><b>Producto</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $item->producto; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Categor&iacute;a</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $item->categoria; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Sub-Categor&iacute;a</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $item->subcategoria; ?></p>        
								</div>
								
								
								<div class="one-half">
									<p><b>Municipio</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $item->nom_mpio; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Direccion</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo $item->direc_inst; ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Saldo pendiente</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo "$" . number_format($item->saldo_pendiente ,0,'.','.'); ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Tarifa paquete</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo "$" . number_format($item->tarifa_paq ,0,'.','.'); ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Adicionales</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo "$" . number_format($item->totalAdicionales ,0,'.','.'); ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Iva Tarifa</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo "$" . number_format($item->tarifa_paq * 16/100 ,0,'.','.'); ?></p>        
								</div>
								
								<div class="one-half">
									<p><b>Total Tarifa con Iva</b></p>
								</div>
								<div class="two-half last-column">
									<p><?php echo "$" . number_format($item->tarifa_paq + $item->tarifa_paq * 16/100 ,0,'.','.'); ?></p>        
								</div>
								
								<div class="">
									<p><a class="button button-red center-button" href='index.php?option=com_ztadmin&task=usDetallePlan&producto=<?php echo $item->producto; ?>'>Ver Detalles</a></p>        
								</div>
                        </div>
                    </div>
                </div>
				<?php } ?>
            </div>
            <!-- Fin Formulario de datos de cliente -->
    	
			<div style='min-height:150px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>