<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

//Get the user type
$user = JFactory::getUser();
$menu = Menu::getMenu($user->tipo);
//BasicPageHelper::iniPage( $user->username, $menu);
?>

<?php 
	PageHelper::initPage("Sistema Venta M&oacute;vil Une");
?>
	
	<div class="decoration"></div>
			
	<div class="container no-bottom">
		<div class="section-title">
			<h4 style='color:red'>Nueva Venta</h4>
			<h4></h4>
			<em>Registrar nueva venta</em>
			<strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
		</div>
	</div>
	
	<div class="container">
		<p class="center-text">
			<!--<input type="date" id="fecha" name="fecha" value="" class="contactField requiredField"/> -->
			<a class="button-big button-red" href="index.php?option=com_ztadmin&task=usTipoBusquedaForm">Iniciar nueva venta</a>
        </p>
		
	</div>
	
	<div class="decoration"></div>
			
	<div class="container no-bottom">
		<div class="section-title">
			<h4 style='color:red'>Notificaciones</h4>
			<h4></h4>
			<em>Notificaciones del sistema</em>
			<strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
		</div>
	</div>
	
	<div class="container no-bottom">
		<div class="one-half-responsive">
			<div class="big-notification blue-notification">
				<h4 class="uppercase">
					<a style='color:white' href='index.php?option=com_ztadmin&task=usVisitaList'>Visitas pendientes</a>
				</h4>
				<a href="#" class="close-big-notification">x</a>
					<p>
					Tiene <?php echo $this->visitasvencidas; ?> Visitas vencidas
					
				</p>
				<p>
					Tiene <?php echo $this->visitaspendientes; ?> Visitas sin Vencer
				</p>
				<a href='index.php?option=com_ztadmin&task=usVisitaList' style='width:100%;color:white;text-align:center' >
					<p style='width:100%'>Ver todas las visitas</p>
				</a>
		
			</div>
			<!--<div class="big-notification green-notification">
				<h4 class="uppercase">Venta</h4>
				<a href="#" class="close-big-notification">x</a>
				<p>A lot of nice stuff you want to write in this notification! It's simple to use and awesome!</p>
			</div> -->
		</div>
		
		<div class="one-half-responsive last-column">
		<?php
			foreach($this->tareasVencidas as $item){
				//print_r($item);
				$fecha = Util::getDate();
				//echo $fecha;
				//exit;
		?>
			
			<div class="big-notification red-notification">
				<h4 class="uppercase">
					<a style='color:white' href='index.php?option=com_ztadmin&task=usTareaForm&tarea=<?php echo $item->id; ?>'>
						<?php echo $item->resumen; ?>
					</a>
				</h4>
				<a href="#" class="close-big-notification">x</a>
				<p><?php echo $item->descripcion; ?></p>
				<p>Fecha Vencimiento: <?php echo $item->fecha_entrega; ?></p>
				
			</div>
		<?php
			}
		?>
		</div>
		
		<div class="one-half-responsive last-column">
		<?php
			foreach($this->tareasPendientes as $item){
		?>
			
			<div class="big-notification green-notification">
				<h4 class="uppercase">
					<a style='color:white' href='index.php?option=com_ztadmin&task=usTareaForm&tarea=<?php echo $item->id; ?>'><?php echo $item->resumen; ?></a>
				</h4>
				<a href="#" class="close-big-notification">x</a>
				<p><?php echo $item->descripcion; ?></p>
				<p>Fecha Vencimiento: <?php echo $item->fecha_entrega; ?></p>
				
			</div>
		<?php
			}
		?>
		</div>
				
    </div> 

			

	<div class="decoration"></div>
		
<?php PageHelper::endPage();?>




