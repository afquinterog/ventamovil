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

$cliente = $this->cliente;

$oferta = Session::getVar("ofertaSeleccionada");
$nuevaOferta = Session::getVar("nuevaOferta");


// obtiene datos post del formulario anterior
$post = Session::getVar("post");

// Establece el titulo de formulario de acuerdo al plan seleccionado
$clienteForm = isset($cliente->nomcliente) ? $cliente->nomcliente : "";
$ofertaForm =  isset($oferta->nomOferta) ? $oferta->nomOferta : "";
if($ofertaForm == ""){
	$ofertaForm = "Oferta personalizada";
	$text = "";
	if(isset($nuevaOferta->toData->nomplan)){
		$text = $text . "Plan TO: {$nuevaOferta->toData->nomplan} , ";
		$ofertaForm = $ofertaForm . "<br/><em>Plan TO: {$nuevaOferta->toData->nomplan}  </em>";
	}
	if(isset($nuevaOferta->tvData->nomplan)){
		$text = $text . "Plan TV: {$nuevaOferta->tvData->nomplan} , ";
		$ofertaForm = $ofertaForm . "<br/><em>Plan TV: {$nuevaOferta->tvData->nomplan}  </em>";
	}
	if(isset($nuevaOferta->baData->nomplan)){
		$text = $text . "Plan BA: {$nuevaOferta->baData->nomplan} , ";
		$ofertaForm = $ofertaForm . "<br/><em>Plan BA: {$nuevaOferta->baData->nomplan}  </em>";
	}
	Session::setVar("nombreOfertaCustomizada", $text);
}

// Datos de cliente
$cedula = isset($post['cedula']) ? $post['cedula'] : "" ;
if( $cedula == "") {
	$cedula = isset($cliente->cedula) ? $cliente->cedula : "" ;
}

$nombres = $post['nombres'];
if( $nombres == "") {
	$nombres = isset($cliente->nomcliente) ? $cliente->nomcliente : "" ;
}

$apellidos = isset($post['apellidos']) ? $post['apellidos'] : "" ;
$tel_aux   = isset($post['tel_aux']) ? $post['tel_aux'] : "" ;
$celular1  = isset($post['celular1']) ? $post['celular1'] : "" ;
$celular2  = isset($post['celular2']) ? $post['celular2'] : "" ;
$correo    = isset($post['correo']) ? $post['correo'] : "" ;

// Datos de direccion
$tbarrio     = isset($post["tbarrio"])   ? $post["tbarrio"] : "";  
$barrio      = isset($post["barrio"])    ? $post["barrio"] : "";  
$idDireccion = isset($post["direccion"]) ? $post["direccion"] : "";
$direccion   = isset($post["tdireccion"]) ? $post["tdireccion"] : "";

$cnuevaDireccion = isset($post["cnuevadireccion"]) &&  $post["cnuevadireccion"] == 1 ? "checkbox-one-checked" : "";
if($cnuevaDireccion != ""){
	$divNuevaDireccion = "display:block";
	$divDireccion   = "display:none";
	$cNuevaDireccionVal = 1;
}
else{
	$divDireccion = "display:block";
	$divNuevaDireccion   = "display:none";
	$cNuevaDireccionVal = 0;
}
$tbarrioN        = isset($post["tbarrioN"])   ? $post["tbarrioN"] : "";  
$barrioN         = isset($post["barrioN"])    ? $post["barrioN"] : "";  
$direccionNueva  = isset($post['direccionNueva']) ? $post['direccionNueva'] : "" ;
	
if($direccion == ""){
	$idDireccion = isset($cliente->id_direccion) ? $cliente->id_direccion : "";
	$direccion   = isset($cliente->direc_inst)   ? $cliente->direc_inst   : "";
}

// Direccion de cobro
$tbarrioC     = isset($post["tbarrioC"])   ? $post["tbarrioC"] : "";  
$barrioC      = isset($post["barrioC"])    ? $post["barrioC"] : "";  
$idDireccionCobro = isset($post["direccionCobro"]) ? $post["direccionCobro"] : "";
$direccionCobro   = isset($post["tdireccionCobro"]) ? $post["tdireccionCobro"] : "";

$tbarrioCN     = isset($post["tbarrioCN"])   ? $post["tbarrioCN"] : "";  
$barrioCN      = isset($post["barrioCN"])    ? $post["barrioCN"] : "";  

