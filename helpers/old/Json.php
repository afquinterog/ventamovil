<?php 

/**
Usage:


*/
class Json{

	/*
	* Obtiene un dato especifico de un conjunto de datos JSON
	*/
	public static function set($data, $property, $value){
	
		$params = json_decode($data);
		$params->{$property} = $value;
		$params = json_encode($params);
		return $params;
	}
	
	public static function get($data, $property){
		$params = json_decode($data);
		if(isset($params->{$property})){
			return $params->{$property};
		}
		return "";
		
	}
	

	
	
}








