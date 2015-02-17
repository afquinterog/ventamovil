<?php 

/**
Usage:

echo Tooltip::classicTip("(Tip)", "El precio debe ser ingresado separando los miles por puntos. Ej: 800.000");
*/

class Tooltip{

	public static function classicTip( $title, $msg){
		return "<a href='#' class='gkTooltip'>
				 $title
				<span class='classicTooltip'>
					$msg
				</span></a>";
	}

	
	
}