$direccionNuevaCobro = isset($post["direccionNuevaCobro"])    ? $post["direccionNuevaCobro"] : "";  

$cigualdireccion = isset($post["cigualdireccion"]) &&  $post["cigualdireccion"] == 1 ? "checkbox-one-checked" : "";
if($cigualdireccion != ""){
	$divDirCobro = "display:none";
	$cIgualDireccionVal = 1;
}
else{
	$divDirCobro = "display:block";
	$cIgualDireccionVal = 0;
}

$cnuevaDireccionCobro = isset($post["cnuevadireccioncobro"]) &&  $post["cnuevadireccioncobro"] == 1 ? "checkbox-one-checked" : "";
if($cnuevaDireccionCobro != ""){
	$divDireccionCobro = "display:none";
	$divNuevaDireccionCobro = "display:block";
	$cNuevaDireccionCobroVal = 1;
}
else{
	$divNuevaDireccionCobro = "display:none";
	$divDireccionCobro = "display:block";
	$cNuevaDireccionCobroVal = 0;
}

//Datos adicionales de servcio
$tiposSolicitud = $this->tiposSolicitud;
$tipoSolicitud = isset($post['tipoSolicitud']) ? $post['tipoSolicitud'] : "";
$ciclo = isset($post['ciclo']) ? $post['ciclo'] : "";
if($ciclo == ""){
	$ciclo = isset($cliente->ciclo) ? $cliente->ciclo : "" ;
}

$vendedor = isset($post['vendedor']) ? $post['vendedor'] : "";
$tsubCategoria = isset($post['tsubCategoria']) ? $post['tsubCategoria'] : "";
$subCategoria = isset($post['subCategoria']) ? $post['subCategoria'] : "";
$tipoContacto = isset($post['tipoContacto']) ? $post['tipoContacto'] : "";
$referidor = isset($post['referidor']) ? $post['referidor'] : "";
$treferidor = isset($post['treferidor']) ? $post['treferidor'] : "";
$acierta = isset($post['acierta']) ? $post['acierta'] : "";
$transaccion = isset($post['transaccion']) ? $post['transaccion'] : "";
$observaciones = isset($post['observaciones']) ? $post['observaciones'] : "";

//Categoria
if( $tsubCategoria == "" && $subCategoria == "" && isset($this->subcategoria->id) &&  $this->subcategoria->id >0  ){
	$tsubCategoria = $this->subCategoriaActual;
	$subCategoria  = $this->subcategoria->id;
}

//Datos de financiacion
$contratoMora = isset($post['contratoMora']) ? $post['contratoMora'] : "";
$valorPendiente = isset($post['valorPendiente']) ? $post['valorPendiente'] : "";
$tipoProdFin = isset($post['tipoProdFin']) ? $post['tipoProdFin'] : "";
$prodFinan = isset($post['prodFinan']) ? $post['prodFinan'] : "";

// Datos adicionales del servicio
$enviarContrato = isset($post['enviarContrato']) ? $post['enviarContrato'] : "";
$enviarFactura  = isset($post['enviarFactura']) ? $post['enviarFactura'] : "";
$chMail  = isset($post['cmail']) && $post['cmail'] == 1  ? "checkbox-one-checked" : "";
$cmail  = isset($post['cmail']) ? $post['cmail'] : "";
$chIvr  = isset($post['civr']) && $post['civr'] == 1  ? "checkbox-one-checked" : "";
$civr  = isset($post['civr']) ? $post['civr'] : "";
$chSms  = isset($post['csms']) && $post['csms'] == 1  ? "checkbox-one-checked" : "";
$csms  = isset($post['csms']) ? $post['csms'] : "";
$chCorreo  = isset($post['ccorreo']) && $post['ccorreo'] == 1  ? "checkbox-one-checked" : "";
$ccorreo  = isset($post['ccorreo']) ? $post['ccorreo'] : "";
$chSalida  = isset($post['csalida']) && $post['csalida'] == 1  ? "checkbox-one-checked" : "";
$csalida  = isset($post['csalida']) ? $post['csalida'] : "";
$chPresuncion  = isset($post['cpresuncion']) && $post['cpresuncion'] == 1  ? "checkbox-one-checked" : "";
$cpresuncion  = isset($post['cpresuncion']) ? $post['cpresuncion'] : "";
$chAutoriza  = isset($post['cautoriza']) && $post['cautoriza'] == 1  ? "checkbox-one-checked" : "";
$cautoriza  = isset($post['cautoriza']) ? $post['cautoriza'] : "";


