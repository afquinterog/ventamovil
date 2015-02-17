<?php 
class Util{

	function getIP()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	
	static function redirect($url){
		$app = JFactory::getApplication();
		$url = JRoute::_( $url );
		$app->redirect($url);
	}
	
	
	function processResult($result){
	
		$result = explode("|", $result);
		if(strpos($result[0], "OK") !== false ){
			$msg = $result[1];
		}
		else{			
			$msg = $result[1];
			$error = true;
		}
		$this->assignRef("msg" , $msg);
		$this->assignRef("error" , $error);
		//Guarda mensaje en sesion de usuario
		Session::setVar("msg", $msg);
		Session::setVar("error", $error);
		
	}
	
	
	static function number_format($number, $decimales=0){
		//$decimales = 0;
		return number_format($number ,$decimales, '.', '');
	}
	
	static function getDate(){
		date_default_timezone_set('America/Bogota');
		$fecha = date('Y-m-d');
		return $fecha;
	}
	
	public static function getDateTime(){
		date_default_timezone_set('America/Bogota');
		$fechaHoy = date('Y-m-d H:i:s');
		return $fechaHoy;
	}
}








