<?php
  
/**
 * User Model
 *
 * @version $Id:  
 * @author claudia duque
 * @package TC
 * @subpackage zschool
 * @license GNU/GPL
 *
 * Allows to manage user data
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
//require_once( JPATH_COMPONENT . DS .'models' . DS . 'zteam.php' );
/**
 * Mensaje
 *
 * @author      claudia duque
 * @package		Joomla
 * @since 1.6
 */
		
class ModelVenta extends JModel{
	//const TAM_MSG       = 160;
	
    /**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	
	
	/**Busca paquetes de un cliente asociados a la cedula enviada*/
	function buscarPaquetesPorCedula($cedula){
		$datosWs = WebServices::consultarInformacionCedula($cedula);
		$datos = $this->actualizarDatosClienteCedula($cedula, $datosWs);
		$this->getServiciosAdicionalesPaquete($datos);
		
		return $datos;
				
		// $cache = Configuration::getValue("CACHE");
	
		// if( $this->existeDatosClienteLocal($cedula)  ){
			// $datos = $this->getDatosCliente($cedula);
			// $fechaCache = date('Y-m-d');
			// $cacheData = " - $cache days ";
			// $fechaCache = date('Y-m-d', strtotime( $fechaCache . $cacheData));
			
			// if( isset($datos[0]->fecha) && $datos[0]->fecha <= $fechaCache  ){
				// //consumir web service
				// $this->borrarDatosClienteCedula($cedula);
				// $datosWs = WebServices::consultarInformacionCedula($cedula);
				// //print_r($datosWs);
				// $datos = $this->actualizarDatosCliente($cedula, $datosWs);
			// }
		// }
		// else{
			// $datosWs = WebServices::consultarInformacionCedula($cedula);
			// $datos = $this->actualizarDatosCliente($cedula, $datosWs);
		// }
		
		// // Consulta servicios adicionales
		// $this->getServiciosAdicionalesPaquete($datos);
		// return $datos;
	}
	
	/**Buscar paquetes del cliente asociados a una direccion*/
	function buscarPaquetesPorDireccion($idDireccion){
		$this->borrarDatosClienteDireccion($idDireccion);
		$datosWs = WebServices::consultarInformacionDireccion($idDireccion);
		$datos = $this->actualizarDatosClienteDireccion($idDireccion, $datosWs);
		// Consulta servicios adicionales
		$this->getServiciosAdicionalesPaquete($datos);
		return $datos; 
	}
	
	function getServiciosAdicionalesPaquete($datos){
		if( is_array($datos)){
			foreach($datos as $dato){
				if($dato->id_estado == 1 ){ 
					$dato->adicionales = WebServices::consultarServAdicPaq($dato->productos);
					$dato = $this->procesarServiciosAdicionales($dato);
				}
			}
		}
	}
	
	function consultarDireccionServicio($servicio){
		$idDireccion = WebServices::consultarDireccionServicio($servicio);
		//echo "dir=" . $idDireccion;
		return $idDireccion;
	}
	
	function buscarDireccion($idDireccion){
		$cache = Configuration::getValue("CACHE");
	
		if( $this->existeDatosClienteLocal($cedula)  ){
			$datos = $this->getDatosCliente($cedula);
			$fechaCache = date('Y-m-d');
			$cacheData = " - $cache days ";
			$fechaCache = date('Y-m-d', strtotime( $fechaCache . $cacheData));
			
			if( isset($datos[0]->fecha) && $datos[0]->fecha <= $fechaCache  ){
				//consumir web service
				$this->borrarDatosCliente($cedula);
				$datosWs = WebServices::obtenerDatosCedula($cedula);
				//print_r($datosWs);
				$datos = $this->actualizarDatosCliente($cedula, $datosWs);
			}
		}
		else{
			$datosWs = WebServices::obtenerDatosCedula($cedula);
			$datos = $this->actualizarDatosCliente($cedula, $datosWs);
		}
		
		// Consulta servicios adicionales
		if( is_array($datos)){
			foreach($datos as $dato){
				if($dato->id_estado == 1 ){
					$dato->adicionales = WebServices::consultarServAdicPaq($dato->productos);
					$dato = $this->procesarServiciosAdicionales($dato);
					
				}
			}
		}
		return $datos;
	}
	
	
	function procesarServiciosAdicionales($dato){
		$adicionales = $dato->adicionales;
	
		if( $adicionales != ""){
			$adicionales = explode(";", $adicionales);
			$total = 0;
			$recurrentes = 0;
			$noRecurrentes =0;
			foreach($adicionales as $adicional){
				$dataAdicional =  new stdClass();
				$adicional = explode(":", $adicional);

				$tipo = $adicional[0];
				$adicional = $adicional[1];

				$adicional = explode(",", $adicional);
				$totalTipo = 0 ;
				
				foreach($adicional as $servicio ){
					//39=0|1
					$servicio = explode("=", $servicio );
					$claseServicio = $servicio[0];
					$temp = explode("|", $servicio[1] );
					$valor = $temp[0];
					$cantidad = $temp[1];
					
					//echo "tipo = $tipo";
					//echo "cs= $claseServicio";
					//echo "vl= $valor";
					//echo "cant= $cantidad";
					$datoServicio =  new stdClass();

					
					$datoServicio->clase_servicio = $this->getClaseServicio($claseServicio) ;
					
					if($datoServicio->clase_servicio->cobrrecurrente == "S"){
						$recurrentes = $recurrentes + 	 $valor ;
					}
					else{
						$noRecurrentes = $noRecurrentes + 	 $valor ;
					}
					$datoServicio->valor          = $valor        ;
					$datoServicio->cantidad       = $cantidad     ;
					$dataAdicional->servicios[] = $datoServicio   ;
					$totalTipo = $totalTipo + $valor;
					$total     = $total + $valor ;
					$datoServicio = "";
				}
				$dataAdicional->tipo = $tipo;
				$dataAdicional->valor = $totalTipo;
				$dato->servAdicionales[] = $dataAdicional;
			}
			$dato->totalAdicionales = $total;
			$dato->recurrentes = $recurrentes;
			$dato->noRecurrentes = $noRecurrentes;
		}
		return $dato;
	}
	
	/** 
	*  Actualiza los datos de el cliente en la base de datos a partir de los datos cargados del servicio web
	*  usando la cedula como llave principal
	*/
	function actualizarDatosClienteCedula($cedula, $datos){
		$db = JFactory::getDBO();
		
		// Borrar datos asociados a la cedula
		$this->borrarDatosClienteCedula($cedula);
		//Guardar nuevos datos
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Clientes', 'Table');
		
		$datos = explode("<fin>", $datos);
		
		if($datos[0] != "No hay datos"){
		
			foreach ($datos as $item){
				if (isset($item[0]) && $item[0] != "" ){
					$item = explode("|", $item);
					if( count($item) > 1){
						$row =& JTable::getInstance('Clientes', 'Table');
						//$row->id = $id ; 
						$row->cedula    = $cedula;
						$row->fecha     = date('Y-m-d');
						// Mapea los datos del servicio
						$this->mapearDatosServicio($row, $item);
					
						if($row->id_estado == 1 || $row->id_estado == 2 || $row->id_estado == 3 ){
							$row->store();
						}
					}
				}
			}
		}
		else{
			return "";
		}
		return $this->getDatosClienteCedula($cedula);
	}
	
	function mapearDatosServicio($row, $item){
		$row->segmento  = $item[0]; 
		$row->activo    = $item[1]; 
		$row->id_estado = $item[2]; 
		$row->desc_estado = $item[3]; 
		$row->tipo_producto= $item[4]; 
		$row->servicio =  $item[5]; 
		$row->producto =  $item[6]; 
		$row->estrato =  $item[7]; 
		$row->numero_servicio =  $item[8]; 
		$row->paquete =  $item[9]; 
		$row->plan =  $item[10]; 
		$row->estado_corte =  $item[11]; 
		$row->categoria =  $item[12]; 
		$row->subcategoria =  $item[13]; 
		$row->cliente =  $item[14]; 
		$row->nomcliente =  $item[15]; 
		$row->contrato =  $item[16]; 
		$row->fecha_inicio =  $item[17]; 
		$row->fecha_retiro =  $item[18]; 
		$row->id_direccion =  $item[19]; 
		$row->direc_inst =  $item[20]; 
		$row->cuentas_con_saldo =  $item[21]; 
		$row->cartera_castigada =  $item[22]; 
		$row->saldo_pendiente =  $item[23]; 
		$row->saldo_reclamo =  $item[24]; 
		$row->reclpagonoabo =  $item[25]; 
		$row->tipo_ba =  $item[26]; 
		$row->tecnologia =  $item[27]; 
		$row->servicios =  $item[29]; 
		$row->productos =  $item[30]; 
		$row->tarifa_paq =  $item[31]; 
		$row->tarifa_to =  $item[32]; 
		$row->tarifa_ba =  $item[33]; 
		$row->tarifa_tv =  $item[34]; 
		$row->id_mpio =  $item[35]; 
		$row->nom_mpio =  $item[36]; 
		$row->nitced =  $item[37]; 
		$row->tarifa_prod =  $item[40]; 
		$row->valor_productos =  $item[41]; 
		$row->id_grupo_mpio =  $item[42]; 
		$row->id_grupo_oferta =  $item[43]; 
		$row->vel_producto =  $item[44]; 
		$row->min_producto =  $item[45]; 
		$row->ciclo =  $item[46]; 
	}
	/** 
	*  Actualiza los datos de el cliente en la base de datos a partir de los datos cargados del servicio web
	*  usando la cedula como llave principal
	*/
	function actualizarDatosClienteDireccion($idDireccion, $datos){
		$db = JFactory::getDBO();
		
		// Borrar datos asociados a la cedula
		$this->borrarDatosClienteDireccion($idDireccion);
		//Guardar nuevos datos
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Clientes', 'Table');
		
		$datos = explode("<fin>", $datos);
		
		if($datos[0] != "No hay datos"){
			foreach ($datos as $item){
				if (isset($item[0]) && $item[0] != "" ){
					$item = explode("|", $item);
					if( count($item) > 1){
						$row =& JTable::getInstance('Clientes', 'Table');
						//$row->id = $id ; 
						$row->fecha     = date('Y-m-d');
						// Mapea los datos del servicio
						$this->mapearDatosServicio($row, $item);
						
						if($row->id_estado == 1){
							$row->store();
						}
					}
				}
			}
		}
		else{
			return "";
		}
		return $this->getDatosClienteDireccion($idDireccion);
	}
	
	function existeDatosClienteLocal($cedula){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbClientes = $db->nameQuote('#__zclientes');	
		
		$query = "SELECT 
						count(*)
				  FROM 
						$tbClientes as c
				  WHERE 
						cedula = '%s'
						";
						
		$query = sprintf( $query, $cedula );
		$db->setQuery($query);
	    $result = $db->loadResult();
		return ($result > 0 ? true : false  );
	}
	
