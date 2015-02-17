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

$data    = $this->data ;
$ofertas = $this->ofertas ;
$otrosDetalles = $this->otrosDetalles;

$totalAdicTO = 0;
$totalAdicTV = 0;
$totalAdicBA = 0;
foreach($data->servAdicionales as $servAdic){
	//print_r($servAdic);
	//echo "<br/><br/><br/>";
	if( $servAdic->tipo == "TO"){
		$totalAdicTO = $servAdic->valor;
	}
	if( $servAdic->tipo == "TV"){
		$totalAdicTV = $servAdic->valor;
	}
	if( $servAdic->tipo == "BA"){
		$totalAdicBA = $servAdic->valor;
	}
}
//exit;
// Datos genericos
$cedula       		    = isset($data->cedula )       		? $data->cedula       		: "";
$nomcliente   		    = isset($data->nomcliente)    		? $data->nomcliente   		: "";
$segmento     		    = isset($data->segmento)      		? $data->segmento     		: "" ;
					 												
$plan         		    = isset($data->plan)          		? $data->plan         		: "" ;
$direc_inst   		    = isset($data->direc_inst)    		? $data->direc_inst   		: "" ;
					    												
$tarifa_paq   		    = isset($data->tarifa_paq)    		? $data->tarifa_paq   		: "" ;
$servicios    		    = isset($data->servicios)     		? $data->servicios    		: "" ;
$tarifa_to    		    = isset($data->tarifa_to)     		? $data->tarifa_to    		: "" ;
$tarifa_ba    		    = isset($data->tarifa_ba)     		? $data->tarifa_ba    		: "" ;
$tarifa_tv    		    = isset($data->tarifa_tv)     		? $data->tarifa_tv    		: "" ;
$min_producto 		    = isset($data->min_producto)  		? $data->min_producto 		: "" ;
$vel_producto 		    = isset($data->vel_producto)  		? $data->vel_producto 		: "" ;
$totalAdicionales       = isset($data->totalAdicionales)    ? $data->totalAdicionales   : "" ;
$totalPaqueteAdic       = $tarifa_paq + $totalAdicionales;

//Calcula el iva de cada tipo de producto incluyendo  servicios adicionales
$totalIvaTO    = ($tarifa_to + $totalAdicTO) * 16 / 100;
$totalIvaTV    = ($tarifa_tv + $totalAdicTV) * 16 / 100;

if( $data->subsidioIva == "SI"){
	$totalIvaBA    = ($totalAdicBA) * 16 / 100;
}
else{
	$totalIvaBA    = ($tarifa_ba + $totalAdicBA) * 16 / 100;	
}


$totalConIvaTO = $tarifa_to +  $totalAdicTO + $totalIvaTO ;
$totalConIvaTV = $tarifa_tv +  $totalAdicTV + $totalIvaTV ;
$totalConIvaBA = $tarifa_ba +  $totalAdicBA + $totalIvaBA ;

// 
$ivaTotalPaqueteAdic =  $totalIvaTO + $totalIvaTV +  $totalIvaBA ;
$totalConIvaPaqueteAdic = $totalPaqueteAdic + $ivaTotalPaqueteAdic;

