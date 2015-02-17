<?php 
class GUIHelper{

	
	/**
	 * Crea mensaje superior
	 * 
	 * @param string mensaje
	 * 
	 */
	public static function mensajeSuperior( $msg ){
		ZHelper::initScript();
		echo "document.getElementById('gkBreadcrumb').innerHTML = '<h4><b>$msg</b></h4>'";
		ZHelper::endScript();
		//jQuery('#gkBreadcrumb').html();
	}
	
	public static function mensajeOk($msg){
		//echo "<p class='gkTips1'>{$msg}</p>";
		echo "<div class='alert alert-success'>
				<button data-dismiss='alert' class='close'></button>
				<strong>Operaci&oacute;n exitosa!&nbsp;&nbsp;&nbsp;</strong>{$msg}
			</div>";
	}
	
	public static function mensajeNOk($msg){
		echo "<div class=\"alert alert-error\">
					<button data-dismiss=\"alert\" class=\"close\"></button>
					<strong>Error!&nbsp;&nbsp;&nbsp;</strong>{$msg}
			  </div>";
		
	}
	
	public static function mensaje($msg){
		return "<p class='gktick'>$msg<small></small></p>";
	}
	
	public static function error($msg){
		return "<p class='gkerror'>$msg<small></small></p>";
	}
	
	public static function info($title, $msg){
		return "<p class='gkbulb'>$title<br/><small>$msg</small></p>";
	}
	
	
	public static function redirect($msg, $error, $url ){
		Session::setVar("msg", $msg);
		Session::setVar("error", $error);
		$app  = &JFactory::getApplication();
		$app->redirect($url); //redirect 
	}
	
	public static function mensajeRedirect(){
		$msg = Session::getVar("msg");
		$error = Session::getVar("error");

		if( $msg != ""){
			Session::setVar("msg", "");
			Session::setVar("error", "");
			if(!$error){
				GUIHelper::mensajeOk($msg);
			}
			else{
				GUIHelper::mensajeNOK($msg);
			}
		}
	}
	
	public static function msgVendedor(){
		$user = JFactory::getUser();
		return $user->username ;
	}
	
	
	
	
	
}








