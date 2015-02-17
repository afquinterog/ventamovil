<?php 

/**
Usage:

*/
class UtilHelper{
	
	static function toOneLine($data){
		$output = str_replace(array("\r\n", "\r"), "\n", $data);
		$lines = explode("\n", $output);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if(!empty($line))
				$new_lines[] = trim($line);
		}
		$data = implode($new_lines);
		return $data;
	}
	
	static function append($item,$data){
		echo "
			<script type='text/javascript'>
				jQuery(document).ready(function() {	
					jQuery('#$item').append(\"$data\");
				}
				);
			</script>";
	}
	
	static function clearList($item){
		echo "
			<script type='text/javascript'>
				jQuery(document).ready(function() {	
					jQuery('#$item').empty();
				}
				);
			</script>";
	}
	
	
	
	
	
}








