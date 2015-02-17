<?php
	function conectDB(){
		
		$mysqli = new mysqli("localhost","root","giga","ventamovil2");
                                  		 
		if ( $mysqli->connect_errno ) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_errno;
		}
		return $mysqli;
	}
?>
