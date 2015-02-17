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
$otrosDetalles = $this->otrosDetalles;
$scoring = isset($this->scoring) ? $this->scoring : "" ;


// Datos genericos
$cedula     = isset($data[0]->cedula )     ? $data[0]->cedula    : "&nbsp;";
$nomcliente = isset($data[0]->nomcliente)  ? $data[0]->nomcliente : "&nbsp;";
$segmento   = isset($data[0]->segmento)    ? $data[0]->segmento   : "&nbsp;" ;

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
			
			
			<?php if($data == ""){ ?>
				
				<div class="one-half-responsive">
                    <div class="static-notification-red">
                        <p class="center-text uppercase">No se encontr&oacute; informaci&oacute;n!</p>
                    </div>
                </div>
				
				<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">Regresar</a>
				
				<div style='min-height:220px'></div>	
				
			
			<?php }else if( $scoring == "N"){ ?>
				
				<div class="one-half-responsive">
                    <div class="static-notification-red">
                        <p class="center-text uppercase">No existen datos del cliente!</p>
                    </div>
                </div>
				<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">Regresar</a>
				<div style='min-height:220px'></div>	
			
			<?php }else{ 
			
				if($scoring != ""  && $scoring != "Aprobado"){
					$scoring[11] = isset($scoring[11]) ? $scoring[11] : "0";
					$valor = "$" . Util::number_format($scoring[4],0);
					$contrato = $scoring[0]; 
					$valor2 = "$" . Util::number_format($scoring[11],0);
					$contrato2 = $scoring[7]; 
					$msgScoring = "Rechazado<br/> Contrato: $contrato<br/>Deuda: $valor ";
					if( $valor2 != "" && $contrato2 != "" ){
						$msgScoring .= "<br/><br/>Contrato: $contrato2<br/>Deuda: $valor2 ";
						$totalDeuda = "$".Util::number_format($scoring[4] + $scoring[11],0);
						$msgScoring .= "<br/><br/>Total Deuda:{$totalDeuda}<br/>";
					}
				}
				else{
					$msgScoring = $scoring;
				}
				
			?>
			
				<!-- Formulario de datos de cliente -->
				<div class="one-half-responsive last-column">
					<div class="container">
						<div class="toggle-1">
							<a href="#" class="deploy-toggle-1">Datos del cliente</a>
							<div class="toggle-content">
									
									<?php if (isset($this->cobertura)) {?>
											<div class="one-half">
												<p><b>Cobertura</b></p>
											</div>
											<div class="two-half last-column">
												<p><?php echo $this->cobertura; ?></p>        
											</div>
									<?php } ?>
								
								
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
										<p><?php echo $msgScoring; ?></p>        
									</div>
									
							</div>
						</div>
					</div>
					
					<?php foreach($data as $item){ 
						$item->totalAdicionales = isset($item->totalAdicionales ) ? $item->totalAdicionales : "0";

					?>
					
					<!-- Planes actuales del cliente -->
					<form action="index.php" method="post" class="contactForm" id="contactForm">
					<div class="container">
						<div class="toggle-2">
							<a href="#" class="deploy-toggle-1"><?php echo ($item->plan) != "" ? $item->plan : "Sin informaci&oacute;n del plan" ; ?></a>
							<div class="toggle-content">
							   
							   
									<div class="one-half">
										<p><b>Contrato</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $item->contrato; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Estado</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $item->desc_estado; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Producto</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $item->producto; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Inicio Servicio</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $item->fecha_inicio; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Plan Promocional</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $otrosDetalles["PlanProm"][$item->producto]; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Retenci&oacute;n</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $otrosDetalles["Reten"][$item->producto]; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Financiaci&oacute;n</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $otrosDetalles["Finan"][$item->producto]; ?></p>        
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
									
									<div class="container no-bottom"><p><b>Sub-Categor&iacute;a Actual</b></p></div>
									<div class="container no-bottom">
										<p>
											<input type="text" name="subCategoria" value="" id="subCategoria" class="contactField requiredField" /> 
										</p>
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
										<p><b>Cobertura</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo isset($otrosDetalles["Cobertura"][$item->producto]) ? $otrosDetalles["Cobertura"][$item->producto]: "Sin Informaci&oacute;n"; ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Saldo pend.</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo "$" . number_format($item->saldo_pendiente ,0,'.','.'); ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Cuentas saldo</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo $item->cuentas_con_saldo; ?></p>        
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
										<p><?php echo "$" . number_format($item->iva ,0,'.','.'); ?></p>        
									</div>
									
									<div class="one-half">
										<p><b>Total Tarifa+Iva</b></p>
									</div>
									<div class="two-half last-column">
										<p><?php echo "$" . number_format($item->tarifa_paq + $item->iva ,0,'.','.'); ?></p>        
									</div>
									
									
									<div class="">
										<p><input type="submit" class="button button-red center-button" id="paso1Btn" value="Ver detalles" data-formId="contactForm"/></p>
										      
									</div>
							</div>
						</div>
					</div>
						<input type="hidden" name="option" value="com_ztadmin" />
						<input type="hidden" name="task" value="usDetallePlan" />
						<input type="hidden" name="producto" value="<?php echo $item->producto; ?>" />
						<?php echo JHtml::_( 'form.token' ); ?>
					</form>
					<!-- Fin Planes actuales del cliente -->
					<?php } ?>
				</div>
				<!-- Fin Formulario de datos de cliente -->
			<?php } ?>
			

			<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">Regresar</a>
    	
			<div style='min-height:150px'></div>
			
           
            
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
	
	jQuery("#content").css("z-index", "1");
	jQuery("#sidebar").css("z-index", "0");
	
	
});
</script>