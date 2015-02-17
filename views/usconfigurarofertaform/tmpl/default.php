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

//print_r($this->serviciosTO);
$serviciosTO = $this->serviciosTO;
$serviciosTV = $this->serviciosTV;
$serviciosBA = $this->serviciosBA;
//
$totalPlan = $this->totalPlan;
$totalesAdcionales = $this->totalesAdcionales;
$totales = $this->totales;
$data = $this->data;

?>  
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une");?>
        	<div class="decoration"></div>
			
			<?php PageHelper::showMessage(); ?>
			
			<div class="container no-bottom">
            	<div class="section-title">
					<h4 style='color:red'>Configurar servicios adicionales</h4>
                	<h4></h4>
                    <em>Seleccione los servicios adicionales</em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
			
			
            <div class="decoration"></div>
			
			<!-- Formulario agregar servicio adicional  -->
			<div class="one-half-responsive last-column">
                <div class="container">
                    <div class="toggle-1">
                        <a href="#" class="deploy-toggle-1"> <?php echo "Agregar servicios adicionales" ; ?> </a>
                        <div class="toggle-content">
							
								<div class="container">
									<div class="tabs">
										<a href="#" class="tab-but tab-but-1 tab-active">TO</a>
										<a href="#" class="tab-but tab-but-2">TV</a>
										<a href="#" class="tab-but tab-but-3">BA</a>
									</div>
									
									<!-- Servicios de TO -->
									<div class="tab-content tab-content-1">
										<p>
										
											 <form action="index.php" method="post" class="contactForm" id="contactForm">
												<div class="">
													<p><b>
														<select name="codigo" class="contactField requiredField">
															<option value="">Seleccione el servicio</option>
															<?php foreach($serviciosTO as $item){?>
																<option value="<?php echo $item->codigo ?>" >
																	<?php echo $item->nomserv . " [ $" . Util::number_format($item->tarifa) . " / ". $item->cantinicobro . " / " . $item->cantlimite . "]" ;?>
																</option>
															<?php } ?>
														</select>
													</b></p>
												</div>
												
												<div class="">
														<p><b>
															<select name="cantidad" class="contactField requiredField">
																<option value="">Seleccione la cantidad</option>
																<?php
																	$cant = 1;
																	while($cant < 10){?>
																	<option value="<?php echo $cant ?>" >
																		<?php echo $cant ;?>
																	</option>
																<?php
																	$cant  = $cant + 1;
																	} ?>
															</select>
														</b></p>
												</div>
												
												<div class="">
														<p><b>
															<select name="promo" class="contactField requiredField">
																<option value="">Sin promo</option>
																<option value="50" >Promo 50%</option>
															</select>
														</b></p>
												</div>
												
												 <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Adicionar" data-formId="contactForm"/>
												 
											
												<input type="hidden" name="option" value="com_ztadmin" />
												<input type="hidden" name="task" value="usNuevoServicioAdicional" />
												<input type="hidden" name="tipo" value="TO" />
												<?php echo JHtml::_( 'form.token' ); ?>
											</form>
										</p>
									</div>
									<!-- FIN Servicios de TO -->
									
									<!-- Servicios de TV -->
									<div class="tab-content tab-content-2">
										<p>
											 <form action="index.php" method="post" class="contactForm" id="contactForm">
												<div class="">
													<p><b>
														<select name="codigo" class="contactField requiredField">
															<option value="">Seleccione el servicio</option>
															<?php foreach($serviciosTV as $item){?>
																<option value="<?php echo $item->codigo ?>" >
																	<?php echo $item->nomserv . " [ $" . Util::number_format($item->tarifa) . " / ". $item->cantinicobro . " / " . $item->cantlimite . "]" ;?>
																</option>
															<?php } ?>
														</select>
													</b></p>
												</div>
												
												<div class="">
														<p><b>
															<select name="cantidad" class="contactField requiredField">
																<option value="">Seleccione la cantidad</option>
																<?php
																	$cant = 1;
																	while($cant < 10){?>
																	<option value="<?php echo $cant ?>" >
																		<?php echo $cant ;?>
																	</option>
																<?php
																	$cant  = $cant + 1;
																	} ?>
															</select>
														</b></p>
												</div>
												
												<div class="">
														<p><b>
															<select name="promo" class="contactField requiredField">
																<option value="">Sin promo</option>
																<option value="50" >Promo 50%</option>
															</select>
														</b></p>
												</div>
												
												 <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Adicionar" data-formId="contactForm"/>
												 
											
												<input type="hidden" name="option" value="com_ztadmin" />
												<input type="hidden" name="task" value="usNuevoServicioAdicional" />
												<input type="hidden" name="tipo" value="TV" />
												<?php echo JHtml::_( 'form.token' ); ?>
											</form>
										</p>
									</div>
									<!-- FIN Servicios de TV -->
									
									<!-- Servicios de BA -->
									<div class="tab-content tab-content-3">
										<p>
											 <form action="index.php" method="post" class="contactForm" id="contactForm">
												<div class="">
													<p><b>
														<select name="codigo" class="contactField requiredField">
															<option value="">Seleccione el servicio</option>
															<?php foreach($serviciosBA as $item){?>
																<option value="<?php echo $item->codigo ?>" >
																	<?php echo $item->nomserv . " [ $" . Util::number_format($item->tarifa) . " / ". $item->cantinicobro . " / " . $item->cantlimite . "]" ;?>
																</option>
															<?php } ?>
														</select>
													</b></p>
												</div>
												
												<div class="">
														<p><b>
															<select name="cantidad" class="contactField requiredField">
																<option value="">Seleccione la cantidad</option>
																<?php
																	$cant = 1;
																	while($cant < 10){?>
																	<option value="<?php echo $cant ?>" >
																		<?php echo $cant ;?>
																	</option>
																<?php
																	$cant  = $cant + 1;
																	} ?>
															</select>
														</b></p>
												</div>
												
												<div class="">
														<p><b>
															<select name="promo" class="contactField requiredField">
																<option value="">Sin promo</option>
																<option value="50" >Promo 50%</option>
															</select>
														</b></p>
												</div>
												
												 <input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Adicionar" data-formId="contactForm"/>
												 
											
												<input type="hidden" name="option" value="com_ztadmin" />
												<input type="hidden" name="task" value="usNuevoServicioAdicional" />
												<input type="hidden" name="tipo" value="BA" />
												<?php echo JHtml::_( 'form.token' ); ?>
											</form>
										</p>
									</div>
									<!-- FIN Servicios de BA -->
								
								</div>    

                        </div>
                    </div>
                </div>
			</div>            
			<!-- Fin Formulario Agregar servicio adicional-->
			
            <div class="decoration"></div>
			
			<!-- Formulario de totales de servicios adicionales  -->
			<div class="one-half-responsive last-column">
                <div class="container">
                    <div class="toggle-1">
                        <a href="#" class="deploy-toggle-1"> <?php echo "Total Venta " . " $" . Util::number_format($totales["mensual"] ); ; ?> </a>
                        <div class="toggle-content" id="divTotales">
							
								<div class="container">
									<div class="tabs">
										<a href="#" class="tab-but tab-but-1 tab-active">TO</a>
										<a href="#" class="tab-but tab-but-2">TV</a>
										<a href="#" class="tab-but tab-but-3">BA</a>
									</div>
									
									<!-- Lista de servicios de TO-->
									<div class="tab-content tab-content-1">
										<p>
											<?php 
												$nuevaOferta = Session::getVar("nuevaOferta");

												if( isset($this->serviciosAdi) && count($this->serviciosAdi) >=1 ){
													foreach($this->serviciosAdi as $item){
														if( $item->tipo == "TO" ){
															$promo = ($item->promo == 'S') ? "(P)" : "";
															$borrarEnlace = 'index.php?option=com_ztadmin&task=usEliminarServicioAdicional&codigo=' . $item->codigo;
															
															// Permite borrar el servicio solo si no es un servicio actual
															$borrarServicio = "";
															if($item->grupo != "A"){
																$borrarServicio = "<a href='$borrarEnlace'><span class='delete-list' style='background-size:18px 18px;background-repeat:no-repeat;padding-left:40px'>&nbsp;</span></a>";
															}
											?>
														<div id='servicio1'>
															<div class="one-half">
																<p><b><?php echo $item->descripcion . " x " . $item->cantidad . " ({$item->grupo}) $promo ";  ?> </b></p>
															</div>
															<div class="two-half last-column">
																<p><?php echo "$" . Util::number_format( $item->costo). "&nbsp;&nbsp;" . $borrarServicio; ?></p>
															</div>
														</div>
											<?php
														}
													}
												}
												// Muestra informacion del plan personalizado
												if(isset($nuevaOferta->toData->nomplan)){
													$minutos = "";
													if(isset($data->min_producto)){
														$minutos = " / " . $data->min_producto;
													}
													$iva = $nuevaOferta->toData->valor * 16/100;
													echo "<div>{$nuevaOferta->toData->nomplan} $minutos </div>";
													?>
														<div class="one-half"><p><b>Valor Base</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format($nuevaOferta->toData->valor ,0,'.','.'); ?></p>
														</div>

														<div class="one-half"><p><b>Vlr Iva</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format( $iva  ,0,'.','.'); ?></p>
														</div>


														<div class="one-half"><p><b>Vlr Total</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format( $nuevaOferta->toData->valor+$iva  ,0,'.','.'); ?></p>
														</div>

													<?php
												}


											?>
										</p>
									</div>
									<!-- FIN Lista de servicios de TO-->
									
									<!-- Lista de servicios de TV-->
									<div class="tab-content tab-content-2">
										<p>
											<?php 
												if( isset($this->serviciosAdi) && count($this->serviciosAdi) >=1 ){
													foreach($this->serviciosAdi as $item){
														if( $item->tipo == "TV" ){
															$promo = ($item->promo == 'S') ? "(P)" : "";
															$borrarEnlace = 'index.php?option=com_ztadmin&task=usEliminarServicioAdicional&codigo=' . $item->codigo;
															$borrarServicio = "<a href='$borrarEnlace'><span class='delete-list' style='background-size:18px 18px;background-repeat:no-repeat;padding-left:40px'>&nbsp;</span></a>";
											?>
													<div id='servicio1'>
														<div class="one-half">
															<p><b><?php echo $item->descripcion . " x " . $item->cantidad . " ({$item->grupo}) $promo ";  ?> </b></p>
														</div>
														<div class="two-half last-column">
															<p><?php echo "$" . Util::number_format( $item->costo). "&nbsp;&nbsp;" . $borrarServicio;  ?></p>
														</div>
													</div>
											<?php
														}
													}
												}
												// Muestra informacion del plan personalizado
												if(isset($nuevaOferta->tvData->nomplan)){
				
													echo "<div>{$nuevaOferta->tvData->nomplan}  </div>";
													$iva = $nuevaOferta->tvData->valor * 16/100;
													?>
														<div class="one-half"><p><b>Valor Base</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format($nuevaOferta->tvData->valor ,0,'.','.'); ?></p>
														</div>

														<div class="one-half"><p><b>Vlr Iva</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format( $iva  ,0,'.','.'); ?></p>
														</div>


														<div class="one-half"><p><b>Vlr Total</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format( $nuevaOferta->tvData->valor+$iva  ,0,'.','.'); ?></p>
														</div>

													<?php

												}
											?>
										</p>
									</div>
									<!-- FIN Lista de servicios de TV-->
									
									<!-- Lista de servicios de BA-->
									<div class="tab-content tab-content-3">
										<p>
											<?php 
												if( isset($this->serviciosAdi) && count($this->serviciosAdi) >=1 ){
													foreach($this->serviciosAdi as $item){
														if( $item->tipo == "BA" ){
															$promo = ($item->promo == 'S') ? "(P)" : "";
															$borrarEnlace = 'index.php?option=com_ztadmin&task=usEliminarServicioAdicional&codigo=' . $item->codigo;
															
															// Permite borrar el servicio solo si no es un servicio actual
															$borrarServicio = "";
															if($item->grupo != "A"){
																$borrarServicio = "<a href='$borrarEnlace'><span class='delete-list' style='background-size:18px 18px;background-repeat:no-repeat;padding-left:40px'>&nbsp;</span></a>";
															}
											?>
														<div id='servicio1'>
															<div class="one-half">
																<p><b><?php echo $item->descripcion . " x " . $item->cantidad . " ({$item->grupo}) $promo";  ?> </b></p>
															</div>
															<div class="two-half last-column">
																<p><?php echo "$" . Util::number_format( $item->costo) . "&nbsp;&nbsp;" . $borrarServicio; ; ?></p>
															</div>
														</div>
											<?php
														}
													}
												}
												// Muestra informacion del plan personalizado
												if(isset($nuevaOferta->baData->nomplan)){
													$vel = "";
													if(isset($data->vel_producto)){
														$vel = " / " . $data->vel_producto;
													}
													$iva = $nuevaOferta->baData->valor * 16/100;
													if($data->estrato == 1 || $data->estrato == 2 || $data->estrato == 3){
														$iva = 0;
													}
													
													echo "<div>{$nuevaOferta->baData->nomplan}  $vel </div>";
													?>
														<div class="one-half"><p><b>Valor Base</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format($nuevaOferta->baData->valor ,0,'.','.'); ?></p>
														</div>

														<div class="one-half"><p><b>Vlr Iva</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format( $iva  ,0,'.','.'); ?></p>
														</div>

														<div class="one-half"><p><b>Vlr Total</b></p></div>
														<div class="two-half last-column">
															<p><?php echo "$" . number_format( $nuevaOferta->baData->valor+$iva  ,0,'.','.'); ?></p>
														</div>

													<?php
												}
											?>
										</p>
									</div>
									<!-- FIN Lista de servicios de BA-->
									
								
								</div>    
							
								
							
								<div class="one-half"><p><b>Total Paquete</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . Util::number_format($totalPlan); ?></p></div>
								
								<div class="one-half"><p><b>Total Serv. Adic.</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . number_format($totalesAdcionales['recurrentes'] ,0,'.','.'); ?></p></div>
								
								<div class="one-half"><p><b>Tot. Serv. Adic.(PU)</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . number_format($totalesAdcionales['pagoUnico'] ,0,'.','.'); ?></p></div>
							
								<div class="one-half"><p><b>Total Iva(1Mes)</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . Util::number_format($totales["ivaPrimerMes"] ); ?></p></div>
								
								<div class="one-half"><p><b>Total Pago(1Mes)</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . Util::number_format($totales["primerMes"] ); ?></p></div>
							
								<div class="one-half"><p><b>Total Iva Men.</b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . Util::number_format($totales["ivaMensual"] ); ?></p></div>
								
								<div class="one-half"><p><b>Total Pago Men. </b></p></div>
								<div class="two-half last-column"><p><?php echo "$" . Util::number_format($totales["mensual"] ); ?></p></div>
							
								
                        </div>
                    </div>
                </div>
			</div>            
			<!-- Fin Formulario de totales de servicios adicionales -->
           
            <div class="decoration"></div>
			
			<a href="index.php?option=com_ztadmin&task=usFormularioOsfForm" class="button button-red contactSubmitButton">Registrar Venta</a>
			<a href="index.php?option=com_ztadmin&task=usTipoBusquedaForm" class="button button-red contactSubmitButton">Regresar</a>
			
			<div style='min-height:150px'></div>

<?php echo PageHelper::endPage();?>

<script type='text/javascript'>
	jQuery( document ).ready(function() {
		jQuery('#divTotales').css('display', 'block');
	});
</script>