	function getDatosClienteCedula($cedula){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbClientes = $db->nameQuote('#__zclientes');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbClientes as c
				  WHERE 
						cedula = '%s'
				  ORDER BY id_estado
						";
						
		$query = sprintf( $query, $cedula );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function getDatosClienteDireccion($idDireccion){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbClientes = $db->nameQuote('#__zclientes');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbClientes as c
				  WHERE 
						id_direccion = '%s' 
				  ORDER BY id_estado 
						";
						
		$query = sprintf( $query, $idDireccion );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	function getClaseServicio($claseServicio){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbServicios = $db->nameQuote('#__zserviciosadic');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbServicios as c
				  WHERE 
						codigo = %s 
						";
						
		$query = sprintf( $query, $claseServicio );
		$db->setQuery($query);
	    $result = $db->loadObjectList();

		return $result[0];
		
	}
	
	function borrarDatosClienteCedula($cedula){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbClientes = $db->nameQuote('#__zclientes');	
		
		$query = "DELETE
				  FROM 
						$tbClientes 
				  WHERE 
						cedula = '%s'
						";
						
		$query = sprintf( $query, $cedula );
		$db->setQuery($query);
	    $result = $db->query();
		return $result;
	}
	
	function borrarDatosClienteDireccion($idDireccion){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbClientes = $db->nameQuote('#__zclientes');	
		
		$query = "DELETE
				  FROM 
						$tbClientes 
				  WHERE 
						id_direccion = '%s'
						";
						
		$query = sprintf( $query, $idDireccion);
		$db->setQuery($query);
	    $result = $db->query();
		return $result;
	}
	
	function buscarOfertas($data){
		$ofertas = WebServices::consultarOfertasCliente( $data->id_mpio, $data->estrato, $data->valor_productos, $data->productos,
                                                         $data->min_producto, $data->vel_producto, $data->adicionales, $data->id_grupo_mpio,
											             $data->id_grupo_oferta, $data->tarifa_paq );
		
		
		$ofertas = explode("<fin>", $ofertas);
		foreach ($ofertas as $item){

			if (isset($item[0]) && $item[0] != "" ){
				$item = explode("|", $item);
				$oferta =  new stdClass();
				$oferta->idOferta    = $item[5];
				$oferta->orden       = $item[6];
				$oferta->condicion   = $item[7];
				$oferta->nomOferta   = $item[8];
				$oferta->opcion      = $item[9];
				$oferta->vlrOferta   = $item[10];
				$oferta->vlrProds    = $item[11];
				$oferta->vlrRadio    = $item[12];
				$oferta->vlrTO       = $item[13];
				$oferta->vlrTV       = $item[14];
				$oferta->vlrBA       = $item[15];
				$oferta->ivaTO       = $item[16];
				$oferta->ivaTV       = $item[17];
				$oferta->ivaBA       = $item[18];
				$oferta->iva         = $oferta->ivaTO +  $oferta->ivaTV + $oferta->ivaBA;
				
				
				$minutos = "";
				if( $oferta->vlrTO > 0 ){
					$minutos = WebServices::consultarMinutosOferta($oferta->idOferta     , 
															   'TO'                  , 
															   $oferta->opcion       , 
															   $data->valor_productos, 
															   $data->productos      , 
															   $data->min_producto   ,
															   $data->vel_producto
															   );
				}
		
				$velocidad = "";
				if( $oferta->vlrBA > 0){
					/*echo $oferta->idOferta .",". $oferta->opcion .",". $data->valor_productos .",". $data->productos 
					     .",". $data->min_producto .",". $data->vel_producto . "<br/>";*/

					$velocidad = WebServices::consultarVelocidadOferta($oferta->idOferta     ,
															           $oferta->opcion       , 
															           $data->valor_productos, 
															           $data->productos      , 
															           $data->min_producto   ,
															           $data->vel_producto
															   );
				}
				
				$ofertaAdic = WebServices::consultarServAdicOferta($oferta->idOferta  ,  $data->id_mpio , $data->estrato, $data->valor_productos, 
				                                                   $data->productos   ,    
				                                                   $data->adicionales ,   
				                                                   $data->min_producto, 
																   $data->vel_producto );
			
				$oferta->minutos      = $minutos;
				$oferta->velocidad    = $velocidad;
				$oferta->adicionales  = $ofertaAdic;
				$this->procesarServiciosAdicionalesOferta($oferta);
				
				$oferta->minutos = ($oferta->minutos == "999999") ? "Ilimitado" : $oferta->minutos;
				
				// Calcula los totales de los servicios adicionales de la oferta
				$totalAdicTO = 0;
				$totalAdicTV = 0;
				$totalAdicBA = 0;
				
				//Obtiene el total de los servicios adicionales
				foreach($oferta->servAdicionales as $servicio){ 
					if($servicio->tipo == "TO"){
						$totalAdicTO =  $servicio->valor;
					}
					if($servicio->tipo == "TV"){
						$totalAdicTV =  $servicio->valor;
					}
					if($servicio->tipo == "BA"){
						$totalAdicBA = $servicio->valor;
					}
				}
				
				$oferta->vlrAdicTO = $totalAdicTO;
				$oferta->vlrAdicTV = $totalAdicTV;
				$oferta->vlrAdicBA = $totalAdicBA;
				
				$oferta->vlrIvaAdicTO = $totalAdicTO * 16/100 ;
				$oferta->vlrIvaAdicTV = $totalAdicTV * 16/100 ;
				$oferta->vlrIvaAdicBA = $totalAdicBA * 16/100 ;

				$oferta->totalAdicionalesIva = $oferta->totalAdicionales * 16 /100 ;
				
				// Total con iva de la oferta
				$oferta->totalConIva = $oferta->vlrProds + $oferta->iva + $oferta->totalAdicionales + $oferta->totalAdicionalesIva; 				
				//print_r($oferta->servAdicionales);
				$ofertasAct[] = $oferta;
			}
		}
		return $ofertasAct;
	}
	
	function procesarServiciosAdicionalesOferta($oferta){
		// TV:9351=6034,1983=2345;
		$adicionales = $oferta->adicionales;
		if($adicionales != "" ){
			$adicionales = explode(";", $adicionales);
			$total = 0;
			
			foreach($adicionales as $adicional){
				$dataAdicional =  new stdClass();
				$adicional = explode(":", $adicional);
				$tipo = $adicional[0];
				$adicional = $adicional[1];
				$adicional = explode(",", $adicional);
				$totalTipo = 0 ;
				foreach($adicional as $servicio ){
					//TV:9351=6034
					$servicio = explode("=", $servicio );
					$claseServicio = $servicio[0];
					$valor         = $servicio[1];
					
					//echo "tipo = $tipo";
					//echo "cs= $claseServicio";
					//echo "vl= $valor";
					//echo "cant= $cantidad";
					$datoServicio = new stdClass();
					$datoServicio->clase_servicio = $this->getClaseServicio($claseServicio) ;
					$datoServicio->valor          = $valor        ;
					$dataAdicional->servicios[] = $datoServicio   ;
					$totalTipo = $totalTipo + $valor;
					$total     = $total + $valor ;
					$datoServicio = "";
				}
				$dataAdicional->tipo = $tipo;
				$dataAdicional->valor = $totalTipo;
				$oferta->servAdicionales[] = $dataAdicional;
			}
			$oferta->totalAdicionales = $total;
		}
		else{
			$oferta->totalAdicionales = 0;
			$oferta->servAdicionales = array();
		}
	}
	
	/**
	*Consulta el scoring de un cliente a traves del servicio web
	*Retorna N no hay datos
    *Retorna vacio esta bien
    *Retorna datos separados con | tiene deudas pendientes
	*/
	function consultarScoring($cedula){
		$scoring = WebServices::consultarScoring($cedula);
		$scoring = explode("<tag>", $scoring);
		$response = $scoring[0];
		$codError = $scoring[1];
		$msgError = $scoring[2];
		
		if($codError == 0 ){
			if($response == "N"){
				// TODO Consultar servicio web CIFIN
			}
			else if( strpos($response, "|") === false){
				$response = "Aprobado";
			}
			else{
				$response = explode("|", $response);
				// pos 0 contrato
				// pos 4 valor
				// pos 7 contrato
				// pos 11 valor
			}
		}
		else{
			$response = "Error scoring: $msgError" ;
			// Reportar error administrador envio de correo
		}
		
		return $response;
	}
	
	
	/**
	* Consultar los planes individuales actuales disponibles para crear ofertas
	*/
	function getPlanesIndActuales( $tipoProd, $grupo ){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbPlanGrupo = $db->nameQuote('#__zgrupoplan');	
		$tbPlanes = $db->nameQuote('#__zplanes');	
		
		$query = "SELECT 
						c.*
				  FROM 
						$tbPlanGrupo as pg,
						$tbPlanes as c
				  WHERE 
				        pg.grupo  = %s AND
						pg.plan = c.idcodplan AND
						c.tipoprod = '%s' 
				  ORDER BY 
					   c.nomplan
						";
						
		$query = sprintf( $query, $grupo, $tipoProd );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		
		//Obtiene valores de acuerdo al estrato y municipio
		$data = $this->getDatosClienteActual();
		$municipio = $data->id_mpio; 
		$estrato = $data->estrato; 
		$grupoMpio = 1;
		
		if($municipio == "66001" || $municipio == "66170" ){
			$grupoMpio = 1;
		}
		else if($municipio == "66147" || $municipio == "66400" || $municipio == "66682" ){
			$grupoMpio = 2;
		}
		else if($municipio == "63470" || $municipio == "63594" || $municipio == "63401" ){
			$grupoMpio = 3;
		}
		
		$data->grupoMpio = $grupoMpio;

		$this->setDatosClienteActual($data);
		
		foreach($result as $item){
			$data = WebServices::getTarifaPlan($municipio, $estrato, $tipoProd, $grupoMpio, $item->idcodplan );
			$data = explode("<tag>", $data);
			if(isset($data[9]) && $data[9] != "" ){
				$item->valor = $data[9];
			}
		}
		return $result;
	}
	
	
	/**
	* Guarda una nueva oferta en la sesion
	*/
	function guardarNuevaOferta(){
		$data = JRequest::get('post');
		
		if( $data['to'] != "" || $data['tv'] != ""  || $data['ba'] != ""){
			// Nuevo objeto oferta
			$nuevaOferta = new stdClass();
			$nuevaOferta->to = $data['to'];
			$nuevaOferta->tv = $data['tv'];
			$nuevaOferta->ba = $data['ba'];
			$nuevaOferta->TO = $data['to'];
			$nuevaOferta->TV = $data['tv'];
			$nuevaOferta->BA = $data['ba'];
			$nuevaOferta->toData = $this->getPlanPorId($data['to'] );
			$nuevaOferta->tvData = $this->getPlanPorId($data['tv'] );
			$nuevaOferta->baData = $this->getPlanPorId($data['ba'] );
			//$this->getPlanAct()
			//
			Session::setVar("nuevaOferta", $nuevaOferta );
			return true;
		}
		else{
			return false;
		}
	}
	
	function getServiciosAdicionales($tipoServicio){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbServicios = $db->nameQuote('#__zserviciosadic');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbServicios as c
				  WHERE 
						servicio = '%s' 
				  ORDER BY 
					   nomserv
						";
						
		$query = sprintf( $query, $tipoServicio );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	/**
	* Limpia los datos de la sesion para iniciar una nueva venta
	*/
	function limpiarVentaSesion(){
		// Oferta personalizada
		Session::setVar("nuevaOferta", "");
		// Limpia las ofertas realizadas
		Session::setVar('ofertas', "");
		// Limpia la oferta seleccionada
		Session::setVar("ofertaSeleccionada", "");
		// Limpia consulta por cedula, servicio o direccion
		Session::setVar("infoCliente", "");
		// Limpia los servicios adicionales agregados
		Session::setVar("venta_servicios_adicionales", "");
		// Limpia el total de la oferta creada con  planes
		Session::setVar("totalOferta", "");
		// Limpia los totales de los servicios adicionales
		Session::setVar("totalesAdicionales", "");
		// Limpia los totales de la venta
		Session::setVar("totalesVenta", "");
		// Limpia formulario OSF
		Session::setVar("post", "");
		
	}
	
	/**
	* Agrega los servicios de la oferta 
	*/
	function agregarServiciosOferta($idOferta, $opcion){
		$ofertas = Session::getVar('ofertas');
		foreach ($ofertas as $oferta){
			if($oferta->idOferta == $idOferta && $oferta->opcion == $opcion ){
				///print_r($oferta->servAdicionales);
				Session::setVar("ofertaSeleccionada", $oferta);
				if( isset($oferta->servAdicionales) && count($oferta->servAdicionales) >= 1 ){
					foreach($oferta->servAdicionales as $adicional){
						//print_r($adicional->servicios[0]);
						$codigo = $adicional->servicios[0]->clase_servicio->codigo;
						$tipo   = $adicional->servicios[0]->clase_servicio->servicio;
						$costo  = $adicional->servicios[0]->valor;
						$cantidad = 1;
						$this->agregarServicio($codigo, $cantidad, $tipo, "", "O", $costo);
					}
				}
			}
		}
	}
	
	/**
	* Agrega los servicios actuales del cliente
	*/
	function agregarServiciosActuales(){
		$infoCliente  = Session::getVar('infoCliente');
		//print_r( $infoCliente[0]->servAdicionales[0] ); 
		//exit;
		foreach($infoCliente[0]->servAdicionales[0]->servicios as $adicional){
			//print_r($adicional);
			//exit;
			$codigo   = $adicional->clase_servicio->codigo;
			$tipo 	  = $adicional->clase_servicio->servicio;
			$valor 	  = $adicional->valor;
			$cantidad = $adicional->cantidad;
			$this->agregarServicio($codigo, $cantidad, $tipo, "", "A", $valor);
		}
	}
	
	/**
	* Agrega un nuevo servicio adicional a la sesion actual\
	* El grupo indica de donde proviene el servicio:
	* N: Nuevo, O: Oferta, A: Actual
	*/
	function agregarServicio($codigo, $cantidad, $tipo, $promo="",  $grupo="N", $costo=""){
		$servicios = Session::getVar("venta_servicios_adicionales");
		//Session::setVar("venta_servicios_adicionales", array() );
		
		if($codigo == "" || $cantidad == "" ){
			return JText::_('M_ERROR') . sprintf( JText::_('VENTA_SERVICIO_ERROR_CREACION') );
		}
		
		if( isset($servicios[$codigo])){
			//print_r($servicios);
			// actualizar
			$actServicio = $servicios[$codigo];
			//print_r($actServicio);
			//echo "<br/>";
			$nuevaCantidad = $actServicio->cantidad + $cantidad;
			if($costo == ""){
				$costo = $this->costoServicioAdicional($codigo, $nuevaCantidad);
				if($promo != "" ){
					$costo = $costo * ($promo/100);
				}
			}
			if( $costo != -1 ){
				$actServicio->costo = $costo;
				$actServicio->cantidad = $nuevaCantidad;
				$servicios[$codigo] = $actServicio;
				// Actualiza sesion
				Session::setVar("venta_servicios_adicionales", $servicios);
			}
			else{
				return JText::_('M_ERROR') . sprintf( JText::_('VENTA_SERVICIO_NO_SOPORTA_CONFIGURACION') );
			}
		}
		else{
			// crear nuevo
			$costo = $this->costoServicioAdicional($codigo, $cantidad);
			if( $costo != -1 ){
				$servicio = $this->getServicioAdicionalPorCodigo($codigo);
				
				$nuevoServicio = new stdClass();
				$nuevoServicio->codigo   = $codigo;
				$nuevoServicio->cantidad = $cantidad;
				$nuevoServicio->tipo     = $tipo;
				$nuevoServicio->grupo    = $grupo;
				$nuevoServicio->costo = $costo;
				$nuevoServicio->promo = 'N';
				$nuevoServicio->descripcion = $servicio->nomserv;
				$nuevoServicio->recurrente  = $servicio->cobrrecurrente;
				$servicios[$codigo] = $nuevoServicio;
			
				if($promo != "" ){
					$nuevoServicio->costo = $costo * ($promo/100);
					$nuevoServicio->promo = 'S';
				}
				
				// Actualiza sesion
				Session::setVar("venta_servicios_adicionales", $servicios);
				//$this->actualizarTotales();
			}
			else{
				return JText::_('M_ERROR') . sprintf( JText::_('VENTA_SERVICIO_NO_SOPORTA_CONFIGURACION') , $row->id );
			}
		}
		
		return JText::_('M_OK') . sprintf( JText::_('VENTA_SERVICIO_ADICIONAL_GUARDADO') );;
	}
	
	/** Obtiene la cantidad actual de un servicio*/
	function getCantidadServicioActual($codigo){
		$data =  $this->getDatosClienteActual();
		$servicios = $data->servAdicionales[0];

		foreach($servicios->servicios as $servicio){
			//print_r($servicio);
			if($servicio->clase_servicio->codigo == $codigo){
				return $servicio->cantidad;
			}
		}
		return 0;
	}
	
	
	/**
	* Elimina un servicio adicional de la venta actual en la sesion
	*/
	function eliminarServicio($codigo){
		$servicios = Session::getVar("venta_servicios_adicionales");
		if( isset($servicios[$codigo])){
			unset($servicios[$codigo]);
			Session::setVar("venta_servicios_adicionales", $servicios);
			return JText::_('M_OK') . sprintf( JText::_('VENTA_SERVICIO_ADICIONAL_ELIMINADO') );
		}
		else{
			return JText::_('M_ERROR') . sprintf( JText::_('VENTA_SERVICIO_ADICIONAL_ELIMINADO_ERROR') , $row->id );
		}
		
		
	}
	
	/**
	* Calcula el costo de un servicio adicional de acuerdo a su tipo y cantidad
	*/
	function costoServicioAdicional($codigo, $cantidad){
		$servicio = $this->getServicioAdicionalPorCodigo($codigo);
		if( $cantidad <= $servicio->cantlimite ){
			if($cantidad >= $servicio->cantinicobro ){
				$serviciosCobrados = $cantidad - $servicio->cantinicobro + 1;
				return $serviciosCobrados * $servicio->tarifa;
			}
			else{
				return 0;
			}
		}
		else{
			return -1;
		}
		return $result;
	}
	
	
	/**
	* Retorna descripcion del servicio adicional a partir de su codigo
	*/
	function descripcionServicioAdicional($codigo){
		$servicio = $this->getServicioAdicionalPorCodigo($codigo);
		return $servicio->nomserv;
	}
	
	/**
	* Retorna el plan a partir de su codigo
	*/
	function getPlanPorId($id){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbPlanes = $db->nameQuote('#__zplanes');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbPlanes as c
				  WHERE 
						codplan = %s 
						";
						
		$query = sprintf( $query, $id );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		$result = $result[0];
		return $result;
	}
	
	/**
	* Retorna el servicio adicional a partir de su codigo
	*/
	function getServicioAdicionalPorCodigo($codigo){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbServicios = $db->nameQuote('#__zserviciosadic');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbServicios as c
				  WHERE 
						codigo = '%s' 
						";
						
		$query = sprintf( $query, $codigo );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		$result = $result[0];
		return $result;
	}
	
	
	function getGrupoMpio( $municipio ){
		$grupoMpio = 1;
		if($municipio == "66001" || $municipio == "66170" ){
			$grupoMpio = 1;
		}
		else if($municipio == "66147" || $municipio == "66400" || $municipio == "66682" || $municipio == "76147" ){
			$grupoMpio = 2;
		}
		else if($municipio == "63470" || $municipio == "63594" || $municipio == "63401" ){
			$grupoMpio = 3;
		}
		return $grupoMpio;
	}
	
	function getValorServicioSubsidio($tipoProd, $plan){
		//Obtiene valores de acuerdo al estrato y municipio
		$data = $this->getDatosClienteActual();
		//$data = Session::getVar('infoCliente');
		$municipio = $data->id_mpio; 
		$estrato = $data->estrato; 
		$grupoMpio = $this->getGrupoMpio($municipio);
		//
		//echo $municipio . "-" . $estrato . "-" . $grupoMpio . "-" . $tipoProd . "-" . $plan ; 
		$data = WebServices::getTarifaPlan($municipio, $estrato, $tipoProd, $grupoMpio, $plan );
		$data = explode("<tag>", $data);
		if(isset($data[9]) && $data[9] != "" ){
			return  $data[9];
		}
		else{
			return "";
		}
	}
	
	
	/*Indica si la venta actual es en base a una oferta sugerida por el sistema*/
	function esOferta(){
		
	}
	
	/**
	* Calcula totales de los productos de la oferta
	* Retorna arreglo con los datos
	*/
	function getTotalesOferta(){
		$oferta = Session::getVar("nuevaOferta");
		// Obtiene el valor de acuerdo al tipo de oferta
		if( $oferta != ""){
			$data = $this->getDatosClienteActual();
			$valorTo = 0;
			$valorTv = 0;
			$valorBa = 0;
			//Calcula total to
			if( isset($oferta->to) && $oferta->to >0){
				$to = $this->getPlanPorId($oferta->to);
				$data->to = $to;
				$valorTo = $to->valor;
				$temp = $this->getValorServicioSubsidio("TO", $to->codplan);
				$valorTo = ($temp != "") ? $temp : $valorTo;
				$oferta->toData->valor = $valorTo;
			}
			//Calcula total tv
			if( isset($oferta->tv) && $oferta->tv > 0 ){
				$tv = $this->getPlanPorId($oferta->tv);
				$data->tv = $tv;
				$valorTv = $tv->valor;
				$temp = $this->getValorServicioSubsidio("TV", $tv->codplan);
				$valorTv = ($temp != "") ? $temp : $valorTv;
				$oferta->tvData->valor = $valorTv;
			}
			//Calcula total ba
			if( isset($oferta->ba) && $oferta->ba >0){
				$ba = $this->getPlanPorId($oferta->ba);
				$data->ba = $ba;
				$valorBa = $ba->valor;
				$temp = $this->getValorServicioSubsidio("BA", $ba->codplan);
				$valorBa = ($temp != "") ? $temp : $valorBa;
				$oferta->baData->valor = $valorBa;
			}
			//echo $valorTo ." - " .$valorTv ." - ". $valorBa;
			//exit;
			// Guarda datos en la sesion
			$this->setDatosClienteActual($data);
			$totales = $valorTo + $valorTv + $valorBa;
			Session::setVar("totalOferta", $totales);
			Session::setVar("nuevaOferta", $oferta);
			return $valorTo + $valorTv + $valorBa;
		}
		else{
			// Calcula con base en la mejor oferta seleccionada
			$oferta = Session::getVar("ofertaSeleccionada");
			Session::setVar("totalOferta", $oferta->vlrProds );
			return $oferta->vlrProds;
			
		}
	}
	
	
	function getTotalAdicionalesOfertaProducto($producto){	
		$servicios = Session::getVar("venta_servicios_adicionales");
		//Calcula servicios adicionales de pago unico y recurrent
		$pagoUnico = 0;
		$recurrentes = 0;
		$total = 0;
		if( isset($servicios)){
			foreach($servicios as $servicio){
				if($servicio->tipo == $producto ){
					$total = $total + $servicio->costo;
				}
			}
		}
		return $total;
	}
	
	/**
	* Calcula totales de los servicios adicionales en la oferta
	* Retorna arreglo con los datos
	*/
	function getTotalesServiciosAdicionales(){	
		$servicios = Session::getVar("venta_servicios_adicionales");
		//Calcula servicios adicionales de pago unico y recurrentes
		$pagoUnico = 0;
		$recurrentes = 0;
		if( isset($servicios)){
			foreach($servicios as $servicio){
				if($servicio->recurrente == "N"){
					$pagoUnico = $pagoUnico + $servicio->costo;
				}
				else{
					$recurrentes = $recurrentes + $servicio->costo;
				}
			}
		}
		$totales["pagoUnico"]   = $pagoUnico;
		$totales["recurrentes"] = $recurrentes;
		Session::setVar("totalesAdicionales", $totales);
		return $totales;
	}
	
	function calcularTotalesVenta($totalPlan, $totalesAdicionales){
		$totalMensual      = $totalPlan + $totalesAdicionales["recurrentes"];
		$totalIvaPrimerMes = ($totalMensual + $totalesAdicionales["pagoUnico"] ) * 16 /100 ;
		$totalPrimerMes    = $totalPlan + $totalesAdicionales["recurrentes"] +  $totalesAdicionales["pagoUnico"]; 
		$totalIvaMensual   = $totalMensual * 0.16 ;
		
		$totales["ivaPrimerMes"]  = $totalIvaPrimerMes;
		$totales["primerMes"]     = $totalPrimerMes + $totalIvaPrimerMes  ;
		$totales["ivaMensual"]    = $totalIvaMensual  ;
		$totales["mensual"]       = $totalMensual +  $totalIvaMensual   ;
		$totales["mensualSinIva"] = $totalMensual  ;
		Session::setVar("totalesVenta", $totales);
		return $totales;
		
	}
	
	/*Retorna la tarifa actual del cliente productos + servicios adicionales*/
	function getTarifaActual(){
		$data = $this->getDatosClienteActual();
		$tarifa = 0;
		if(isset($data->tarifa_paq) ){
			$tarifa = $data->tarifa_paq ; 
			if(isset( $data->totalAdicionales) ){
				$tarifa = $tarifa +  $data->totalAdicionales;
			}
		}
		return $tarifa;
	}
	
	/*Obtiene el total mensual plan+adicionales+iva*/
	function getTotalMensual(){
		$totales = Session::getVar("totalesVenta");
		if( isset($totales["mensual"])){
			return $totales["mensual"];
		}
		return 0;
	}

	/*Obtiene el total mensual plan+adicionales+iva*/
	function getTotalMensualSinIva(){
		$totales = Session::getVar("totalesVenta");
		if( isset($totales["mensualSinIva"])){
			return $totales["mensualSinIva"];
		}
		return 0;
	}

	
	/* Obtiene el tipo de venta UP DOWN CROSS*/
	function getTipoVenta(){
		// TODO modificar funcion para que en el caso de los planes customizados funcione correctamente
		
		$nuevaOferta = Session::getVar("nuevaOferta");
  		$str = "";
  		
		$tarifaActual = $this->getTarifaActual();
		//caso 1: nuevo cliente->up
		if ( $tarifaActual == 0){
			return "UP";
		}
		//caso 2: es un cliente y seleccionó la mejor oferta
		else{
			$oferta = Session::getVar("ofertaSeleccionada");
			$ofertaValorMensualSinIva = $this->getTotalMensualSinIva();
			if( isset($oferta->nomOferta)){
				//echo "total =" . $ofertaValorMensualSinIva;
				//echo "tarifaActual = " . $tarifaActual;
				//exit;
				if( $ofertaValorMensualSinIva >= $tarifaActual ){
					return "UP";
				}
				else{
					return "DOWN";
				}
			} 
			//caso 3: es un cliente y creó una oferta personalizada
			else
			{
				// Get valor oferta personalizada
				$ofertaValorMensualSinIva = $this->getTotalMensualSinIva();
				if( $ofertaValorMensualSinIva >= $tarifaActual ){
					return "UP";
				}
				else{
					return "DOWN";
				}
			}
		}
	}

		/*if( $this->getTotalMensual() > $this->getTarifaActual() ){
			return "UP";
		}
		else if( isset($info->cedula) ){
			return "DOWN";
		}
		else{
			return "NA";
		}
  

  if( isset($oferta->nomOferta) ){
		
	}*/

	
	/**Guarda la venta en la base de datos del movil*/
	function guardarVenta($post){
		Session::setVar("post", $post);
		echo "registrando la venta ...";
		
		// Valida informacion cliente
		if($post["cedula"] == "" || $post["nombres"] == "" || $post["apellidos"] == ""|| $post["tel_aux"] == "" || $post["celular1"] == ""
		  || $post["correo"] == ""){
			return JText::_('M_ERROR') . sprintf( JText::_('ERROR_DATOS_CLIENTE') );
		}
		
		//Valida direccion de instalacion
		if($post["direccion"] == "" && $post["direccionNueva"] == ""){
			return JText::_('M_ERROR') . sprintf( JText::_('ERROR_DIRECCCION_INSTALACION') );
		}
		
		//Valida direccion de cobro
		if($post["cigualdireccion"] == "0"    ){
			if($post["direccionCobro"] == "" && $post["direccionNuevaCobro"] == ""){
				return JText::_('M_ERROR') . sprintf( JText::_('ERROR_DIRECCCION_COBRO') );
			}
		}
				
		// Valida datos adicionales del servicio
		if($post["ciclo"] == "" || $post["subCategoria"] == "" || $post["tipoContacto"] == ""|| $post["acierta"] == "" ){
			return JText::_('M_ERROR') . sprintf( JText::_('ERROR_DATOS_ADICIONALES_SERVICIO') );
		}
		
		// Valida informacion comercial
		if($post["enviarContrato"] == "" || $post["enviarFactura"] == "" || $post["cautoriza"] == "" ){
			return JText::_('M_ERROR') . sprintf( JText::_('ERROR_INFORMACION_COMERCIAL') );
		}
		
		// Valida datos de agendamiento
		if($post["fecha"] == "" || $post["jornada"] == "" ){
			return JText::_('M_ERROR') . sprintf( JText::_('ERROR_DATOS_AGENDAMIENTO') );
		}
		
		$cedula = $post["cedula"];
		$scoring = $this->consultarScoring($cedula);
		if( $scoring != "" ){
			//
			$dirInstalacion  = $this->getDireccionInstalacionVenta( $post );
			if($dirInstalacion != -1 ){	
				$dirCobro = $this->getDireccionCobroVenta( $post );
				$dirCobro = ($dirCobro == 0 ) ? $dirInstalacion : $dirCobro;
				//exit;
				if($dirCobro != -1 ){
					$encVenta    = $this->getEncabezadoVenta($post, $dirInstalacion, $dirCobro);
					$detVenta    = $this->getDetalleVenta($post);
					$adiVenta    = $this->getAdicVenta($post);
					$solVenta    = $this->getSolicitudVenta($post, $dirInstalacion, $dirCobro);
					$solDetVenta = $this->getDetalleSolicitudVenta($post);
					$datosAgenda = $this->getDatosAgenda($post, $dirInstalacion);
					
					// Guarda la venta en base de datos temporal
					$venta = $this->guardarVentaTemporal($post, $encVenta, $detVenta , $adiVenta  , $solVenta  , $solDetVenta, $datosAgenda);
					if ( $venta > 0 )  {
						// Enviar venta a OSF
						$msg = $this->registrarVentaOsf($venta);
						//print_r($msg);
						//exit;
					}
					else{
						return JText::_('M_ERROR') . sprintf( JText::_('ERROR_GUARDAR_VENTA') );
					}
					return JText::_('M_OK') . sprintf( JText::_($msg) );	
				}
				else{
					return JText::_('M_ERROR') . sprintf( JText::_('DIRECCION_COBRO') );
				}
				
			}
			else{
				return JText::_('M_ERROR') . sprintf( JText::_('DIRECCION_INSTALACION') );
			}
			
		}
		else{
			return JText::_('M_ERROR') . sprintf( JText::_('ERROR_SCORING') );
		}
		
	}
	
	function getAdicVenta($post){
		//33<t>TO<t>N<t>N<t>1<t>1<t>4622<t>N<t>S<producto>34<t>TO<t>N<t>N<t>1<t>1<t>4622<t>N<t>S<producto>
		///codigo, tipoprod, incluido, actual, cantact, cantnva, valor, conpromo, cobrrecurrente
		
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$str = "";
		foreach($adicionales as $adicional){
			//Codigo
			$str = $str . $adicional->codigo . "<t>";  //codigo
			$str = $str . $adicional->tipo . "<t>"; // tipo
			$str = $str . (($adicional->grupo == "O") ? "S" : "N")   . "<t>"; //incluido 
			$str = $str . (($adicional->grupo == "A") ? "S" : "N")   . "<t>"; // actual
			$str = $str . $this->getCantidadServicioActual($adicional->codigo)   . "<t>"; //cant act
			$str = $str . $adicional->cantidad     . "<t>"; //cant nva
			$str = $str . $adicional->costo        . "<t>"; //valor
			$str = $str . $adicional->promo        . "<t>"; //valor
			$str = $str . $adicional->recurrente   . "<t>"; //valor
			
			$str = $str .  "<producto>";
		}
		return $str;
	}
	
	function getDetalleVenta($post){
		$s = '1184922<t>TO<t>553<t>23000<t>0<t>0<t>0<t>0<t>1837<t>21730<t>0<t>987.2<t>21730<t>22717.72<t>0<t>450<producto>1184923<t>TO<t>553<t>23000<t>0<t>0<t>0<t>0<t>1837<t>21730<t>0<t>987.2<t>21730<t>22717.72<t>0<t>450<producto>';
		
		$q = "insert into amc_detoferta(iddetoferta, nroOferta, producto, tipoprod, planact, vlrplanact, vlradiact,
                                                   vlrivaact, vlrtotactsiniva, vlrtotactconiva, plananvo, vlrplannvo, vlradinvo, vlrivanvo,
                                                   vlrtotnvosiniva, vlrtotnvoconiva, atributoact, atributonvo";
		//print_r($post);
		//Obtiene los productos actuales
		$this->obtenerProductosActuales();
		
		$oferta = Session::getVar("ofertaSeleccionada");
		$nuevaOferta = Session::getVar("nuevaOferta" );
		$info   = $this->getDatosClienteActual();
		$str = "";
		
		//Obtiene informacion de TO
		
		// Producto de TO
		if( isset($oferta->vlrTO) || isset($nuevaOferta->to) ){
		
		  	// Producto actual de TO
			if( isset($info->TO) && $info->TO != "" ){
				$str = $str . $info->TO . "<t>"; 
			}
			else{
				$str = $str . "-1" . "<t>"; 
			}

			//Tipo de producto
			$str = $str . "TO" . "<t>"; 
			
			// Plan actual
			$plan = "-1";
			if(isset($info->TO)){
				$plan = WebServices::getPlanProducto( $info->TO );
			}
			$str = $str . $plan . "<t>"; 
			
			//Valor plan actual
			if( isset($info->tarifa_to) ){
				$str = $str . Util::number_format($info->tarifa_to) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			//Valor adicionales actuales
			$adicTo = 0;
			foreach($info->servAdicionales as $tipoServicios){
				if(isset( $tipoServicios->tipo )  && $tipoServicios->tipo == "TO"){
					$adicTo = $tipoServicios->valor;
				}
			}
			$str = $str . Util::number_format($adicTo) . "<t>"; 
			
			//Valor iva actual
			if( isset($info->tarifa_to) ){
				$str = $str . Util::number_format( $info->tarifa_to * 16 /100)  . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor total actual sin iva
			if( isset($info->tarifa_to) ){
				$str = $str . Util::number_format($info->tarifa_to + $adicTo)  . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor total actual con iva
			if( isset($info->tarifa_to) ){
				$valor = (($info->tarifa_to + $adicTo) + ($info->tarifa_to + $adicTo) * 16 /100);
				$str = $str . Util::number_format($valor) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Plan nuevo TO
			$plan = "0";
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$plan = $this->getPlanOferta( $oferta->idOferta, "TO");
				$str = $str . $plan . "<t>"; 
			}
			else if( isset($nuevaOferta->to) && $nuevaOferta->to >0 ){
				$str = $str .$nuevaOferta->to . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}

			//Valor plan nuevo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . $oferta->vlrTO . "<t>"; 
			}
			else if( isset($nuevaOferta->to) && $nuevaOferta->to >0 ){
				// Obtener para oferta personalizada
				$str = $str . $nuevaOferta->toData->valor . "<t>"; 
			}else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor adicionales nuevos
			$totalAdicTO = $this->getTotalAdicionalesOfertaProducto("TO");
			$str = $str . $totalAdicTO . "<t>";
			
			// Valor iva nuevo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . $oferta->ivaTO . "<t>"; 
			}
			else if( isset($nuevaOferta->to) && $nuevaOferta->to >0 ){
				// Obtener para oferta personalizada
				$str = $str . $nuevaOferta->toData->valor * 16/100 . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// vlrtotnvosiniva
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . ($oferta->vlrTO + $totalAdicTO) . "<t>"; 
			}
			else if( isset($nuevaOferta->to) && $nuevaOferta->to >0 ){
				$str = $str . ($nuevaOferta->toData->valor + $totalAdicTO) . "<t>"; 
			}
			else{
				// Obtener para oferta personalizada
				$str = $str . "0" . "<t>"; 
			}
			
			//vlrtotnvoconiva
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . (($oferta->vlrTO + $totalAdicTO) + (($oferta->vlrTO + $totalAdicTO) *16/100)) . "<t>"; 
			}
			else if( isset($nuevaOferta->to) && $nuevaOferta->to >0 ){
				$str = $str . (($nuevaOferta->toData->valor + $totalAdicTO) + (($nuevaOferta->toData->valor + $totalAdicTO) *16/100)) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>";
			}
		
			//atributoact
			if(isset($info->min_producto)  ){
				$str = $str . $info->min_producto .  "<t>"; 
			}
			else{
				// Obtener para oferta personalizada
				$str = $str . "0" .  "<t>"; 
			}
			
			//atributonvo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$valor =  ($oferta->minutos == "Ilimitado" ? "9999" : $oferta->minutos); 
				$str = $str . $valor .  "<t>"; 
			}
			else if( isset($nuevaOferta->to) && $nuevaOferta->to >0 ){
				$valor = "0";
				$str = $str . $valor .  "<t>";	
			}
			else{
				$str = $str . "0" .  "<t>";	
			}
			$str = $str .  "<producto>"; 
		}
		
		
		
		// Producto TV
		if( isset($oferta->vlrTV) || isset($nuevaOferta->tv) ){
		
			if( isset($info->TV) && $info->TV != "" ){
				$str = $str . $info->TV . "<t>"; 
			}
			else{
				$str = $str . "-1" . "<t>"; 
			}
			//Tipo de producto
			$str = $str . "TV" . "<t>"; 
			
			// Plan actual
			$info->TV = isset($info->TV) ?  $info->TV : "";
			$plan = WebServices::getPlanProducto( $info->TV );
			if($plan == ""){
				$plan = "-1";
			}
			$str = $str . $plan . "<t>"; 
			
			
			//Valor plan actual
			if( isset($info->tarifa_tv) ){
				$str = $str . $info->tarifa_tv. "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			//Valor adicionales actuales
			$adicTv = 0;
			foreach($info->servAdicionales as $tipoServicios){
				if(isset( $tipoServicios->tipo )  && $tipoServicios->tipo == "TV"){
					$adicTv = $tipoServicios->valor;
				}
			}
			$str = $str . $adicTv . "<t>"; 
			
			//Valor iva actual
			if( isset($info->tarifa_tv) ){
				$str = $str . $info->tarifa_tv * 16 /100 . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor total actual sin iva
			if( isset($info->tarifa_tv) ){
				$str = $str . ($info->tarifa_tv + $adicTv)  . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor total actual con iva
			if( isset($info->tarifa_to) ){
				$str = $str . (($info->tarifa_tv + $adicTv) + ($info->tarifa_tv + $adicTv) * 16 /100) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Plan nuevo TV
			$plan = "0";
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$plan = $this->getPlanOferta( $oferta->idOferta, "TV");
				$str = $str . $plan . "<t>"; 
			}
			else if( isset($nuevaOferta->tv) && $nuevaOferta->tv >0 ){
				$str = $str .$nuevaOferta->tv . "<t>"; 
			}else{
				$str = $str . "0" . "<t>"; 
			}
			
			//Valor plan nuevo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . $oferta->vlrTV . "<t>"; 
			}
			else if( isset($nuevaOferta->tv) && $nuevaOferta->tv >0 ){
				// Obtener para oferta personalizada
				$str = $str . $nuevaOferta->tvData->valor . "<t>"; 
			}else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor adicionales nuevos
			$totalAdicTV = $this->getTotalAdicionalesOfertaProducto("TV");
			$str = $str . $totalAdicTV . "<t>";
			
			// Valor iva nuevo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . $oferta->ivaTV . "<t>"; 
			}
			else if( isset($nuevaOferta->tv) && $nuevaOferta->tv >0 ){
				// Obtener para oferta personalizada
				$str = $str . $nuevaOferta->tvData->valor * 16/100 . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// vlrtotnvosiniva
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . ($oferta->vlrTV + $totalAdicTV) . "<t>"; 
			}
			else if( isset($nuevaOferta->tv) && $nuevaOferta->tv >0 ){
				$str = $str . ($nuevaOferta->tvData->valor + $totalAdicTV) . "<t>"; 
			}
			else{
				// Obtener para oferta personalizada
				$str = $str . "0" . "<t>"; 
			}
			
			//vlrtotnvoconiva
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . (($oferta->vlrTV + $totalAdicTV) + (($oferta->vlrTV + $totalAdicTV) *16/100)) . "<t>"; 
			}
			else if( isset($nuevaOferta->tv) && $nuevaOferta->tv >0 ){
				$str = $str . (($nuevaOferta->tvData->valor + $totalAdicTV) + (($nuevaOferta->tvData->valor + $totalAdicTV) *16/100)) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>";
			}
		
			//atributoact
			$str = $str . "0" .  "<t>"; 
			
			//atributonvo
			$str = $str . "1" .  "<t>"; 
			$str = $str .  "<producto>"; 
		}
		
		
		// Producto BA
		if( isset($oferta->vlrBA)  ){
		
			if( isset($info->BA) && $info->BA != ""){
				$str = $str . $info->BA . "<t>"; 
			}
			else{
				$str = $str . "-1" . "<t>"; 
			}
			//Tipo de producto
			$str = $str . "BA" . "<t>"; 
			
			// Plan actual
			$plan = "-1";
			$productoBA = $this->getProductoAct("BA");
			if($productoBA != ""){
				$plan = WebServices::getPlanProducto($info->BA);
			}
			$str = $str . $plan . "<t>"; 
			
			//Valor plan actual
			if( isset($info->tarifa_ba) ){
				$str = $str . $info->tarifa_ba. "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			//Valor adicionales actuales
			$adicBa = 0;
			foreach($info->servAdicionales as $tipoServicios){
				if(isset( $tipoServicios->tipo )  && $tipoServicios->tipo == "BA"){
					$adicBa = $tipoServicios->valor;
				}
			}
			$str = $str . $adicBa . "<t>"; 
			
			//Valor iva actual
			if( isset($info->tarifa_ba) ){
				$str = $str . $info->tarifa_ba * 16 /100 . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor total actual sin iva
			if( isset($info->tarifa_ba) ){
				$str = $str . ($info->tarifa_ba + $adicBa)  . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor total actual con iva
			if( isset($info->tarifa_ba) ){
				$str = $str . (($info->tarifa_ba + $adicBa) + ($info->tarifa_ba + $adicBa) * 16 /100) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Plan nuevo BA
			$plan = "0";
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$plan = $this->getPlanOferta( $oferta->idOferta, "BA");
				if($plan == ""){
					$plan = "0";
				}
				$str = $str . $plan . "<t>"; 
			}
			else if( isset($nuevaOferta->ba) && $nuevaOferta->ba >0 ){
				$str = $str .$nuevaOferta->ba . "<t>"; 
			}else{
				$str = $str . "0" . "<t>"; 
			}
			
			
			//Valor plan nuevo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . $oferta->vlrBA . "<t>"; 
			}
			else if( isset($nuevaOferta->ba) && $nuevaOferta->ba >0 ){
				// Obtener para oferta personalizada
				$str = $str . $nuevaOferta->baData->valor . "<t>"; 
			}else{
				$str = $str . "0" . "<t>"; 
			}
			
			// Valor adicionales nuevos
			$totalAdicBA = $this->getTotalAdicionalesOfertaProducto("BA");
			$str = $str . $totalAdicBA . "<t>";
			
			// Valor iva nuevo
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . $oferta->ivaBA . "<t>"; 
			}
			else if( isset($nuevaOferta->ba) && $nuevaOferta->ba >0 ){
				// Obtener para oferta personalizada
				$str = $str . $nuevaOferta->baData->valor * 16/100 . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}
			
			// vlrtotnvosiniva
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . ($oferta->vlrBA + $totalAdicBA) . "<t>"; 
			}
			else if( isset($nuevaOferta->ba) && $nuevaOferta->ba >0 ){
				$str = $str . ($nuevaOferta->baData->valor + $totalAdicBA) . "<t>"; 
			}
			else{
				// Obtener para oferta personalizada
				$str = $str . "0" . "<t>"; 
			}
			
			//vlrtotnvoconiva
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$str = $str . (($oferta->vlrBA + $totalAdicBA) + (($oferta->vlrBA + $totalAdicBA) *16/100)) . "<t>"; 
			}
			else if( isset($nuevaOferta->ba) && $nuevaOferta->ba >0 ){
				$str = $str . (($nuevaOferta->baData->valor + $totalAdicBA) + (($nuevaOferta->baData->valor + $totalAdicBA) *16/100)) . "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>";
			}
		
			//atributoact
			if(isset($info->vel_producto)  ){
				$str = $str . $info->vel_producto .  "<t>"; 
			}
			else{
				$str = $str . "0" . "<t>"; 
			}

			//atributonvo
			$atrNvo = "-1";
			if(isset($oferta->idOferta) && $oferta->idOferta > 0 ){
				$atrNvo = $oferta->velocidad;
				if($atrNvo == ""){
					$atrNvo = "-1";
				}
			}
			else{
				// Obtener para oferta personalizada
				$atrNvo =  "0" ; 
			}
			$str = $str . $atrNvo .  "<t>"; 
			$str = $str .  "<producto>"; 
		}
	
		return $str;
	}
	
	function getEncabezadoVenta($post, $dirInstalacion, $dirCobro){
		$s = "66001<t>PEREIRA<t>1046616<t>MZ 24 CS 10 COMFAMILIAR CUBA<t>1088275135<t>JUAN CAMILO<t>LOTERO GONZALES<t>A<t>N<t>N<t>3<t>2<t>3<t>N<t>N<t>X<t>X<t>S<t>1906534<t>78621<t>0<t>78621<t>0<t>553<t>
		SUPERPLAY 10M HD PREMIUM<t>115497<t>0<t>134678<t>14975.96<t>0<t>NA<t>N<t>N<t>N<t>S<t>S<t>S<t>V<t>AROJAS<t>TO+TV+BA<t>TO=1906530-TV=1973256-BA=1906531<t>
		TO=19845-TV=27776-BA=31000<t>TO:32=0|1-39=0|1-2190=0|1-19996=0|2;TV:9206=0|1-9315=19181|1-19988=0|3<t>19181<t>0<t>146585<item>";
		
		/*
		nrooferta, idmpio, mpio, iddirinst, dirinst, nitced, nombre, apellido, scoring, dirnueva, cltenuevo,
                                   ciclo, categoria, subcategoria, hfc, xdsl, iptv, gpon, cobre, prodbase, vlrprodssact, vlradisact, vlrtotact,
                                   vlrivaact, idoferta, descoferta, vlrprodsoferta, vlradioferta, vlrtotoferta,  vlrivaoferta, vlrdiferencia,
                                   clase, nuevo_to, nuevo_tv, nuevo_ba, oferta_incl_to, oferta_incl_tv, oferta_incl_ba, estado,
                                   usuareg, compo_act, productos_act , vlrsprod_act, adicionales_act , vlradirecurr, vlradinorecurr, vlrfact1,
                                   
		*/
		
		$info   = $this->getDatosClienteActual();
		$oferta = Session::getVar("ofertaSeleccionada");
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$totalPlan 			= $this->getTotalesOferta();
		$totalAdicionales =   $this->getTotalesServiciosAdicionales();
		$totales 			= $this->calcularTotalesVenta($totalPlan, $totalAdicionales);
		
		$str = "";
		
		// Datos de direccion
		$data = WebServices::consultarDireccionPorId($dirInstalacion);
		$data = explode("<tag>", $data);
		
		// Municipio
		$str = $str . $data[5] . "<t>"; 
		$str = $str . $data[6] . "<t>";
		// Direccion 
		$str = $str . $data[0] . "<t>"; 
		$str = $str . $data[1] . "<t>";
		//Cedula
		$str = $str . $post["cedula"] . "<t>";
		// Nombres
		$str = $str . $post["nombres"] . "<t>";
		$str = $str . $post["apellidos"] . "<t>";
		// Scoring
		$str = $str . "A" . "<t>";
		//Nueva direccion
		$str = $str . ($post["cnuevadireccion"] == 1 ? "S" : "N") . "<t>";
		//Cliente  nuevo
		$str = $str . ( isset($info->segmento) ?  "N" : "S") . "<t>";
		// Ciclo
		$str = $str . $info->ciclo . "<t>";
		//Categoria
		$categoria = explode("-", $info->categoria);
		$str = $str . $categoria[0]. "<t>";
		//Sub Categoria
		$subcategoria = explode("-", $info->subcategoria);
		$str = $str . $subcategoria[0]. "<t>";
		// HFC
		$str = $str . "N". "<t>";
		// XDSL
		$str = $str . "N". "<t>";
		// IPTV
		$str = $str . "N". "<t>";
		// Gpon
		$str = $str . "N". "<t>";
		// Cobre
		$str = $str . "N". "<t>";
		// Producto base
		$str = $str . ( isset($info->producto)  ? $info->producto : "") . "<t>";
		// Valores productos actuales
		$str = $str . ( isset($info->tarifa_paq)  ? Util::number_format($info->tarifa_paq) : "0") . "<t>";
		// Valores adicionales actuales
		$str = $str . ( isset($info->totalAdicionales)  ? Util::number_format($info->totalAdicionales,2) : "0") . "<t>";
		// Valor total actual
		$str = $str . ( isset($info->tarifa_paq)  ? Util::number_format( $info->tarifa_paq + $info->totalAdicionales,2) : "0") . "<t>";
		// Valor iva actual
		$ivaAct = ($info->tarifa_paq + $info->totalAdicionales) * 16/100;
		$str = $str . ( isset($info->tarifa_paq)  ?  Util::number_format($ivaAct, 2) : "0") . "<t>";
		// Id Oferta
		if( isset($oferta->idOferta) ){
			$str = $str . $oferta->idOferta . "<t>";
		}
		else{
			$str = $str . "0" . "<t>";
		}
		//Descripcion oferta
		$adicionales = $totalAdicionales["recurrentes"] ;//+ $totalAdicionales["pagoUnico"];
		if( isset($oferta->nomOferta) ){
			$iva = ($oferta->ivaTO + $oferta->ivaTV + $oferta->ivaBA) + ( $adicionales * 16/100);
			$descripcion = $oferta->nomOferta . ", Clase = " . $this->getTipoVenta() . ", Vlr Prods=" . $oferta->vlrProds . 
			               ", Vlr Adi=" . $adicionales . ", Vlr Iva=" . $iva . ", Vlr Neto con Iva=" . ($oferta->vlrProds + $adicionales + $iva );
			Session::setVar("descripcionVentaActual", $descripcion);
			$descripcion = substr($descripcion, 0,200);
			$str = $str . $descripcion . "<t>";

		}
		else{
			$nombre = Session::getVar("nombreOfertaCustomizada");
			$iva = ( $totalPlan + $totalAdicionales["recurrentes"] ) *16/100;
			$total = $totalPlan + $adicionales + $iva;
			$descripcion = $nombre . ", Clase = " . $this->getTipoVenta() . ", Vlr Prods=" . $totalPlan . 
			               ", Vlr Adi=" . $adicionales . ", Vlr Iva=" . $iva . ", Vlr Neto con Iva=" . $total;
			Session::setVar("descripcionVentaActual", $descripcion);
			$descripcion = substr($descripcion, 0,200);
			$str = $str . $descripcion . "<t>";
		}
		// Valor productos oferta
		if( isset($oferta->vlrProds) ){
			$str = $str . $oferta->vlrProds . "<t>";
		}
		else{
			$str = $str . $totalPlan . "<t>";
		}
		// Valor adicionales oferta
		if( isset($oferta->vlrRadio) ){
			$str = $str . Util::number_format( $totalAdicionales["recurrentes"],2 ) . "<t>";
		}
		else{
			$str = $str . Util::number_format( $totalAdicionales["recurrentes"],2 ) . "<t>";
		}
		// Valor total oferta
		if( isset($oferta->vlrOferta) ){
			$str = $str . Util::number_format( $oferta->vlrOferta, 2) . "<t>";
		}
		else{
			$str = $str . Util::number_format( $totalPlan , 2) . "<t>";
		}
		// Valor iva oferta
		if( isset($oferta->ivaTO) ){

			$iva = ($oferta->ivaTO + $oferta->ivaTV + $oferta->ivaBA) + ( $totalAdicionales["recurrentes"] * 16/100);
			$str = $str . Util::number_format($iva, 2) . "<t>";
		}
		else{
			$iva = ( $totalPlan + $totalAdicionales["recurrentes"] ) *16/100;
			$str = $str . $iva . "<t>";
		}
		// Valor diferencia 
		if( isset($oferta->vlrOferta) ){
			$diferencia = ( $oferta->vlrOferta + $totalAdicionales["recurrentes"] - $this->getTarifaActual() );
			$str = $str .  Util::number_format($diferencia, 2)  . "<t>";
		}
		else{
			$diferencia = ( $totalPlan  + $totalAdicionales["recurrentes"] - $this->getTarifaActual() );
			$str = $str . Util::number_format($diferencia, 2) . "<t>";
		}
		//Clase
		$str = $str .  $this->getTipoVenta() . "<t>";

		//Nuevo to
		$nuevaOferta = Session::getVar("nuevaOferta" );
		if( (isset($oferta->vlrTO) && $oferta->vlrTO > 0  && strpos( $info->servicios, "TO" ) === false ) ||
			(isset($nuevaOferta->to) && $nuevaOferta->to >0   && strpos( $info->servicios, "TO" ) === false )
			){
			$str = $str .  "S" . "<t>";
		}
		else{
			$str = $str .  "N" . "<t>";
		}
		// Nuevo TV
		if(  (isset($oferta->vlrTV) && $oferta->vlrTV > 0  && strpos( $info->servicios, "TV" ) === false ) ||
			 (isset($nuevaOferta->tv) && $nuevaOferta->tv >0   && strpos( $info->servicios, "TV" ) === false )
			){
			$str = $str .  "S" . "<t>";
		}
		else{
			$str = $str .  "N" . "<t>";
		}
		// Nuevo BA
		if(  (isset($oferta->vlrBA) && $oferta->vlrBA > 0  && strpos( $info->servicios, "BA" ) === false) ||
			 (isset($nuevaOferta->ba) && $nuevaOferta->ba >0   && strpos( $info->servicios, "BA" ) === false )
		 ){
			$str = $str .  "S" . "<t>";
		}
		else{
			$str = $str .  "N" . "<t>";
		}
		// Oferta incluye to
		if( ( isset($oferta->vlrTO) && $oferta->vlrTO > 0 ) || (isset($nuevaOferta->to) && $nuevaOferta->to >0 )  ){
			$str = $str .  "S" . "<t>";
		}
		else{
			$str = $str .  "N" . "<t>";
		}
		// Oferta incluye tv
		if( (isset($oferta->vlrTV) && $oferta->vlrTV > 0 ) || (isset($nuevaOferta->tv) && $nuevaOferta->tv >0 )  ){
			$str = $str .  "S" . "<t>";
		}
		else{
			$str = $str .  "N" . "<t>";
		}
		// Oferta incluye ba
		if( (isset($oferta->vlrBA) && $oferta->vlrBA > 0 ) || (isset($nuevaOferta->ba) && $nuevaOferta->ba >0 )   ){
			$str = $str .  "S" . "<t>";
		}
		else{
			$str = $str .  "N" . "<t>";
		}
		// Estado
		$str = $str . "V" . "<t>";
		// Usuario
		$user = JFactory::getUser();
		$str = $str . $user->username . "<t>";
		//Componentes activos
		$servicios = isset($info->servicios) ? $info->servicios : "";
		$str = $str . str_replace("-", "+",$servicios) . "<t>";
		// Productos
		$productos  = isset($info->productos) ? $info->productos : "";
		$str = $str . $productos . "<t>";
		// Valor productos
		if( isset($info->valor_productos) ){
			$str = $str . Util::number_format( (double) $info->valor_productos, 2 ) . "<t>";
		}
		else{
			$str = $str . "" . "<t>";
		}
		
		if( isset($info->adicionales) ){
			// Adicionales actuales
			$adicionales = ($info->adicionales > 0) ? $info->adicionales : 0;
			$str = $str . Util::number_format( (double) $adicionales ,2 ) . "<t>";
			//Valor Adicionales recurrentes
			$recurrentes = ($info->recurrentes > 0) ? $info->recurrentes : 0;
			$str = $str . Util::number_format( (double) $recurrentes,2) . "<t>";
			//Valor Adicionales no recurrentes
			$noRecurrentes = ($info->noRecurrentes > 0) ? $info->noRecurrentes : 0;
			$str = $str . Util::number_format( (double) $noRecurrentes , 2 ) . "<t>";
		}
		else{
			$str = $str . "0" . "<t>";
			$str = $str . "0" . "<t>";
			$str = $str . "0" . "<t>";
		}
		
		//Valor Factura 1
		$str = $str . Util::number_format($totales["primerMes"],2) . "<item>";
	
		//$this->compararCadenas($str, $s);
		//exit;
		return $str;
	}
	
	function getSolicitudVenta($post, $dirInstalacion, $dirCobro){
		$str = '4519767<t>NELSON<t>66001<t>KR 15 BIS 22-04<t>66001007003000<t>3206605484<t>3147677007<t>NELSONDUQUE@OUTLOOK.COM<t><t>HOGARES<t>2<t>0<t>2<t>4<t>25/06/2014<t>25/06/2014<t>3<t>1498<t>228<t>MAPEREZD<t>BACKHOGARES3<t>1<t>LLAMADA ENTRANTE<t>ASTCEN1-1403623146.564893<t>57000<t>0<t>NO APLICA<t>ETPAGMO 83866 //  27 JUNIO AM<t>813240<t>S<t>KR 15 BIS 22-04<t>0<t>0<t><t><t><t><t>A<t>66001<t>66001007003000<t>813240<t><t>CALLVENTAS26<t>N<t>N<t>C<t>DUQUE CEBALLOS<t><t><t><t><t>No Aplica<t>N<t>S<t>S<t>S<t>S<t>S<t>N<t>N<t>S<t>3206605484 3147677007<t>DUO TO 450 Min + BA 5M. Clase = NA, Vlr Prods = 57000, Vlr Adi = 0, Vlr Iva = 9120, Vlr Neto con Iva = 66120<t><t><t><t><t><item>';
		/*
		queryDin := '   insert into etp.carr_solicitud (consecutivo_sol,  fecha_solicitud, fecha_registro) 
                        values
                        ('|| nroCarr_solicitud || ',' || queryData || ',''' || SYSDATE || ''', ''' || SYSDATE || ''')';
						
						cedula_nit, nombre, localidad, direccion, cod_barrio, tel_auxiliar, tel_celular, 
						
                        e_mail, repr_legal, segmento, ciclo, ruta, categoria, subcategoria,  fecha_inic_tramite, fecha_fin_tramite, estado, cod_vendedor, 
                        canal, usuario_reg, cod_funcionario, tipo_solicitud, tipo_contacto, id_llamada, vlr_oferta, vlr_prom_fact, acierta, 
                        observacion, id_direccion, acepta_permanencia, dir_cobro, vlr_oferta_compl1, vlr_oferta_compl2, paquete_id, finpermapaq, 
                        cod_referidor, nro_transaccion, scoring, locadircobr, codbarrdircobr, iddircobr, cod_referencia, maquina, pc_ba, contacto_pc_ba, 
                        envio_cntr, apellidos, nrocntrmora, vlrpend, tipoprodfin, prodfin, aceptacesion, dircobrodif, hd_mail, hd_ivr, hd_sms, 
                        hd_campanasal, hd_correodir, hd_ninguna, hd_decretopresu, hd_autorizacion, tel_celular2, descoferta, fecagenda, jornada, 
                        envio_factura, down_retiro, ptoventa,
		*/
		$user = JFactory::getUser();
		$info = Session::getVar("infoCliente");
		$info = $info[0];
		$oferta = Session::getVar("ofertaSeleccionada");
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$totalPlan 			= $this->getTotalesOferta();
		$totalAdicionales =   $this->getTotalesServiciosAdicionales();
		$totales 			= $this->calcularTotalesVenta($totalPlan, $totalAdicionales);
		
		$direccion = WebServices::consultarDireccionPorId($dirInstalacion);
		$direccionCobro = WebServices::consultarDireccionPorId($dirCobro);
		$direccion = explode("<tag>", $direccion);
		$direccionCobro = explode("<tag>", $direccionCobro);
	
		$str = "";
		//Cedula
		$str = $str . $post["cedula"]. "<t>";
		// Nombre
		$str = $str . $post["nombres"] . "<t>";
		// Cod localidad
		$str = $str . $direccion[5] . "<t>";
		// Direccion
		$str = $str . $direccion[1] . "<t>";
		// cod barrio
		$str = $str . $direccion[3] . "<t>";
		// tel auxilia
		$str = $str . $post["tel_aux"] . "<t>";
		// tel celular
		$str = $str . $post["celular1"] . "<t>";
		// email
		$str = $str . $post["correo"] . "<t>";
		// represen legal
		$str = $str . "" . "<t>";
		// segmento
		$str = $str . "HOGARES" . "<t>";
		//ciclo
		$str = $str . $post["ciclo"] . "<t>";
		//ruta
		$str = $str . "" . "<t>";
		//categoria
		$subCategoria = $post["tsubCategoria"];
		$subCategoria = explode(")", $subCategoria);
		$categoria = $subCategoria[0][1];
		$subCategoria = $subCategoria[0][3];
		$str = $str . $categoria . "<t>";
		// subcategoria
		$str = $str . $subCategoria . "<t>";
		//fecha inic tramite
		$fecha = date('d/m/Y');
		$str = $str . $fecha . "<t>";
		// fecha fin tramite 
		$str = $str . "" . "<t>";
		// estado
		$str = $str . "1" . "<t>";
		// codvendedor
		$str = $str . $user->codVendedor . "<t>";
		// canal
		$str = $str . $user->canal . "<t>";
		// usuario reg
		$str = $str . $user->username . "<t>";
		// cod funcionario
		$str = $str . "" . "<t>";
		// tipo solicitud
		$str = $str . $post["tipoSolicitud"] . "<t>";
		// tipo contacto
		$tipoContacto ="";
		if( $post["tipoContacto"] == "D"){
			$tipoContacto = "VENTA DIRECTA";
		}
		else if( $post["tipoContacto"] == "E"){
			$tipoContacto = "LLAMADA ENTRANTE";
		}
		else if( $post["tipoContacto"] == "s"){
			$tipoContacto = "LLAMADA SALIENTE";
		}
		$str = $str . $tipoContacto  . "<t>";
		// id llamada
		$str = $str . ""  . "<t>";
		// vlr oferta sin iva
		if(isset($oferta->vlrOferta)){
			$str = $str . Util::number_format($oferta->vlrProds + $totalAdicionales["recurrentes"],2)  . "<t>";
		}
		else{
			$str = $str . Util::number_format($totalPlan + $totalAdicionales["recurrentes"],2)  . "<t>";
		}
		// prom fact
		$str = $str . "0"  . "<t>";
		//acierta,
		$str = $str . $post["acierta"]  . "<t>";
		//observacion
		$str = $str . $post["observaciones"]  . "<t>";
		//id direccion
		$str = $str . $direccion[0]  . "<t>";
		//acepta permanencia
		$str = $str . "S"  . "<t>";
		// dir cobro
		// [0] => 1089061 [1] => KR 25 # 86 - 141 BLQ ROJO CSA 3 [2] => KR 25 86-141 BLQ ROJO CSA 3 [3] => 66001011062000 [4] => COLORES DE LA VILLA [5] => // 66001 [6] => PEREIRA
		$str = $str . $direccionCobro[1]  . "<t>";
		// vlr_oferta_compl1 
		$str = $str . "0"  . "<t>";
		// vlr_oferta_compl2
		$str = $str . "0"  . "<t>";
		// paquete id 
		$str = $str . ""  . "<t>";
		// finpermapaq 
		$str = $str . ""  . "<t>";
		// cod_refefidor 
		$str = $str . $post["referidor"]   . "<t>";
		// nro transaccion
		$str = $str . $post["transaccion"]   . "<t>";
		// scoring
		$str = $str . "A"   . "<t>";
		// locadircobr
		$str = $str . $direccionCobro[5]  . "<t>";
		// codbarrdircobr
		$str = $str . $direccionCobro[3]  . "<t>";
		// iddircobr
		$str = $str . $direccionCobro[0]  . "<t>";
		// cod_referencia
		$str = $str . ""   . "<t>";
		// maquina
		$str = $str . "VENTA MOVIL"   . "<t>";
		// pc_ba
		$str = $str . ""   . "<t>";
		// contacto pc_ba
		$str = $str . ""   . "<t>";
		// enviar contrato
		$str = $str . $post["enviarContrato"]   . "<t>";
		// apellidos
		$str = $str . $post["apellidos"]   . "<t>";
		// nrocntrmora
		$str = $str . $post["contratoMora"]   . "<t>";
		// vlrpend
		$str = $str . $post["valorPendiente"]   . "<t>";
		// tipoprodfin
		$str = $str . $post["tipoProdFin"]   . "<t>";
		// prodfin
		$str = $str . $post["prodFinan"]   . "<t>";
		// aceptacesion
		$str = $str . ""  . "<t>";
		// dircobrodif
		$str = $str . ""  . "<t>";
		// hdmail
		$str = $str . (($post["cmail"] == 1) ? "S" : "N" )  . "<t>";
		// hdivr
		$str = $str . (($post["civr"] == 1) ? "S" : "N" )   . "<t>";
		// hdsms
		$str = $str . (($post["csms"] == 1) ? "S" : "N" )   . "<t>";
		// hd_campana
		$str = $str . (($post["csalida"] == 1) ? "S" : "N" )   . "<t>";
		// hd_correodir
		$str = $str . (($post["csalida"] == 1) ? "S" : "N" )   . "<t>";
		// hd_ninguna
		$str = $str .  "N"   . "<t>";
		// hd_decretopresu
		$str = $str . (($post["cpresuncion"] == 1) ? "S" : "N" )   . "<t>";
		// hd_autorizacion
		$str = $str . (($post["cautoriza"] == 1) ? "S" : "N" )   . "<t>";
		// tel celular2
		$str = $str . $post["celular2"]   . "<t>";
		// desc oferta
		$descripcion = Session::getVar("descripcionVentaActual");
		$str = $str . $descripcion   . "<t>";
		/*if(isset($oferta->vlrOferta)){
			$total = ($oferta->vlrProds + $totalAdicionales["recurrentes"]) + ($oferta->vlrProds + $totalAdicionales["recurrentes"]) *16/100 ;
			$str = $str . ($oferta->nomOferta  . "Vlr neto con iva=". Util::number_format($total,2) )  ."<t>";
		}
		else{
			$total = ($totalPlan + $totalAdicionales["recurrentes"]) + ($totalPlan + $totalAdicionales["recurrentes"]) *16/100 ;
			$nombre = Session::getVar("nombreOfertaCustomizada");
			$nombre = substr($nombre, 0,150);
			$str = $str . $nombre . "Vlr neto con iva=". Util::number_format($total,2) . "<t>";
		}*/
		//fecagenda
		$fecha = $this->getFechaFormato($post["fecha"]);
		$str = $str . $fecha   . "<t>";
		//  jornada
		$str = $str . $post["jornada"]   . "<t>";
		//envio_factura, 
		$str = $str . $post["enviarFactura"] . "<t>";
		//down retiro
		$str = $str . ""  . "<t>";
		//ptoventa,
		$str = $str . ""  . "<t><item>";
		return $str;
	}
	
	/*
	Obtiene la cantidad de servicios adicionales de un tipo determinado
	Grupo de servicios  A: Actuales, O:Oferta, N:Nuevos
	*/
	function getCantAdi($clase, $tipo){
		// Tipo A Actual
		// Tipo N Nuevo
		// Tipo O Oferta
		
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$cant = 0;
		foreach($adicionales as $adicional){
			
			if($adicional->codigo == $clase && $adicional->grupo == $tipo ){
				$cant = $cant + $adicional->cantidad ;
			}
			
		}

		return $cant;
	}
	
	/*Retorna la cantidad de elementos a cobrar de una clase*/
	function getCantAdiCobrar($clase){
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$cantAct = 0;
		$cantNuevo = 0;
		$cobrar = 0;
		foreach($adicionales as $adicional){
			if($adicional->codigo == $clase){
				$servAdi = $this->getServicioAdicionalPorCodigo($adicional->codigo);
				$cobrar = $adicional->cantidad - $servAdi->cantinicobro;
				if($cobrar < 0){
					$cobrar = 0;
				}
			}
		}
		return $cobrar;
	}
	
	function getOtrosAdi($tipo){
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$servicios = "";

		foreach($adicionales as $adicional){
			
			if($adicional->grupo == 'N' || $adicional->grupo == 'O'){
				// Excluye algunos servicios de TO y TV
				if( ! in_array($adicional->codigo, array("19996",  "19997", "19998", "19999", "9200", "9341", "19988" ) ) ){
					if($adicional->tipo == $tipo ){
						$servicios = $servicios . $adicional->descripcion . ",";	
					}
					
				}
			}
		}
		return $servicios;

		/*DataRow[] reg = null;
            //Se excluyen de TO algunas clases de uso
            if (Tbl == kTblServAdiTo)
                reg = dsDatos.Tables[Tbl].Select("(incluido = 'S' or adicionar = 'S') and codigo not in (19996, 19997, 19998, 19999)");
 
            if (Tbl == kTblServAdiTv)
                reg = dsDatos.Tables[Tbl].Select("(incluido = 'S' or adicionar = 'S') and codigo not in (9200, 9341, 19988)");
 
            if (reg.Length == 0)
                return string.Empty;
 
            string Lta = string.Empty;
 
            for (int i = 0; i < reg.Length; i++)
            {
                if (Lta != string.Empty)
                    Lta += ",";
 
                Lta += reg[i]["nomserv"].ToString();
            }
			return Lta;*/
		return "null";
	}
	
	function getDetalleSolicitudVenta($post){
		// Insert en las tablas basicas
		/*
		TO
		consecutivo_detsol,consecutivo_sol,tipo_producto,ba_producto, ba_nro_serv,pqt_producto,pqt_tramite,ba_tramite,a_plan_actual,ba_plan_nuevo,
        ba_vel_actual,ba_vel_nueva,ba_tecnologia,pqt_valor,pqt_plan_actual,pqt_plan_nuevo,ba_equipo,ipfija,segundo_acceso,consubsidio*/
		//echo "insert TO";   
		$str = "";
		$insertTO = $this->getInsertDetSolTO();
		if($insertTO != ""){
			$str = $str . $insertTO . "<t>";
		}
		//echo $insertTV;
	    $insertTV = $this->getInsertDetSolTV();
		if($insertTV != ""){
			$str = $str . $insertTV . "<t>";
		}
		//echo $insertBA;
		$insertBA = $this->getInsertDetSolBA();
		if($insertBA != ""){
			$str = $str . $insertBA . "<t>";
		}
		
		$insertLinAdic = $this->getInsertLinAdic();
		if($insertLinAdic != ""){
			$str = $str . $insertLinAdic . "<t>";
		}

		/*$insertLinAdic = $this->getInsertLinAdic();
		if($insertLinAdic != ""){
			$str = $str . $insertLinAdic ;
		}*/
		
		$insertSoftphonePc = $this->getInsertSoftphonePc();
		if($insertSoftphonePc != ""){
			$str = $str . $insertSoftphonePc ;
		}

		$insertSoftphoneMovil = $this->getInsertSoftphoneMovil();
		if($insertSoftphoneMovil != ""){
			$str = $str . $insertSoftphoneMovil ;
		}
		
		
        // Guarda en el detalle los servicios adicionales SOFTPHONE, SOFTPHONE MOVIL Y LINEAS ADICIONALES
		/*$adicionales = Session::getVar("venta_servicios_adicionales");
		$str = "";
		foreach($adicionales as $adicional){
			$adicional->codigo
			//producto, tipoprod, planact, vlrplanact, vlradiact,
            //vlrivaact, vlrtotactsiniva, vlrtotactconiva, plananvo, vlrplannvo, vlradinvo, vlrivanvo,
            //vlrtotnvosiniva, vlrtotnvoconiva, atributoact, atributonvo
			/*
			$str = $str . $adicional->codigo . "<t>";  //codigo
			$str = $str . $adicional->tipo . "<t>"; // tipo
			$str = $str . (($adicional->grupo == "O") ? "S" : "N")   . "<t>"; //incluido 
			$str = $str . (($adicional->grupo == "A") ? "S" : "N")   . "<t>"; // actual
			$str = $str . $this->getCantidadServicioActual($adicional->codigo)   . "<t>"; //cant act
			$str = $str . $adicional->cantidad     . "<t>"; //cant nva
			$str = $str . $adicional->costo        . "<t>"; //valor
			$str = $str . $adicional->promo        . "<t>"; //valor
			$str = $str . $adicional->recurrente   . "<t>"; //valor
			*/
		//}*/
		
		return $str;	
	}
	
	function getDireccionInstalacionVenta($post){
		$cnuevaDireccion = $post["cnuevadireccion"];
		if($cnuevaDireccion == "1"){
			$barrio = $post["barrioN"];
			$localidad = substr($barrio, 0, 5);
			$direccionNueva = $post["direccionNueva"];
			$result = WebServices::chequearDireccion($direccionNueva, $localidad, $barrio);
			$result = explode("<tag>", $result);
			if( $result[1] != ""){
				return -1;
			}
			$result = WebServices::insertarDireccion($direccionNueva, $localidad, $barrio);
			$result = explode("<tag>", $result);
			if($result[2] == ""){
				return $result[0]; 
			}
			else{
				return -1;
				//return $result[2] . "|" . $result[3];
			}
		}
		else{
			$direccion = $post["direccion"];
			if($direccion != ""){
				return $direccion;
			}
		}
		return -1;
	}
	
	/**Retorna la direccion de cobro del servicio
	   -1 si la direccion es incosistente
	   0 si usara la misma direccion de instalacion
	   id de la direccion de cobro
	*/
	function getDireccionCobroVenta($post){
		$cIgualDireccion = $post["cigualdireccion"];
	    if( $cIgualDireccion == "1"){
			return 0;
		}
		$cnuevaDireccion = $post["cnuevadireccioncobro"];
		if($cnuevaDireccion == "1"){
			$barrio = $post["barrioCN"];
			$localidad = substr($barrio, 0, 5);
			$direccionNueva = $post["direccionNuevaCobro"];
			
			$result = WebServices::chequearDireccion($direccionNueva, $localidad, $barrio);
			$result = explode("<tag>", $result);
			if( $result[1] != ""){
				return -1;
			}
			
			$result = WebServices::insertarDireccion($direccionNueva, $localidad, $barrio);
			$result = explode("<tag>", $result);
			print_r($result);
			if( $result[2] == ""){
				return $result[0]; 
			}
			else{
				return -1;
				//return $result[2] . "|" . $result[3];
			}
		}
		else{
			$direccion = $post["direccion"];
			if($direccion != ""){
				return $direccion;
			}
		}
		return -1;
	}
	
	/*Obtiene el id de los productos actuales del cliente*/
	function obtenerProductosActuales(){
		$data = Session::getVar("infoCliente");
		$info = $data[0];
		
		if(isset($info->productos) && $info->productos != "" ){
			echo $info->productos;
			$productos = explode("-", $info->productos);
			foreach($productos as $producto){
				$producto = explode("=", $producto);
				print_r($producto);
				$info->{$producto[0]} = $producto[1];
			}
			Session::setVar("infoCliente", $data);
		}
	}
	
	function guardarVentaTemporal($post, $encVenta, $detVenta , $adiVenta  , $solVenta  , $solDetVenta, $datosAgenda){
		JTable::addIncludePath(JPATH_COMPONENT .DS. 'tables');	
		$row =& JTable::getInstance('Ventas', 'Table');
		$user = JFactory::getUser();
		
		$row->user = $user->username ;
		$row->fecha = Util::getDate();
		$row->cedula = $post["cedula"] ;
		$row->nombres = $post["nombres"] . " " .  $post["apellidos"];
		$row->enc_oferta = $encVenta;
		$row->det_oferta = $detVenta;
		$row->adi_oferta = $adiVenta;
		$row->sol_oferta = $solVenta;
		$row->detsol_oferta = $solDetVenta;
		$row->agenda = $datosAgenda;
		$row->estado  = "P";
		
		if($row->store()){
			return $row->id;
		}
		else{
			return 0;
		}
		
	}
	
	/**Registra la venta en OSF y actualiza el estado de acuerdo a la respuesta*/
	function registrarVentaOsf($idVenta){
		//echo "registrando venta = " . $idVenta;
		$db = JFactory::getDBO();
		$tbVentas = $db->nameQuote('#__zventas');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbVentas as v
				  WHERE 
						estado = 'P' AND
						id = %s
						";
						
		$query = sprintf( $query, $idVenta );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		$result = $result[0];
		
		// Obtener datos para llamar servicio web
		$encOferta = $result->enc_oferta;
		$detOferta = $result->det_oferta;
		$adiOferta = $result->adi_oferta;
		$solOferta = $result->sol_oferta;
		$detSolOferta = $result->detsol_oferta;
		$agenda    = $result->agenda;
		
		echo $encOferta;
		$result = WebServices::registrarNuevaVenta($encOferta, $detOferta, $adiOferta, $solOferta, $detSolOferta, $agenda);
		//echo "resultado venta= ";
		//print_r($result);
		
		$datos = explode("|", $result);
		if(strpos($result, "OK") !== FALSE){
			$solicitud = $datos[1];
			$this->actualizarVenta($idVenta, $solicitud, "T");
			$msg = "Venta registrada con solicitud : " . $solicitud;
		}
		else{
			$msgError = $datos[0];
			$msgDb = $datos[1];
			$this->actualizarVenta($idVenta, $msgDb, "P");
			$msg = $msgError;
		}

		return $msg;
	}
	
	/**Retorna el plan comercial de un producto(TO TV BA) de la oferta
	* @param oferta id de la oferta
	* @param producto 
	*/
	function getPlanOferta($oferta, $producto){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbOfertas = $db->nameQuote('#__zofertaplanes');	
		
		$query = "SELECT 
						*
				  FROM 
						$tbOfertas as o
				  WHERE 
						oferta = %s  AND
						prodoferta = '%s'  
						";
						
		$query = sprintf( $query, $oferta, $producto );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		$result = isset($result[0]) ? $result[0] : "" ;
		$result = isset($result->planes) ? $result->planes : "";
		if(strpos($result, ";")){
			$result = explode(";", $result);
			$result = $result[0];
		}
		return $result ;
	}
	
	
	
	/**Retorna el plan comercial de un producto(TO TV BA) de la oferta*/
	function getClaseOferta($oferta, $producto){
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$tbOfertas = $db->nameQuote('#__zofertaplanes');	
		$query = "SELECT 
						*
				  FROM 
						$tbOfertas as o
				  WHERE 
						oferta = %s  AND
						prodoferta = '%s'  
						";
						
		$query = sprintf( $query, $oferta, $producto );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		$result = $result[0];
		$result = isset($result->claserv) ? $result->claserv : "";
		if(strpos($result, ";")){
			$result = explode(";", $result);
			$result = $result[0];
		}
		return $result;
	}
	
	/*
	* Crea el insert de la TO de la oferta
	*/	
	function getInsertDetSolTO(){
		//Inserta TO
		$info   = $this->getDatosClienteActual();
		$oferta = Session::getVar("ofertaSeleccionada");
		$nuevaOferta = Session::getVar("nuevaOferta" );
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$totalPlan 			= $this->getTotalesOferta();
		$totalAdicionales =   $this->getTotalesServiciosAdicionales();
		$totales 			= $this->calcularTotalesVenta($totalPlan, $totalAdicionales);
		//
		$str ="";
		if( (isset($oferta->vlrTO) && $oferta->vlrTO > 0 ) || (isset($nuevaOferta->to) && $nuevaOferta->to >0 ) ){

			if( (isset($oferta->vlrTO) && $oferta->vlrTO > 0 ) ){
				$toPlanNuevo = $this->getPlanOferta( $oferta->idOferta, "TO");
				$pqtPlanNuevo = $oferta->nomOferta;
				$totalOferta = ($oferta->vlrProds + $totalAdicionales["recurrentes"]);
			}else{
				$toPlanNuevo =  $nuevaOferta->to;
				$pqtPlanNuevo = $nuevaOferta->toData->nomplan;
				$totalOferta =  $totalPlan;
			}
	
			// Trae produccto actual
			$tipoProd = "1";
			if(!isset($info->TO)){
				$toProducto = "-1";
			}
			else{
				$toProducto = $info->TO;
			}
			
			//
			if(isset($info->producto) && $info->producto > 0 ){
				$pqtProducto = $info->producto;
				$pqtPlanAct = "etp.getplanproducto2({$info->producto})";
				$pqtTramite = "''EXISTENTE''";
			}
			else{
				$pqtProducto = "null";
				$pqtTramite = "''NUEVO''"; 
				$pqtPlanAct = "null";
			}
			
			if(isset($info->TO) && $info->TO > 0 ){
				$toTramite = "''EXISTENTE''";
				$toPlanAct = "etp.getcodplanproducto({$info->TO})";
				$toTecnologia = "etp.get_tipotecnologia_tel({$info->TO})";
			}
			else{
				$toTramite = "''NUEVO''";
				$toPlanAct = "null";
				$toTecnologia = "null";
			}
			
			$otrosAdi = $this->getOtrosAdi("TO");
			$str = "insert into etp.carr_detsolicitud(consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                   to_nro_serv, pqt_producto, pqt_tramite,to_tramite, to_plan_actual,to_plan_nuevo,
                                                   to_tecnologia, pqt_valor, pqt_plan_actual, pqt_plan_nuevo, to_cant_ext,to_serv_suplement
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               $tipoProd . ", " .
                                               $toProducto . ", etp.getnroservicioprod(" . $toProducto . "), " .
                                               $pqtProducto . ", " .
                                               $pqtTramite . ", " .
                                               $toTramite  . ", " .
                                               $toPlanAct  . ", " .
                                               $toPlanNuevo . ", " .
                                               $toTecnologia . ", " . 
                                               $totalOferta . ", " .
											   $pqtPlanAct . ", " .
											   "''{$pqtPlanNuevo}''" . ", " .
                                               $this->getCantAdi("19996", "N") . "," . //Cantidad de extensiones
											    "''{$otrosAdi}''" . "" . //Otros adicionales
                                               ")";
		
		}														   
		return $str;
	}
	
	/*
	* Crea el insert de la tv de la oferta
	*/
	function getInsertDetSolTV(){
		//Inserta TV
		$info   = $this->getDatosClienteActual();
		$oferta = Session::getVar("ofertaSeleccionada");
		$nuevaOferta = Session::getVar("nuevaOferta" );
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$totalPlan 			= $this->getTotalesOferta();
		$totalAdicionales =   $this->getTotalesServiciosAdicionales();
		$totales 			= $this->calcularTotalesVenta($totalPlan, $totalAdicionales);
		//
		$str ="";
		if( (isset($oferta->vlrTV) && $oferta->vlrTV > 0)  || (isset($nuevaOferta->tv) && $nuevaOferta->tv >0 ) ){

			if( (isset($oferta->vlrTV) && $oferta->vlrTV > 0 ) ){
				$tvPlanNuevo = $this->getPlanOferta( $oferta->idOferta, "TV");
				$pqtPlanNuevo = $oferta->nomOferta;
				$totalOferta = ($oferta->vlrProds + $totalAdicionales["recurrentes"]);
			}else{
				$tvPlanNuevo =  $nuevaOferta->tv;
				$pqtPlanNuevo = $nuevaOferta->tvData->nomplan;
				$totalOferta =  $totalPlan;
			}

			$tipoProd = "6042";
			
			
			if(!isset($info->TV) || $info->TV == "" ){
				$tvProducto = "-1";
			}
			else{
				$tvProducto = $info->TV;
			}
			
			if(isset($info->producto) && $info->producto > 0 ){
				$pqtProducto = $info->producto;
				$pqtPlanAct = "etp.getplanproducto2({$info->producto})";
				$pqtTramite = "''EXISTENTE''";
			}
			else{
				$pqtProducto = "null";
				$pqtTramite = "''NUEVO''"; 
				$pqtPlanAct = "null";
			}
			
			if(isset($info->TV) && $info->TV > 0 ){
				$tvTramite = "''EXISTENTE''";
				$tvPlanAct = "etp.getcodplanproducto({$info->TV})";
				$tvNroServ = "etp.getnroservicioprod({$info->TV})";
				$tvTecnologia = "etp.get_tecnologia_tv({$info->TV})";
			}
			else{
				$tvTramite = "''NUEVO''";
				$tvPlanAct = "null";
				$tvTecnologia = "null";
				$tvNroServ = "null";
			}
			
			// Obtiene canales nuevos
			$canalesAct = "null";
			$canalesNvos = $this->getCanalesNuevos();
			$setUpBox = $this->getEquipoTv();
			
			if($setUpBox == 0){
				$setUpBox = "null";
			}
			else{
				$setUpBox = "''$setUpBox HFC Set-top Box''";
			}
			
			// Crea insert 
			$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,tv_producto,
                                                   tv_nro_serv, pqt_producto, pqt_tramite,tv_tramite, tv_plan_actual,tv_plan_nuevo,
                                                   tv_tecnologia, pqt_valor, pqt_plan_actual, pqt_plan_nuevo, tv_canales,canales_nvos,tv_cant_ext,
												   tv_cant_ext_con_cobr, equipos_hfc_dig
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               $tipoProd . ", " .
                                               $tvProducto . ", etp.getnroservicioprod(" . $tvProducto . "), " .
                                               $pqtProducto . ", " .
                                               $pqtTramite . ", " .
                                               $tvTramite  . ", " .
                                               $tvPlanAct  . ", " .
                                               $tvPlanNuevo . ", " .
                                               $tvTecnologia . ", " . 
                                               $totalOferta . ", " .
											   $pqtPlanAct . ", " .
											   "''{$pqtPlanNuevo}''" . ", " .
											   $canalesAct . "," .
											   "''$canalesNvos''" . "," .
                                               $this->getCantAdi("19988", "N") . "," . //Cantidad de extensiones
											   $this->getCantAdiCobrar("19988") . "," . //Cantidad de extensiones con cobro
											   $setUpBox .
                                               ")";
											   
		}														   
		return $str;
	}
	
	/*
	* Crea el insert de la BA de la oferta
	*/
	function getInsertDetSolBA(){
		//Inserta BA
		$info   = $this->getDatosClienteActual();
		$oferta = Session::getVar("ofertaSeleccionada");
		$nuevaOferta = Session::getVar("nuevaOferta" );
		$adicionales = Session::getVar("venta_servicios_adicionales");
		$totalPlan 			= $this->getTotalesOferta();
		$totalAdicionales =   $this->getTotalesServiciosAdicionales();
		$totales 			= $this->calcularTotalesVenta($totalPlan, $totalAdicionales);
		//
	
		$str ="";
		if( (isset($oferta->vlrBA) && $oferta->vlrBA > 0 ) ||  (isset($nuevaOferta->ba) && $nuevaOferta->ba >0 ) ){

			if( (isset($oferta->vlrTV) && $oferta->vlrTV > 0 ) ){
				$baPlanNuevo = $this->getPlanOferta( $oferta->idOferta, "BA");
				$baVelNueva =  $this->getClaseOferta( $oferta->idOferta, "BA");
				$pqtPlanNuevo = $oferta->nomOferta;
				$totalOferta = ($oferta->vlrProds + $totalAdicionales["recurrentes"]);
			}else{
				$baPlanNuevo =  $nuevaOferta->ba;
				$baVelNueva  =  $nuevaOferta->baData->claseserv; 
				$pqtPlanNuevo = $nuevaOferta->baData->nomplan;
				$totalOferta =  $totalPlan;
			}
			
			$tipoProd = "24";
			
			
			
			if(!isset($info->BA)){
				$baProducto = "-1";
			}
			else{
				$baProducto = $info->BA;
			}
			
			if(isset($info->producto) && $info->producto > 0 ){
				$pqtProducto = $info->producto;
				$pqtPlanAct = "etp.getplanproducto2({$info->producto})";
				$pqtTramite = "''EXISTENTE''";
			}
			else{
				$pqtProducto = "null";
				$pqtTramite = "''NUEVO''"; 
				$pqtPlanAct = "null";
			}
			
			if(isset($info->BA) && $info->BA > 0 ){
				$baTramite = "''EXISTENTE''";
				$baPlanAct = "etp.getcodplanproducto({$info->BA})";
				$baNroServ = "etp.getnroservicioprod({$info->BA})";
				$baTecnologia = "etp.get_tecnologia_ba({$info->BA})";
				$baVelActual = "etp.get_classserv_velocidad_ba({$info->BA})";
			}
			else{
				$baTramite = "''NUEVO''";
				$baPlanAct = "null";
				$baTecnologia = "null";
				$baNroServ = "null";
				$baVelActual = "null";
			}
			
			$equipoBa = $this->getEquipoBa();
			$ipFija = $this->getIncluyeAdi(3);
			$segundoAcceso = $this->getIncluyeAdi(19987);
			
			// Crea insert 
			$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,ba_producto,
                                                   ba_nro_serv, pqt_producto, pqt_tramite,ba_tramite, ba_plan_actual,ba_plan_nuevo,
												   ba_vel_actual, ba_vel_nueva,
                                                   ba_tecnologia, pqt_valor, pqt_plan_actual, pqt_plan_nuevo, ba_equipo, ipfija, segundo_acceso,
												   consubsidio
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               $tipoProd . ", " .
                                               $baProducto . ", etp.getnroservicioprod(" . $baProducto . "), " .
                                               $pqtProducto . ", " .
                                               $pqtTramite . ", " .
                                               $baTramite  . ", " .
                                               $baPlanAct  . ", " .
                                               $baPlanNuevo . ", " .
											   $baVelActual . ", " .
											   $baVelNueva . ", " .
                                               $baTecnologia . ", " . 
                                               $totalOferta . ", " .
											   $pqtPlanAct . ", " .
											   "''{$pqtPlanNuevo}''" . ", " .
											   "''{$equipoBa}''" . "," .
											   "''$ipFija''" . "," .
											   "''$segundoAcceso''" . "," .
                                               "''N''" . // Subsidio
                                               ")";
											   
		}														   
		return $str;
	}
	
	/**
	* Guarda las lineas adicionales de la oferta tanto actuales como nuevas
	*
	*/
	function getInsertLinAdic(){

		// Guarda lineas adicionales actuales
	    $contAdic = $this->getCantAdi(19997, "A");
		$data = "";
		
		if($contAdic > 0 ){
			$producto   = $this->getProductoAct("TO");
			$toPlanAct  = $this->getPlanAct("TO");
			$toPlanNvo  = $this->getPlanNuevo("TO");

			$lineas     = WebServices::getLinAdicAct($producto, 0);
			
			$lineas  = explode(";", $lineas);  	
			if( count($lineas) > 0){
				foreach($lineas as $linea){
					$campos  = explode("," , $linea);
					$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                  to_nro_serv,
											      to_tramite,
											      to_plan_actual,
											      to_plan_nuevo,
											      to_tecnologia
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               1               . ", " .
                                               $campos[0]      . ", " .
                                               $campos[1]      . ", " .
                                               "''EXISTENTE''" . ", " .
                                               $toPlanAct      . ", " .
											   $toPlanNvo      . ", " .
											  "''ALAMBRICA''" .
                                               ")" . "<t>";
					$data = $data . $str;
				}
			}
		}

		// Guarda lineas adicionales nuevas
	    $contAdic = $this->getCantAdi(19997, "N");
	    
	    if($contAdic > 0 ){
	    	$toPlanNvo  = $this->getPlanNuevo("TO");
	    	for($i=1; $i <= $contAdic; $i++){
	    		$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                  to_nro_serv,
											      to_tramite,
											      to_plan_actual,
											      to_plan_nuevo,
											      to_tecnologia
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               1               . ", " .
                                               "''-1''"        . ", " .
                                               "''-1''"        . ", " .
                                               "''NUEVO''"     . ", " .
                                               "null"          . ", " .
											   $toPlanNvo      . ", " .
											  "''ALAMBRICA''"  . 
                                               ")" . "<t>";
				$data = $data . $str;
				echo $str;
	    	}
	    }
		return $data;
	}

	/**
	* Guarda las lineas softphone de la oferta tanto actuales como nuevas
	*
	*/
	function getInsertSoftphonePc(){

		// Guarda lineas adicionales actuales
	    $contAdic = $this->getCantAdi(19999, "A");
		$data = "";
		
		if($contAdic > 0 ){
			$producto   = $this->getProductoAct("TO");
			$toPlanAct  = $this->getPlanAct("TO");
			$toPlanNvo  = $this->getPlanNuevo("TO");

			$lineas     = WebServices::getLinAdicAct($producto, 1);
			
			$lineas  = explode(";", $lineas);  	
			if( count($lineas) > 0){
				foreach($lineas as $linea){
					$campos  = explode("," , $linea);
					$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                  to_nro_serv,
											      to_tramite,
											      to_plan_actual,
											      to_plan_nuevo,
											      to_tecnologia
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               1               . ", " .
                                               $campos[0]      . ", " .
                                               $campos[1]      . ", " .
                                               "''EXISTENTE''" . ", " .
                                               $toPlanAct      . ", " .
											   $toPlanNvo      . ", " .
											  "''SOFTPHONE PC''" .
                                               ")" . "<t>";
					$data = $data . $str;
				}
			}
		}

		// Guarda lineas adicionales nuevas
	    $contAdic = $this->getCantAdi(19999, "N");
	    
	    if($contAdic > 0 ){
	    	$toPlanNvo  = $this->getPlanNuevo("TO");
	    	for($i=1; $i <= $contAdic; $i++){
	    		$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                  to_nro_serv,
											      to_tramite,
											      to_plan_actual,
											      to_plan_nuevo,
											      to_tecnologia
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               1               . ", " .
                                               "''-1''"        . ", " .
                                               "''-1''"        . ", " .
                                               "''NUEVO''"     . ", " .
                                               "null"          . ", " .
											   $toPlanNvo      . ", " .
											  "''SOFTPHONE PC''"  . 
                                               ")" . "<t>";
				$data = $data . $str;
				echo $str;
	    	}
	    }
		return $data;
	}


	/**
	* Guarda las lineas softphone de la oferta tanto actuales como nuevas
	*
	*/
	function getInsertSoftphoneMovil(){

		// Guarda lineas adicionales actuales
	    $contAdic = $this->getCantAdi(19998, "A");
		$data = "";
		
		if($contAdic > 0 ){
			$producto   = $this->getProductoAct("TO");
			$toPlanAct  = $this->getPlanAct("TO");
			$toPlanNvo  = $this->getPlanNuevo("TO");
			
			$lineas     = WebServices::getLinAdicAct($producto, 2);
			
			$lineas  = explode(";", $lineas);  	
			if( count($lineas) > 0){
				foreach($lineas as $linea){
					$campos  = explode("," , $linea);
					$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                  to_nro_serv,
											      to_tramite,
											      to_plan_actual,
											      to_plan_nuevo,
											      to_tecnologia
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               1               . ", " .
                                               $campos[0]      . ", " .
                                               $campos[1]      . ", " .
                                               "''EXISTENTE''" . ", " .
                                               $toPlanAct      . ", " .
											   $toPlanNvo      . ", " .
											  "''SOFTPHONE MOVIL''" . 
                                               ")" . "<t>";
					$data = $data . $str;
				}
			}
		}

		// Guarda lineas adicionales nuevas
	    $contAdic = $this->getCantAdi(19998, "N");
	    
	    if($contAdic > 0 ){
	    	$toPlanNvo  = $this->getPlanNuevo("TO");
	    	for($i=1; $i <= $contAdic; $i++){
	    		$str = "insert into etp.carr_detsolicitud (consecutivo_detsol, consecutivo_sol, tipo_producto,to_producto,
                                                  to_nro_serv,
											      to_tramite,
											      to_plan_actual,
											      to_plan_nuevo,
											      to_tecnologia
                                   )
                                   values (etp.etp_seq_carr_detsolicitud.nextval, TAG_SOLICITUD, "  .
                                               1               . ", " .
                                               "''-1''"              . ", " .
                                               "''-1''"              . ", " .
                                               "''NUEVO''"     . ", " .
                                               "null"          . ", " .
											   $toPlanNvo      . ", " .
											  "''SOFTPHONE MOVIL''"  .
                                               ")" . "<t>";
				$data = $data . $str;
				echo $str;
	    	}
	    }
		return $data;
	}
	
	function getProductoAct($tipo){
		$info = Session::getVar("infoCliente");
		$info = $info[0];
		if($tipo == "TO"){
			if( isset($info->TO)  && $info->TO != ""){
				return $info->TO;
			}
		}
		else if($tipo == "TV"){
			if( isset($info->TV)  && $info->TV != ""){
				return $info->TV;
			}
		}
		else if($tipo == "BA"){
			if( isset($info->BA)  && $info->BA != ""){
				return $info->BA;
			}
		}
		return "";
	}
	
	function getCanalesNuevos(){
		$canales = "";
		$adicionales = Session::getVar("venta_servicios_adicionales");
		foreach($adicionales as $adicional){
			$servAdi = $this->getServicioAdicionalPorCodigo($adicional->codigo);
			if($servAdi->escanal == "S"){
				$canales = $canales . $adicional->descripcion . ",";
			}
		}
		return substr($canales, 0, strlen($canales) -1 );
	}
	
	function getEquipoTv(){
		$cant = 0;
		$adicionales = Session::getVar("venta_servicios_adicionales");
		foreach($adicionales as $adicional){
			$servAdi = $this->getServicioAdicionalPorCodigo($adicional->codigo);
			if( ($adicional->codigo == 9341 || $adicional->codigo == 9200) && ( $adicional->grupo == "O" || $adicional->grupo == "N" ) ){
				$temp = isset( $adicional->cantidad ) ? $adicional->cantidad : "1";
				$cant = $cant + $temp;
			}
		}
		return $cant;
		 //9341 = SetupBox con USB, 9200 = SetupBox sin USB
		//DataRow[] reg = dsDatos.Tables[kTblServAdiTv].Select("codigo in (9341, 9200) and adicionar = 'S'");
		//if (reg.Length == 0)
		///	return "0";
		//return reg[0]["cantnva"].ToString();
		
	}
	
	function getEquipoBa(){
		$cant = 0;
		$adicionales = Session::getVar("venta_servicios_adicionales");
		foreach($adicionales as $adicional){
			$servAdi = $this->getServicioAdicionalPorCodigo($adicional->codigo);
			if( ($adicional->codigo == 20000 ) && ( $adicional->grupo == "O" || $adicional->grupo == "N" ) ){
				return "ALAMBRICO";
			}
			
			if( ($adicional->codigo == 20001 ) && ( $adicional->grupo == "O" || $adicional->grupo == "N" ) ){
				return "WIFI";
			}
		}
		return "null";
	}
	
	function getIncluyeAdi($codigo){
		$adicionales = Session::getVar("venta_servicios_adicionales");
		foreach($adicionales as $adicional){
			$servAdi = $this->getServicioAdicionalPorCodigo($adicional->codigo);
			if( ($adicional->codigo == $codigo ) && ( $adicional->grupo == "O" || $adicional->grupo == "N" ) ){
				return "S";
			}
		}
		return "N";
	}
	
	function getDatosAgenda($post, $dirInstalacion){
		//IDATA6 := '66001<t>13/12/2014<t>AM<t>CDUQUE<t>42161149<t>CLAUDIA ELENA DUQUE CEBALLOS<t>CRA 16 25-11<t>1314175<item>';
		//print_r($post);
		$user = JFactory::getUser();
		$data = WebServices::consultarDireccionPorId($dirInstalacion);
		$data = explode("<tag>", $data);

		// Formato celulares
		//$post["fecha"] = "17/12/2014";
		
		$str = $data[5] . "<t>" . $this->getFechaFormato($post["fecha"]) . "<t>" . $post["jornada"] . "<t>" . $user->username . "<t>" . $post["cedula"] . "<t>";
		$str = $str . $post["nombres"] . " " . $post["apellidos"] . "<t>" . $data[1] . "<t>" . $data[0] . "<t><item>";
		return $str;
	}
	
	function actualizarVenta($idVenta, $msg, $estado ){
		$row =& JTable::getInstance('Ventas', 'Table');
		$row->id = $idVenta;
		$row->estado = $estado;
		$row->msg = $msg;
		
		if($row->store()){
			return true;
		}
		else{
			return false;
		}
		
	}
	
	/**Retorna la fecha con el formato adecuado
	 * @param fecha en formato mm/dd/yyyy
	 * 
	*/
	function getFechaFormato($fecha){
	
		$fecha = explode("/", $fecha);
		$fecha = $fecha[0] . "/" . $fecha[1] . "/" . $fecha[2];
		return $fecha;
	}
	
	/*Funcion de utilidad para comparar dos cadenas, se usa para comparar las cadenas enviadas a OSF
	  solo con fines de pruebas
	 */
	function compararCadenas($str1, $str2){
		$str1 = explode("<t>",$str1);
		$str2 = explode("<t>",$str2);
		
		$index = 0;
		foreach($str1 as $data){
			echo $data . " - " . $str2[$index] . "<br/>";
			$index = $index  + 1;
		}
	}
	
	/*Retorna los datos de una subcategoria  
	 @param categoria la categoria
	 @param subcategoria
	*/
	function getSubCategoria($categoria, $subcategoria){
		$db = JFactory::getDBO();
		//$tbCategorias    = $db->nameQuote('#__zcategorias');	
		$tbSubCategorias = $db->nameQuote('#__zsubcategorias');	
		
		$query = "SELECT 
						s.*
				  FROM 
						$tbSubCategorias as s
				  WHERE 
						s.sucacate = '%s'  AND
						s.sucacodi = %s 
						";			
		$query = sprintf( $query, trim($categoria), trim($subcategoria) );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result[0];
	}

    /**
    * Obtiene la subcategoria actual de la venta
    * @return Objetct subCategoria Actual 
    */
	function getSubCategoriaActual(){
		$data           = $this->getDatosClienteActual();
		if($data->producto != "-1"){
			$categoria      = $data->categoria;
			$subCategoria   = $data->subcategoria;
			$idCategoria    = $categoria[0];
			$idSubCategoria = $subCategoria[0];
			$id = $this->getSubCategoria($idCategoria, $idSubCategoria);
		}
		else{
			$idCategoria = 2;
			$idSubCategoria = $data->estrato;
			$id = $this->getSubCategoria($idCategoria, $idSubCategoria);
		}
		return $id;
	}
	
	/**
    * Obtiene la subcategoria actual de la venta en formato de texto para mostrar al usuario
    * @return Objetct subCategoria Actual 
    */
	function getSubCategoriaActualTexto(){
		$data           = $this->getDatosClienteActual();
		if($data->producto != "-1"){
			$categoria      = $data->categoria;
			$subCategoria   = $data->subcategoria;
			$idCategoria    = $categoria[0];
			$idSubCategoria = $subCategoria[0];
			$id = $this->getSubCategoria($idCategoria, $idSubCategoria);
			$text = "($idCategoria-$idSubCategoria) $categoria $subCategoria";
		}
		else{
			$idCategoria = 2;
			$idSubCategoria = $data->estrato;
			$id = $this->getSubCategoria($idCategoria, $idSubCategoria);
			$text = "($idCategoria-$idSubCategoria) RESIDENCIAL - {$id->sucadesc}";
		}
		
		return $text;
	}
	
	/*Retorna los datos de una subcategoria  
	 @param categoria la categoria
	 @param subcategoria
	*/
	function getTiposSolicitud(){
		$db = JFactory::getDBO();
		//$tbCategorias    = $db->nameQuote('#__zcategorias');	
		$tbTipos = $db->nameQuote('#__ztipos_solicitudes');	
		
		$query = "SELECT 
						s.*
				  FROM 
						$tbTipos as s						
						";
						
		$query = sprintf( $query );
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	/**Retorna los datos del cliente actual y del producto seleccionado para la venta*/
	function getDatosClienteActual(){
		$producto = Session::getVar("productoActual");
		$data = Session::getVar('infoCliente');
		if(is_array($data)){
			foreach($data as $item){
				if(isset($item->producto) && $item->producto == $producto ){
					return $item;
				}
			}
		}
		return "";
	}

	function crearProductoVacio(){
		Session::setVar("productoActual", "-1");
		$data = new stdClass();
		$data->producto = "-1";
		$arrData[] = $data;
		Session::setVar('infoCliente', $arrData);
	}

	/**Actualiza los datos del cliente actual en el producto actual*/
	function setDatosClienteActual($newItem){
		$producto = Session::getVar("productoActual");
		$data = Session::getVar('infoCliente');
		if(is_array($data)){
			foreach($data as &$item){
				if(isset($item->producto) && $item->producto == $producto ){
					$item = $newItem;
				}
			}
		}
	}


	function getPlanAct($tipo){
		$data = $this->getDatosClienteActual();
		if($tipo == "TO" && isset($data->TO) ){
			$planActual = "etp.pk_amc.getPlanCial({$data->TO})";	
		}
		else if($tipo == "TV" && isset($data->TV)){
			$planActual = "etp.pk_amc.getPlanCial({$data->TV})";		
		}
		else if($tipo == "BA" && isset($data->BA)){
			$planActual = "etp.pk_amc.getPlanCial({$data->BA})";			
		}
		else{
			$planActual = "";
		}
		return $planActual;
	}


	function getPlanNuevo($tipo){
		$oferta = Session::getVar("ofertaSeleccionada");

		// Seleccionaron la mejor oferta
		if( isset($oferta->idOferta) && $oferta->idOferta > 0){
			$plan = $this->getPlanOferta( $oferta->idOferta, $tipo ); 
		} 
		else{
			// Eligieron una oferta customizada
			$nuevaOferta = Session::getVar("nuevaOferta");
			if($tipo == "TO"){
				$plan = $nuevaOferta->to;
			}
			else if($tipo == "TV`"){
				$plan = $nuevaOferta->tv;
			}
			else if($tipo == "BA"){
				$plan =  $nuevaOferta->ba;
			}
		}
		
		return $plan;
	}
	
	function buscarMotivo($motivo){
	
		$dataMotivo = WebServices::consultarDatosMotivo($motivo);
		
		return $dataMotivo;
	}
	
	function consultarProdRetenFinan($producto){
	
		$dataPr = WebServices::consultarProdRetenFinan($producto);
		
		return $dataPr;
	}
	
	function consultarProdFeIn($producto){
	
		$dataPr = WebServices::getProdFeIn($producto);
		
		return $dataPr;
	}
	
	function consultarCobertura($idDireccion){
	
		$dataDir = WebServices::consultarCobertura($idDireccion);
		
		return $dataDir;
	}
}