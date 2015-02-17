<?php
/**
 * @version		1.0
 * @package		tusconsultores
 * @subpackage	
 * @copyright	Copyright (C) 2005 - 2014 Tusconsultores.com
 */

defined('_JEXEC') or die;

//Get the user type
$user = JFactory::getUser();

?>
	<?php echo PageHelper::initPage("Sistema Venta M&oacute;vil Une");?>
    
	<div class="container no-bottom">
		<div class="section-title">
			<h4 style='color:red'></h4>
			<h4>Resultado de la operaci&oacute;n</h4>
			<em>Mensaje del sistema</em>
			<strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
		</div>
	</div>
	<div class="decoration"></div>
	
<?php
if( $this->error == false){
	//GuiHelper::redirect($this->msg, $this->error, "index.php?option=com_ztadmin" );
	//GuiHelper::mensajeOk($this->msg);
	PageHelper::mensajeOk($this->msg);
}
else{
	PageHelper::mensajeNOk($this->msg);
}
?>

<div style='min-height:300px'></div>
<?php echo PageHelper::endPage();?>