// Agendamiento
$fecha   = isset($post['fecha']) ? $post['fecha'] : "";
$jornada = isset($post['jornada']) ? $post['jornada'] : "";

?>
			<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une", true);?>
        	<div class="decoration"></div>
				
				
			<?php PageHelper::showMessage(); ?>
			
			<div class="container no-bottom">
            	<div class="section-title">
                	<h2>Formulario de solicitud de venta</h2>
					<h4>Cliente: <?php echo $clienteForm; ?></h4>
					<em>Oferta:  <?php echo $ofertaForm; ?></em>
                    <strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
                </div>
            </div>
            <div class="decoration"></div>
			
			<form action="index.php" method="post" class="contactForm" id="contactForm">
			<!-- Datos del cliente -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Datos del cliente</a>
					<div class="toggle-content contact-form no-bottom">
					
						<div class="container no-bottom" ><p><b>C&eacute;dula *</b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='number' name='cedula' value="<?php echo $cedula; ?>" /></p></div>
			
						<div class="container no-bottom" ><p><b>Nombres *</b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='text' name='nombres' value="<?php echo $nombres; ?>" /></p></div>
						
						<div class="container no-bottom" ><p><b>Apellidos *</b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='text' name='apellidos' value="<?php echo $apellidos; ?>" /></p></div>
						
								
						<div class="container no-bottom" ><p><b>Tel Auxiliar *</b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='tel' name='tel_aux' value="<?php echo $tel_aux; ?>"/></p></div>
						
						<div class="container no-bottom" ><p><b>Celular 1 *</b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='tel' name='celular1' value="<?php echo $celular1; ?>"/></p></div>
						
						<div class="container no-bottom" ><p><b>Celular 2 </b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='tel' name='celular2' value="<?php echo $celular2; ?>"/></p></div>
						
						<div class="container no-bottom" ><p><b>Correo *</b></p></div>
						<div class="container no-bottom" ><p><input class="contactField " type='email' name='correo' value="<?php echo $correo; ?>"/></p></div>
						
					</div>
				</div>
            </div>
			<!-- Fin Datos del cliente -->
			
			<!-- Direccion inst del servicio -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Direcci&oacute;n Instalaci&oacute;n</a>
					<div class="toggle-content">
					
						<div class="container no-bottom" >
							<div class="one-half"><p><b>Nueva direccion</b></p></div>
							<div class="two-half last-column">
								<p>
									<a id='chNuevaDireccion' class="checkbox checkbox-one <?php echo $cnuevaDireccion; ?>" href="#"></a>
								</p>
							</div>
						</div>
						
						<div id='divDireccionExistente' style="<?php echo $divDireccion;?>">
							<div class="container no-bottom"><p><b>Barrio *</b></p></div>
							<div class="container no-bottom">
								<p>
									<input type="text" name="barrio" value="" id="barrio" class="contactField requiredField" /> 
								</p>
							</div>
							
							<div class="container no-bottom"><p><b>Direcci&oacute;n *</b></p></div>
							<div class="container no-bottom">
								<p>
									<input type="text" name="direccion" value="" id="direccion" class="contactField requiredField" /> 
								</p>
							</div>
						</div>
						
						<div id='divNuevaDireccionExistente' style="<?php echo $divNuevaDireccion;?>" >
							<div class="container no-bottom"><p><b>Barrio *</b></p></div>
							<div class="container no-bottom">
								<p>
									<input type="text" name="barrioN" value="" id="barrioN" class="contactField requiredField" /> 
								</p>
							</div>
							
							<div class="container no-bottom"><p><b>Direcci&oacute;n *</b></p></div>
							<div class="container no-bottom">
								<p>
									<input type="text" name="direccionNueva" value="<?php echo $direccionNueva; ?>" id="direccionNueva" class="contactField requiredField" /> 
								</p>
							</div>
						</div>
					
					</div>
				</div>
            </div>
			<!-- Fin Direccion inst del servicio -->
			
			<!-- Direccion cobro del servicio -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Direcci&oacute;n Cobro</a>
					<div class="toggle-content">
					
						<div class="container no-bottom" >
							<div class="one-half"><p><b>Usar direcci&oacute;n de instalaci&oacute;n</b></p></div>
							<div class="two-half last-column">
								<p>
									<a id='chIgualDireccion' class="checkbox checkbox-one <?php echo $cigualdireccion; ?>" href="#"></a>
								</p>
							</div>
						</div>
							
						<div id='divDireccionCobro' style='<?php echo $divDirCobro; ?>'>
							<div class="container no-bottom" >
								<div class="one-half"><p><b>Nueva direccion</b></p></div>
								<div class="two-half last-column">
									<p>
										<a id='chNuevaDireccionCobro' class="checkbox checkbox-one <?php echo $cnuevaDireccionCobro;?> " href="#"></a>
									</p>
								</div>
							</div>
							
							<div id='divDireccionExistenteCobro' style="<?php echo $divDireccionCobro;?>">
							
								<div class="container no-bottom"><p><b>Barrio *</b></p></div>
								<div class="container no-bottom">
									<p>
										<input type="text" name="barrioC" value="" id="barrioC" class="contactField requiredField" /> 
									</p>
								</div>
							
								<div class="container no-bottom"><p><b>Direcci&oacute;n *</b></p></div>
								<div class="container no-bottom">
									<p>
										<input type="text" name="direccionCobro" value="" id="direccionCobro" class="contactField requiredField" /> 
									</p>
								</div>
							</div>
								
							<div id='divNuevaDireccionCobro' style="<?php echo $divNuevaDireccionCobro;?>">
								<div class="container no-bottom"><p><b>Barrio *</b></p></div>
								<div class="container no-bottom">
									<p>
										<input type="text" name="barrioCN" value="" id="barrioCN" class="contactField requiredField" /> 
									</p>
								</div>
								
								<div class="container no-bottom"><p><b>Direcci&oacute;n *</b></p></div>
								<div class="container no-bottom">
									<p>
										<input type="text" name="direccionNuevaCobro" value="<?php echo $direccionNuevaCobro; ?>" id="direccionNuevaCobro" class="contactField requiredField" /> 
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
			<!-- Fin Direccion cobro del servicio -->
			
			<!-- Datos adicionales del servicio -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Datos adicionales del servicio</a>
					<div class="toggle-content">
					
						<div class="container no-bottom"><p><b>Ciclo *</b></p></div>
						<div class="container no-bottom"><p> 
							<select name="ciclo" class="contactField requiredField" id="ciclo">
							  <option value="">Seleccione un ciclo</option>
							  <option value="0" <?php echo ($ciclo == 0) ? "selected='selected'" : ""; ?> >Ciclo 0</option>
							  <option value="2" <?php echo ($ciclo == 2) ? "selected='selected'" : ""; ?>>Ciclo 2</option>
							  <option value="3" <?php echo ($ciclo == 3) ? "selected='selected'" : ""; ?>>Ciclo 3</option>
							</select></p>
						</div>
						
						
						<div class="container no-bottom"><p><b>Sub-Categor&iacute;a *</b></p></div>
						<div class="container no-bottom">
							<p>
								<input type="text" name="subCategoria" value="" id="subCategoria" class="contactField requiredField" /> 
							</p>
						</div>
						
						<div class="container no-bottom"><p><b>Tipo de solicitud  *</b></p></div>
						<div class="container no-bottom"><p> 
							<select name="tipoSolicitud" class="contactField requiredField" id="tipoSolicitud">
							  <option value="">Seleccione el tipo de solicitud</option>
							  <?php 
								foreach($tiposSolicitud as $tipo){
							  ?>
									<option value="<?php echo $tipo->id; ?>" <?php echo ($tipo->id == $tipoSolicitud) ? "selected='selected'" : ""; ?>><?php echo $tipo->descripcion; ?></option>
							  <?php
							  }
							  ?>
							</select></p>
						</div>
						
						<div class="container no-bottom"><p><b>Tipo de contacto *</b></p></div>
						<div class="container no-bottom"><p> 
							<select name="tipoContacto" class="contactField requiredField" id="tipoContacto">
							  <option value="">Seleccione un tipo de contacto</option>
							  <option value="D" <?php echo ($tipoContacto == "D") ? "selected='selected'" : ""; ?>>VENTA DIRECTA</option>
							  <option value="E" <?php echo ($tipoContacto == "E") ? "selected='selected'" : ""; ?>>LLAMADA ENTRANTE</option>
							  <option value="S" <?php echo ($tipoContacto == "S") ? "selected='selected'" : ""; ?>>LLAMADA SALIENTE</option>
							</select></p>
						</div>
						
						<div class="container no-bottom"><p><b>Acierta *</b></p></div>
						<div class="container no-bottom"><p> 
							<select name="acierta" class="contactField " id="acierta">
							  <option value="">Seleccione un estado</option>
							  <option value="N" <?php echo ($acierta == "N") ? "selected='selected'" : ""; ?>>NO APLICA</option>
							  <option value="A" <?php echo ($acierta == "A") ? "selected='selected'" : ""; ?>>APROBADO</option>
							 
							</select></p>
						</div>
						
						<div class="container no-bottom"><p><b>Referidor</b></p></div>
						<div class="container no-bottom">
							<p>
								<input type="text" name="referidor" value="" id="referidor" class="contactField requiredField" /> 
							</p>
						</div>
						

						
						<div class="container no-bottom"><p><b>Transacci&oacute;n </b></p></div>
						<div class="container no-bottom"><p><input class="contactField " type='number' name='transaccion' value='<?php echo $transaccion;?>'/></p></div>
			
						<div class="container no-bottom"><p><b>Observaciones </b></p></div>
						<div class="container no-bottom"><p><input class="contactField " type='text' name='observaciones' value='<?php echo $observaciones;?>'/></p></div>
						
						
					</div>
				</div>
            </div>
			<!-- Fin Datos adicionales del servicio -->
			
			
			<!-- Datos de financiacion -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Datos de Financiaci&oacute;n</a> 
					<div class="toggle-content">
					
						<div class="container no-bottom"><p><b>Nro Contrato con mora </b></p></div>
						<div class="container no-bottom"><p><input class="contactField " type='text' name='contratoMora' value='<?php echo $contratoMora;?>' /></p></div>
						
						<div class="container no-bottom"><p><b>Valor pendiente</b></p></div>
						<div class="container no-bottom"><p><input class="contactField " type='text' name='valorPendiente' value='<?php echo $valorPendiente;?>'/></p></div>
						
						<div class="container no-bottom"><p><b>Tipo producto financiaci&oacute;n</b></p></div>
						<div class="container no-bottom"><p>
							<select name="tipoProdFin" class="contactField requiredField" id="tipoProdFin">
							  <option value="">Seleccione el tipo</option>
							  <option value="TO" <?php echo ($tipoProdFin == "TO") ? "selected='selected'" : ""; ?>>TO</option>
							  <option value="TV" <?php echo ($tipoProdFin == "TV") ? "selected='selected'" : ""; ?>>TV</option>
							  <option value="BA" <?php echo ($tipoProdFin == "BA") ? "selected='selected'" : ""; ?>>BA</option>
							  <option value="PQT" <?php echo ($tipoProdFin == "PQT") ? "selected='selected'" : ""; ?>>PAQUETE</option>
							</select>
							</p>
						</div>
						
						<div class="container no-bottom"><p><b>Nro producto financiaci&oacute;n</b></p></div>
						<div class="container no-bottom"><p><input class="contactField " type='text' name='prodFinan' value='<?php echo $prodFinan;?>'/></p></div>
						
					</div>
				</div>
            </div>
			<!-- Fin Datos de financiacion -->
			
			<!-- Datos comerciales -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Informaci&oacute;n comercial</a>
					<div class="toggle-content">
					
						<div class="container no-bottom" ><p><b>Enviar contrato a *</b></p></div>
						<div class="container no-bottom" ><p>
							<select name="enviarContrato" class="contactField requiredField" id="enviarContrato">
							  <option value="">Seleccione tipo</option>
							  <option value="F" <?php echo ($enviarContrato == "F") ? "selected='selected'" : ""; ?>>Fisico</option>
							  <option value="C" <?php echo ($enviarContrato == "C") ? "selected='selected'" : ""; ?>>Correo</option>
							  
							</select>
							</p>
						</div>
						

						<div class="container no-bottom" ><p><b>Enviar factura a *</b></p></div>
						<div class="container no-bottom" ><p>
							<select name="enviarFactura" class="contactField requiredField" id="enviarFactura">
					         	<option value="">Seleccione tipo</option>
					         	<option value="F" <?php echo ($enviarFactura == "F") ? "selected='selected'" : ""; ?>>Fisico</option>
					         	<option value="E" <?php echo ($enviarFactura == "E") ? "selected='selected'" : ""; ?>>Correo</option>
					       </select>
							</p>
						</div>
						
						<div class="container no-bottom" ><p><b>Autoriza realizar estrategias comerciales e informaci&oacute; de las mismas al 
                           grupo empresarial EPM, UNE ETP y sus aliados a traves de: </b></p></div>
						
						
						<div class="container no-bottom" >
							<div class="one-half"><p><b>Mail</b></p></div>
							<div class="two-half last-column">
								<p>
									<a id='chMail' class="checkbox checkbox-one <?php echo $chMail;?> " href="#"></a>
								</p>
							</div>
						</div>
						
					
						<div class="one-half"><p><b>IVR</b></p></div>
						<div class="two-half last-column"><p><a id='chIvr' href="#" class="checkbox checkbox-one <?php echo $chIvr;?> ">&nbsp;</a></p></div>
						
						<div class="one-half"><p><b>SMS</b></p></div>
						<div class="two-half last-column"><p><a id='chSms' href="#" class="checkbox checkbox-one <?php echo $chSms;?> ">&nbsp;</a></p></div>
						
						<div class="one-half"><p><b>Correo directo</b></p></div>
						<div class="two-half last-column"><p><a id='chCorreo' href="#" class="checkbox checkbox-one <?php echo $chCorreo;?> ">&nbsp;</a></p></div>
						
						<div class="one-half"><p><b>Campa&ntilde;a de salida</b></p></div>
						<div class="two-half last-column"><p><a id='chSalida' href="#" class="checkbox checkbox-one <?php echo $chSalida;?> ">&nbsp;</a></p></div>
						
						<div class="one-half"><p><b>Decr. de presun</b></p></div>
						<div class="two-half last-column"><p><a id='chPresuncion' href="#" class="checkbox checkbox-one <?php echo $chPresuncion;?> ">&nbsp;</a></p></div>
						
						<div class="container no-bottom" ><p><b>Continuar con el tratamiento de sus datos personales para la correcta prestaci&oacute;n del servicio 	</b></p></div>
						   
						<div class="one-half"><p><b>Autoriza</b></p></div>
						<div class="two-half last-column"><p><a id='chAutoriza' href="#" class="checkbox checkbox-one <?php echo $chAutoriza;?> ">&nbsp;</a></p></div>

					</div>
				</div>
            </div>
			<!-- Fin Datos comerciales -->
			
			<!-- Datos de agendamiento -->
			<div class="container">
				<div class="toggle-2">
					<a href="#" class="deploy-toggle-1">Datos de agendamiento</a>
					<div class="toggle-content">
					
						<div class="container no-bottom" ><p><b>Fecha(dd/mm/yyyy)</b></p></div>
						<div class="container no-bottom" >
						    <!-- 30/12/2014 dd/mm/yyyy -->
							<input type="text" id="fecha" title="dd/mm/yyyy" name="fecha" value="<?php echo $fecha; ?>" class="contactField requiredField"/>
						</div>
						
						<div class="container no-bottom" ><p><b>Jornada</b></p></div>
						<div class="container no-bottom" ><p>
							<select name="jornada" class="contactField requiredField" id="jornada">
							  <option value="">Seleccione la jornada</option>
							  <option value="8-12" <?php echo ($jornada == "8-12") ? "selected='selected'" : ""; ?>>AM</option>
							  <option value="2-6" <?php echo ($jornada == "2-6") ? "selected='selected'" : ""; ?>>PM</option>
							</select>
							</p>
						</div>
						
					</div>
				</div>
				
				<div class="formSubmitButtonErrorsWrap" style='margin-top:20px'>
					<input type="submit" class="buttonWrap button button-red contactSubmitButton" id="paso1Btn" value="Guardar" data-formId="contactForm"/>
				</div>
            </div>
			<!-- Fin Datos de agendamiento -->
			
				<input type="hidden" name="tbarrio" id="tbarrio" value="<?php echo $tbarrio ;?>" />
				<input type="hidden" name="tdireccion" id="tdireccion" value="<?php echo $direccion ;?>" />
				<input type="hidden" name="tbarrioN" id="tbarrioN" value="<?php echo $tbarrioN ;?>" />
				
				<input type="hidden" name="tbarrioC" id="tbarrioC" value="<?php echo $tbarrioC ;?>" />
				<input type="hidden" name="tdireccionCobro" id="tdireccionCobro" value="<?php echo $direccionCobro ;?>" />
				<input type="hidden" name="tbarrioCN" id="tbarrioCN" value="<?php echo $tbarrioCN ;?>" />
				
				
				
				<input type="hidden" name="cnuevadireccion" id="cnuevadireccion" value="<?php echo $cNuevaDireccionVal ;?>" />
				<input type="hidden" name="cigualdireccion" id="cigualdireccion" value="<?php echo $cIgualDireccionVal ;?>" />
				<input type="hidden" name="cnuevadireccioncobro" id="cnuevadireccioncobro" value="<?php echo $cNuevaDireccionCobroVal ;?>" />
				
				<input type="hidden" name="tsubCategoria" id="tsubCategoria" value="<?php echo $tsubCategoria ;?>" />
				<input type="hidden" name="treferidor" id="treferidor" value="<?php echo $treferidor ;?>" />
				
				<input type="hidden" name="cmail" id="cmail" value="<?php echo $cmail; ?>" />
				<input type="hidden" name="civr" id="civr" value="<?php echo $civr; ?>" />
				<input type="hidden" name="csms" id="csms" value="<?php echo $csms; ?>" />
				<input type="hidden" name="ccorreo" id="ccorreo" value="<?php echo $ccorreo; ?>" />
				<input type="hidden" name="csalida" id="csalida" value="<?php echo $csalida; ?>" />
				<input type="hidden" name="cpresuncion" id="cpresuncion" value="<?php echo $cpresuncion; ?>" />
				<input type="hidden" name="cautoriza"  id="cautoriza" value="<?php echo $cautoriza; ?>" />
				
				<input type="hidden" name="option" value="com_ztadmin" />
				<input type="hidden" name="task" value="usFormularioOsfSave" />
				<input type="hidden" id="addData" name="addData" value="<?php echo $barrio;?>" />
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
	
	jQuery("#barrio").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php?user=65&addData=<?php //echo $user->id; ?>", 
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
				jQuery("#tbarrio").val(item.name);
				jQuery("#addData").val(item.id);
            }
		<?php 
			if($barrio != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $barrio;?>, name: "<?php echo $tbarrio ;?>"}
					]
		<?php 
			}
		 ?>
		}
	);
	
	jQuery("#direccion").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/direcciones.php?user=65&addData=0<?php //echo $user->id; ?>", 
		{
			theme: "facebook",
			hintText: "Escriba la direcci&oacute;n",
			noResultsText: "No existen direcciones con estos datos ...",
			searchingText: "Buscando ....",
			minChars: 3,
			showing_all_results: true,
			tokenLimit: 1,
			preventDuplicates: true,
			onAdd: function (item) {
				jQuery("#tdireccion").val(item.name);
            }
	    <?php 
			if($idDireccion != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $idDireccion;?>, name: "<?php echo $direccion ;?>"}
					]
		<?php 
			}
		 ?>
		}
	);
	
	jQuery("#barrioN").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php", 
        {
         theme: "facebook",
         hintText: "Elija el barrio",
         noResultsText: "No existen barrios con estos datos ...",
         searchingText: "Buscando ....",
         minChars: 0,
         showing_all_results: true,
         tokenLimit: 1,
         preventDuplicates: true,
		 onAdd: function (item) {
				jQuery("#tbarrioN").val(item.name);
         }
		 <?php 
			if($barrioN != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $barrioN;?>, name: "<?php echo $tbarrioN ;?>"}
					]
		<?php 
			}
		 ?>
        }
	);
	
	
	jQuery("#barrioC").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php?user=65&addData=0<?php //echo $user->id; ?>", 
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
					jQuery("#tbarrioC").val(item.name);
					jQuery("#addData").val(item.id);
            }
			<?php 
			if($barrioC != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $barrioC;?>, name: "<?php echo $tbarrioC ;?>"}
					]
		<?php 
			}
		 ?>
		}
	);
	
	jQuery("#direccionCobro").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/direcciones.php?addData=0<?php //echo $user->id; ?>", 
		{
			theme: "facebook",
			hintText: "Escriba la direcci&oacute;n",
			noResultsText: "No existen direcciones con estos datos ...",
			searchingText: "Buscando ....",
			minChars: 3,
			showing_all_results: true,
			tokenLimit: 1,
			preventDuplicates: true,
			onAdd: function (item) {
				jQuery("#tdireccionCobro").val(item.name);
            }
			<?php 
			if($idDireccionCobro != ""){
		    ?>
			,
			 prePopulate: [
						{id: <?php echo $idDireccionCobro;?>, name: "<?php echo $direccionCobro ;?>"}
					]
			<?php 
				}
			 ?>
		}
	);
	
	
	
	jQuery("#barrioCN").tokenInput("<?php echo Configuration::getValue("RUTA_APP"); ?>components/com_ztadmin/autocomplete/barrios.php", 
        {
         theme: "facebook",
         hintText: "Elija el barrio",
         noResultsText: "No existen barrios con estos datos ...",
         searchingText: "Buscando ....",
         minChars: 0,
         showing_all_results: true,
         tokenLimit: 1,
         preventDuplicates: true,
		 onAdd: function (item) {
				jQuery("#tbarrioCN").val(item.name);
         }
		  <?php 
			if($barrioCN != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $barrioCN;?>, name: "<?php echo $tbarrioCN ;?>"}
					]
		<?php 
			}
		 ?>
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
         preventDuplicates: true,
		 onAdd: function (item) {
				jQuery("#tsubCategoria").val(item.name);
         }
		  <?php 
			if($subCategoria != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $subCategoria;?>, name: "<?php echo $tsubCategoria ;?>"}
					]
		<?php 
			}
		 ?>
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
         preventDuplicates: true,
		 onAdd: function (item) {
				jQuery("#treferidor").val(item.name);
                }
		  <?php 
			if($referidor != ""){
		 ?>
			,
			 prePopulate: [
						{id: <?php echo $referidor;?>, name: "<?php echo $treferidor ;?>"}
					]
		<?php 
			}
		 ?>
        }
	);
	
	jQuery("#content").css("z-index", "1");
	jQuery("#sidebar").css("z-index", "0");
	
	// Despliega formulario de nueva direccion o de direccion existente
	jQuery('#chNuevaDireccion').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#divDireccionExistente").hide();
			jQuery("#divNuevaDireccionExistente").show();	
			jQuery("#cnuevadireccion").val("1");
			jQuery("#cnuevadireccion").val("1");
			jQuery("#ciclo").val("");
			
        }
		else{
			jQuery("#divDireccionExistente").show();
			jQuery("#divNuevaDireccionExistente").hide();
			jQuery("#cnuevadireccion").val("0");
		}
    });
	
	// Despliega formulario de direccion de cobro
	jQuery('#chIgualDireccion').click(function() {
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#divDireccionCobro").hide();
			jQuery("#cigualdireccion").val("1");
        }
		else{
			jQuery("#divDireccionCobro").show();
			jQuery("#cigualdireccion").val("0");
		}
    });
	
	// Despliega formulario de nueva direccion o de direccion existente de cobro
	jQuery('#chNuevaDireccionCobro').click(function() {
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#divDireccionExistenteCobro").hide();
			jQuery("#divNuevaDireccionCobro").show();
			jQuery("#cnuevadireccioncobro").val("1");
			
        }
		else{
			jQuery("#divDireccionExistenteCobro").show();
			jQuery("#divNuevaDireccionCobro").hide();
			jQuery("#cnuevadireccioncobro").val("0");
		}
    });
	

	
	jQuery('#chMail').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#cmail").val("1");
        }
		else{
			jQuery("#cmail").val("0");
		}
    });
	
	jQuery('#chIvr').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#civr").val("1");
        }
		else{
			jQuery("#civr").val("0");
		}
    });
	
	jQuery('#chSms').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#csms").val("1");
        }
		else{
			jQuery("#csms").val("0");
		}
    });
	
	jQuery('#chCorreo').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#ccorreo").val("1");
        }
		else{
			jQuery("#ccorreo").val("0");
		}
    });
	
	jQuery('#chSalida').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#csalida").val("1");
        }
		else{
			jQuery("#csalida").val("0");
		}
    });
	
	jQuery('#chPresuncion').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#cpresuncion").val("1");
        }
		else{
			jQuery("#cpresuncion").val("0");
		}
    });
	
	jQuery('#chAutoriza').click(function() {
	
        if ($(this).hasClass('checkbox-one-checked')) {
            jQuery("#cautoriza").val("1");
        }
		else{
			jQuery("#cautoriza").val("0");
		}
    });
	
	
	
	
	
	
	
	
});
</script>