// Datos de los paquetes
?>  
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une", true);?>
        	<div class="decoration"></div>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'>Detalle del plan</h4>
                	<h4>Cliente: <?php echo $nomcliente; ?></h4>
                    <em><?php echo $direc_inst; ?></em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<!-- Formulario de datos de cliente -->
			
			<div class="one-half-responsive last-column">
                <div class="container">
                    <div class="toggle-1">
                        <a href="#" class="deploy-toggle-1"> <?php echo $plan . " - " . "$" . number_format( $totalConIvaPaqueteAdic ,0,'.','.');; ?> </a>
                        <div class="toggle-content">
							
								<div class="container">
									<div class="tabs">
										<?php  if(strpos($servicios, "TO") !== false){ ?>
											<a href="#" class="tab-but tab-but-1 tab-active">TO</a>
										<?php } ?>
										
										<?php  if(strpos($servicios, "TV") !== false){ ?>
											<a href="#" class="tab-but tab-but-2">TV</a>
										<?php } ?>
										
										<?php  if(strpos($servicios, "BA") !== false){ ?>
											<a href="#" class="tab-but tab-but-3">BA</a>
										<?php } ?>
										
										<?php  if(strpos($servicios, "TO") !== false){ ?>
											<a href="#" class="tab-but tab-but-4">TO(A)</a>
										<?php } ?>
										
										<?php  if(strpos($servicios, "TV") !== false){ ?>
											<a href="#" class="tab-but tab-but-5">TV(A)</a>
										<?php } ?>
										
										<?php  if(strpos($servicios, "BA") !== false){ ?>
											<a href="#" class="tab-but tab-but-6">BA(A)</a>
										<?php } ?>
										
									</div>
									
									<?php  if(strpos($servicios, "TO") !== false){ ?>
										<div class="tab-content tab-content-1">
											<p>
												
												<div class="one-half"><p><b>Valor Base</b></p></div>
												<div class="two-half last-column">
													<p><?php echo "$" . number_format($tarifa_to ,0,'.','.'); ?></p>
												</div>
												
												<div class="one-half"><p><b>Atributo</b></p></div>
												<div class="two-half last-column"><p><?php echo $min_producto; ?></p></div>
												
												<div class="one-half"><p><b>Vlr Adic</b></p></div>
												<div class="two-half last-column"><p><?php echo "$" . number_format($totalAdicTO ,0,'.','.'); ?></p></div>
												
												<div class="one-half"><p><b>Vlr Iva</b></p></div>
												<div class="two-half last-column">
													<p><?php echo "$" . number_format( $totalIvaTO  ,0,'.','.'); ?></p>
												</div>
												
												<div class="one-half"><p><b>Total + Iva</b></p></div>
												<div class="two-half last-column">
												<p><?php echo "$" . number_format( $totalConIvaTO ,0,'.','.'); ?></p>
												</div>
												
												<div class="one-half"><p><b>Inicio Servicio</b></p></div>
												<div class="two-half last-column"><p><?php echo $otrosDetalles["FeIn"]["TO"] ; ?></p></div>
												<div class="one-half"><p><b>Plan Promocional</b></p></div>
												<div class="two-half last-column"><p><?php echo $otrosDetalles["PlanProm"]["TO"] ; ?></p></div>
												<div class="one-half"><p><b>Retenci&oacute;n</b></p></div>
												<div class="two-half last-column"><p><?php echo $otrosDetalles["Reten"]["TO"] ; ?></p></div>
												<div class="one-half"><p><b>Financiaci&oacute;n</b></p></div>
												<div class="two-half last-column"><p><?php echo $otrosDetalles["Finan"]["TO"] ; ?></p></div>
												
											</p>
										</div>
									<?php } ?>
									
									<?php  if(strpos($servicios, "TV") !== false){ ?>
									<div class="tab-content tab-content-2">
										<p>
											<div class="one-half"><p><b>Valor Base</b></p></div>
											<div class="two-half last-column"><p><?php echo "$" . number_format($tarifa_tv ,0,'.','.'); ?></p></div>
											
											<div class="one-half"><p><b>Atributo</b></p></div>
											<div class="two-half last-column"><p>0</p></div>
											
											<div class="one-half"><p><b>Vlr Adic</b></p></div>
											<div class="two-half last-column"><p><?php echo "$" . number_format($totalAdicTV ,0,'.','.'); ?></p></div>
											
											<div class="one-half"><p><b>Vlr Iva</b></p></div>
											<div class="two-half last-column"><p><?php echo "$" . number_format($totalIvaTV ,0,'.','.'); ?></p></div>
											
											<div class="one-half"><p><b>Total + Iva</b></p></div>
											<div class="two-half last-column">
												<p><?php echo "$" . number_format($totalConIvaTV  ,0,'.','.'); ?></p>
											</div>

											<div class="one-half"><p><b>Inicio Servicio</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["FeIn"]["TV"] ; ?></p></div>
											<div class="one-half"><p><b>Plan Promocional</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["PlanProm"]["TV"] ; ?></p></div>
											<div class="one-half"><p><b>Retenci&oacute;n</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["Reten"]["TV"] ; ?></p></div>
											<div class="one-half"><p><b>Financiaci&oacute;n</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["Finan"]["TV"] ; ?></p></div>
											
										</p>
									</div>
									<?php } ?>
									
									<?php  if(strpos($servicios, "BA") !== false){ ?>
									<div class="tab-content tab-content-3">
										<p>
											<div class="one-half"><p><b>Valor Base</b></p></div>
											<div class="two-half last-column"><p><?php echo "$" . number_format($tarifa_ba ,0,'.','.'); ?></p></div>
											
											<div class="one-half"><p><b>Atributo</b></p></div>
											<div class="two-half last-column"><p><?php echo $vel_producto; ?></p></div>
											
											<div class="one-half"><p><b>Vlr Adic</b></p></div>
											<div class="two-half last-column"><p><?php echo "$" . number_format($totalAdicBA ,0,'.','.'); ?></p></div>
											
											<div class="one-half"><p><b>Vlr Iva</b></p></div>
											<div class="two-half last-column"><p><?php echo "$" . number_format($totalIvaBA  ,0,'.','.'); ?></p></div>
											
											<div class="one-half"><p><b>Total + Iva</b></p></div>
											<div class="two-half last-column">
												<p><?php echo "$" . number_format($totalConIvaBA ,0,'.','.'); ?></p>
											</div>       

											<div class="one-half"><p><b>Inicio Servicio</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["FeIn"]["BA"] ; ?></p></div>
											<div class="one-half"><p><b>Plan Promocional</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["PlanProm"]["BA"] ; ?></p></div>
											<div class="one-half"><p><b>Retenci&oacute;n</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["Reten"]["BA"] ; ?></p></div>
											<div class="one-half"><p><b>Financiaci&oacute;n</b></p></div>
											<div class="two-half last-column"><p><?php echo $otrosDetalles["Finan"]["BA"] ; ?></p></div>
											
										</p>
									</div>
									<?php } ?>
									
									<?php  if(strpos($servicios, "TO") !== false){ ?>
										<div class="tab-content tab-content-4">
											<p>
												<ul class="icon-list">
													<?php
														foreach($data->servAdicionales as $servAdic){
															if($servAdic->tipo == "TO"){
																foreach($servAdic->servicios as $itemServicio){
																	?>
																	<li class="tick-list">
																		<?php echo $itemServicio->clase_servicio->nomserv;  ?>
																		<?php echo " x " . $itemServicio->cantidad ;  ?>
																		<?php echo " $" . number_format($itemServicio->valor ,0,'.','.'); ?>
																	</li>
																	<?php
																}
															}
														}
													?>
												</ul> 	                  
											</p>
										</div>
									<?php } ?>
									
									<?php  if(strpos($servicios, "TV") !== false){ ?>
										<div class="tab-content tab-content-5">
											<p>
												<ul class="icon-list">
														<?php
														foreach($data->servAdicionales as $servAdic){
															if($servAdic->tipo == "TV"){
																foreach($servAdic->servicios as $itemServicio){
																	?>
																	<li class="tick-list">
																		<?php echo $itemServicio->clase_servicio->nomserv;  ?>
																		<?php echo " x " . $itemServicio->cantidad ;  ?>
																		<?php echo " $" . number_format($itemServicio->valor ,0,'.','.'); ?>
																	</li>
																	<?php
																}
															}
														}
													?>
												</ul> 	                  
											</p>
										</div>
									<?php } ?>
									
									<?php  if(strpos($servicios, "BA") !== false){ ?>
									<div class="tab-content tab-content-6">
										<p>
											<ul class="icon-list">
													<?php
														foreach($data->servAdicionales as $servAdic){
															if($servAdic->tipo == "BA"){
																foreach($servAdic->servicios as $itemServicio){
																	?>
																	<li class="tick-list">
																		<?php echo $itemServicio->clase_servicio->nomserv;  ?>
																		<?php echo " x " . $itemServicio->cantidad ;  ?>
																		<?php echo " $" . number_format($itemServicio->valor ,0,'.','.'); ?>
																	</li>
																	<?php
																}
															}
														}
													?>
											</ul> 	                  
										</p>
									</div>
								<?php } ?>
									
								</div>    
								
							
								<div class="one-half"><p><b>Totales Paquete</b></p></div><div class="two-half last-column"><p>&nbsp;</p></div>
								
								<div class="one-half"><p><b>Total Base</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . number_format($tarifa_paq ,0,'.','.'); ?></p></div>
								
								<div class="one-half"><p><b>Total Adic</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . number_format($totalAdicionales ,0,'.','.'); ?></p></div>
								
								<div class="one-half"><p><b>Total Iva</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . number_format($ivaTotalPaqueteAdic,0,'.','.'); ?></p></div>
								
								<div class="one-half"><p><b>Total + Iva</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . number_format($totalConIvaPaqueteAdic ,0,'.','.'); ?></p></div>
													
								
								
                        </div>
                    </div>
                </div>
			</div>
			
			<div class="decoration"></div>
			
			<div class="container no-bottom">
					<div class="section-title">
						<h4>Ofertas</h4>
						<em>Ofertas para sugerir al cliente</em>
						<strong><img src="images/misc/icons/applications.png" width="20" alt="img"></strong>
					</div>
			</div>
			<div class="decoration"></div>
			
			<?php 
			foreach($ofertas as $item){ 
				
				// Obtiene totales de la oferta
				$totalAdicOferta         = $item->totalAdicionales ;
				$totalConIvaTOOferta     = $item->vlrTO +  $item->ivaTO  + $item->vlrAdicTO + $item->vlrIvaAdicTO  ;
				$totalConIvaTVOferta     = $item->vlrTV +  $item->ivaTV  + $item->vlrAdicTV + $item->vlrIvaAdicTV  ;
				$totalConIvaBAOFerta     = $item->vlrBA +  $item->ivaBA  + $item->vlrAdicBA + $item->vlrIvaAdicBA  ;
				$totalConIvaOfertaAdic   = $item->totalConIva ;
			?>			
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1"><?php echo $item->nomOferta . " " . 
					                                         "$" . number_format($totalConIvaOfertaAdic ,0,'.','.'); ?></a>
					<div class="toggle-content">
					   
						<div class="container">
							<div class="tabs">
								<?php  if( $item->vlrTO  >0 ){ ?>
									<a href="#" class="tab-but tab-but-1 tab-active">TO</a>
								<?php } ?>
								
								<?php  if( $item->vlrTV  >0 ){ ?>
									<a href="#" class="tab-but tab-but-2">TV</a>
								<?php } ?>
							
								<?php  if( $item->vlrBA  >0 ){ ?>
									<a href="#" class="tab-but tab-but-3">BA</a>
								<?php } ?>
									
								<?php  if(strpos($item->adicionales, "TO") !== false){ ?>
									<a href="#" class="tab-but tab-but-4">TO(A)</a>
								<?php } ?>
								
								<?php  if(strpos($item->adicionales, "TV") !== false){ ?>
									<a href="#" class="tab-but tab-but-5">TV(A)</a>
								<?php } ?>
								
								<?php  if(strpos($item->adicionales, "BA") !== false){ ?>
									<a href="#" class="tab-but tab-but-6">BA(A)</a>
								<?php } ?>
								
							</div>
							
							<?php  if( $item->vlrTO  >0 ){ ?>
								<div class="tab-content tab-content-1">
									<p>
										
										<div class="one-half"><p><b>Valor Base</b></p></div>
										<div class="two-half last-column">
											<p><?php echo "$" . number_format($item->vlrTO ,0,'.','.') . "/" . "$" . number_format($tarifa_to ,0,'.','.'); ?> </p>
										</div>
										
										<div class="one-half"><p><b>Atributo</b></p></div>
										<div class="two-half last-column"><p><?php echo $item->minutos; ?> / <?php echo $min_producto; ?></p></div>
										
										<div class="one-half"><p><b>Vlr Adic</b></p></div><div class="two-half last-column">
											<p><?php echo "$" . number_format($totalAdicTO ,0,'.','.'); ?> </p>
										</div>
										
										<div class="one-half"><p><b>Vlr Iva</b></p></div>
										<div class="two-half last-column">
											<p>
											<?php echo "$" . number_format($item->ivaTO ,0,'.','.') . "/  $" . number_format($tarifa_to *16/100 ,0,'.','.'); ?>
											</p>
										</div>
										
										<div class="one-half"><p><b>Total + Iva</b></p></div>
										<div class="two-half last-column"><p><?php echo "$" . number_format($totalConIvaTOOferta ,0,'.','.'); ?> / 
																			<?php echo "$" . number_format( $totalConIvaTO ,0,'.','.'); ?>
																		  </p>
										</div>
										
									</p>
								</div>
							<?php } ?>
							
							<?php  if( $item->vlrTV  >0 ){ ?>
								<div class="tab-content tab-content-2">
									<p>
										<div class="one-half"><p><b>Valor Base</b></p></div>
										<div class="two-half last-column">
											<p><?php echo "$" . number_format($item->vlrTV ,0,'.','.') . "/" . "$" . number_format($tarifa_tv ,0,'.','.'); ?></p>
										</div>
										
										<div class="one-half"><p><b>Atributo</b></p></div><div class="two-half last-column"><p>0 / 0</p></div>
										
										<div class="one-half"><p><b>Vlr Adic</b></p></div><div class="two-half last-column">
										<p><?php echo "$" . number_format($totalAdicTV ,0,'.','.'); ?>/ $0</p></div>
															  
										<div class="one-half"><p><b>Vlr Iva</b></p></div>
										<div class="two-half last-column">
											<p>
											<?php echo "$" . number_format($item->ivaTV ,0,'.','.') . "/  $" . number_format($tarifa_tv *16/100 ,0,'.','.'); ?>
											</p>
										</div>
										
										<div class="one-half"><p><b>Total + Iva</b></p></div><div class="two-half last-column">
										<p><?php echo "$" . number_format($totalConIvaTVOferta ,0,'.','.'); ?> / 
										   <?php echo "$" . number_format($totalConIvaTV ,0,'.','.'); ?></p></div>      
										
									</p>
								</div>
							<?php } ?>
							
							<?php  if( $item->vlrBA  >0 ){ ?>
							<div class="tab-content tab-content-3">
								<p>
									<div class="one-half"><p><b>Valor Base</b></p></div>
									<div class="two-half last-column">
										<p><?php echo "$" . number_format($item->vlrBA ,0,'.','.') . "/" . "$" . number_format($tarifa_ba ,0,'.','.'); ?></p>
									</div>
									
									<div class="one-half"><p><b>Atributo</b></p></div>
									<div class="two-half last-column"><p><?php echo $item->velocidad; ?> / <?php echo $vel_producto; ?></p></div>
									
									<div class="one-half"><p><b>Vlr Adic</b></p></div><div class="two-half last-column">
														  <p><?php echo "$" . number_format($totalAdicBA ,0,'.','.'); ?></p></div>
														  
									<div class="one-half"><p><b>Vlr Iva</b></p></div>
									<div class="two-half last-column">
										<p>
										<?php echo "$" . number_format($item->ivaBA ,0,'.','.') . "/  $" . number_format($tarifa_ba *16/100 ,0,'.','.'); ?>
										</p>
									</div>
									
									<div class="one-half"><p><b>Total + Iva</b></p></div>
									<div class="two-half last-column">
										<p><?php echo "$" . number_format($totalConIvaBAOFerta ,0,'.','.'); ?> / 
										   <?php echo "$" . number_format($totalConIvaBA ,0,'.','.'); ?></p></div>                  
								</p>
							</div>
							<?php } ?>
							
							<?php  if(strpos($item->adicionales, "TO") !== false){ ?>
								<div class="tab-content tab-content-4">
									<p>
										<ul class="icon-list">
											
											<?php
												foreach($item->servAdicionales as $servAdic){
													if($servAdic->tipo == "TO"){
														foreach($servAdic->servicios as $itemServicio){
															?>
															<li class="tick-list">
																<?php echo $itemServicio->clase_servicio->nomserv;  ?>
																<?php echo " $" . number_format($itemServicio->valor ,0,'.','.'); ?>
															</li>
															<?php
														}
													}
												}
											?>
											
										</ul> 	                  
									</p>
								</div>
							<?php } ?>
							
							<?php  if(strpos($item->adicionales, "TV") !== false){ ?>
								<div class="tab-content tab-content-5">
									<p>
										<ul class="icon-list">
											<?php
												foreach($item->servAdicionales as $servAdic){
													if($servAdic->tipo == "TV"){
														foreach($servAdic->servicios as $itemServicio){
															?>
															<li class="tick-list">
																<?php echo $itemServicio->clase_servicio->nomserv;  ?>
																<?php echo " $" . number_format($itemServicio->valor ,0,'.','.'); ?>
															</li>
															<?php
														}
													}
												}
											?>
										</ul> 	                  
									</p>
								</div>
							<?php } ?>
							
							<?php  if(strpos($item->adicionales, "BA") !== false){ ?>
								<div class="tab-content tab-content-6">
									<p>
										<ul class="icon-list">
											<?php
												foreach($item->servAdicionales as $servAdic){
													if($servAdic->tipo == "BA"){
														foreach($servAdic->servicios as $itemServicio){
															?>
															<li class="tick-list">
																<?php echo $itemServicio->clase_servicio->nomserv;  ?>
																<?php echo " $" . number_format($itemServicio->valor ,0,'.','.'); ?>
															</li>
															<?php
														}
													}
												}
											?>
										</ul> 	                  
									</p>
								</div>
							<?php } ?>
							
						</div>    	
						
						<div class="one-half"><p><b>Totales Paquete</b></p></div><div class="two-half last-column"><p>&nbsp;</p></div>
						
						<div class="one-half"><p><b>Total Base</b></p></div>
						<div class="two-half last-column"><p><?php echo " $" . number_format($item->vlrProds ,0,'.','.'); ?> / <?php echo number_format($tarifa_paq ,0,'.','.');?></p></div>
						
						<div class="one-half"><p><b>Total Adic</b></p></div>
						<div class="two-half last-column"><p><?php echo " $" . number_format($totalAdicOferta ,0,'.','.'); ?>/ <?php echo "$" . number_format($totalAdicionales  ,0,'.','.'); ?></p></div>
						
						
						<div class="one-half"><p><b>Total Iva</b></p></div>
						<div class="two-half last-column"><p><?php echo " $" . number_format($item->vlrOferta *16/100 ,0,'.','.'); ?> / <?php echo "$" . number_format($totalPaqueteAdic * 16/100 ,0,'.','.'); ?></p></div>
						
						
						
						<div class="one-half"><p><b>Total + Iva</b></p></div><div class="two-half last-column">
						<p><?php echo " $" . number_format($totalConIvaOfertaAdic ,0,'.','.'); ?> / 
						   <?php echo "$" . number_format($totalConIvaPaqueteAdic ,0,'.','.'); ?></p></div>
						
						<div class="one-half"><p><b>Diferencia</b></p></div>
						<div class="two-half last-column"><p><?php echo " $" . number_format($totalConIvaOfertaAdic - $totalConIvaPaqueteAdic ,0,'.','.'); ?></p></div>
						
						<div class="container no-bottom">
							<p style='text-align:center'>
								<a class="button button-red center-button" href="index.php?option=com_ztadmin&task=usSeleccionarOferta&oferta=<?php echo $item->idOferta; ?>&opcion=<?php echo $item->opcion; ?>">
									Elegir Oferta
								</a>
							</p>
						</div>
						  
					</div>
				</div>
            </div>
			<?php } ?>
			
			<a href="index.php?option=com_ztadmin&task=usCrearOFertaForm" class="button button-red contactSubmitButton">Crear nueva oferta</a>
			<a href="index.php?option=com_ztadmin&task=usBuscarServicios" class="button button-red contactSubmitButton">Regresar</a>
    	
			<div style='min-height:150px'></div>
           
            
            <div class="decoration"></div>

<?php echo PageHelper::endPage();?>