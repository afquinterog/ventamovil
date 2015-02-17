<?php 

class ZDateHelper{

	
	/**
	 * Returnal el intervalo entre la fecha enviada y el dia de hoy
	 * 
	 * @param db the database object
	 * @return true if success false otherwise 
	 */
	public static function distanciaAFechaActual( $fecha ){
	
		$fechaHoy = Configuration::getDate();
		
		$datetime1 = new DateTime( $fechaHoy );
		$datetime2 = new DateTime( $fecha );
		$interval = $datetime1->diff($datetime2);
		$dias = $interval->format('%R%a d');
		$horas = $interval->format('%R%h h');
		
		if(strpos($dias , "+0") !== false){
			$dias = "";
		}
		
		if(strpos($horas , "+0") !== false){
			$horas = "";
		}
		
		return $dias . " " .$horas;
	}
	
	/**
	 * Returnal el intervalo entre la fecha enviada y el dia de hoy
	 * 
	 * @param db the database object
	 * @return true if success false otherwise 
	 */
	public static function distanciaEntreFechas( $fecha1, $fecha2 ){
		
		$datetime1 = new DateTime( $fecha1 );
		$datetime2 = new DateTime( $fecha2 );
		
		$interval = $datetime1->diff($datetime2);
		
		$dias = $interval->format('%R%a d');
		$horas = $interval->format('%R%h h');
		
		if(strpos($dias , "+0") !== false){
			$dias = "";
		}
		
		if(strpos($horas , "+0") !== false){
			$horas = "";
		}
		
		return $dias . " " .$horas;
	}
	

	
}












