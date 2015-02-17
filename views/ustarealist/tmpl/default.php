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
			<h4 style='color:red'>Tareas pendientes</h4>
			<em>Listado de tareas</em>
			<strong><img src="templates/chronos/images/misc/icons/applications.png" width="20" alt="img"></strong>
		</div>
	</div>
	
	<div class="decoration"></div>
			
	<div class="container no-bottom">
		
		<div class="one-half-responsive last-column">
		<?php
			foreach($this->tareasVencidas as $item){
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
					<a style='color:white' href='index.php?option=com_ztadmin&task=usTareaForm&tarea=<?php echo $item->id; ?>'>
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
	<div style='min-height:255px'></div>
		
<?php PageHelper::endPage();?>




