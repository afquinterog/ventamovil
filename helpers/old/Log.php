<?php 

/**
Usage:


*/
class Log{

	/*
	* Registra una entrada en el log
	*/
	function registrar($accion, $anterior, $nuevo, $valor){
	
		JTable::addIncludePath(JPATH_SITE .DS. 'components'.DS. 'com_zcorreos'.DS.'tables');
		
		date_default_timezone_set('America/Bogota');
		$fechaHoy = date('Y-m-d H:i:s');

		$user = JFactory::getUser();
		$userId = isset($user->id) ? $user->id : "";
		
		$log =& JTable::getInstance('Log', 'Table');
		$log->accion = $accion;
		$log->fecha = $fechaHoy;
		$log->usuario = $userId;
		$log->valor = $valor;
		$log->ip = Util::getIp();
		$log->store();
	}
	
	

	
	
}








