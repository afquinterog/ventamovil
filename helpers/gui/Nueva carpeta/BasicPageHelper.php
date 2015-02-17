<?php 

/**
Usage:

*/
class BasicPageHelper{
	
	
	/**
	* Load a basic web page
	*/
	static function iniPage($username, $menu ){
			?>
			
			<div class="header navbar navbar-inverse navbar-fixed-top">
				<!-- BEGIN TOP NAVIGATION BAR -->
				<div class="navbar-inner">
					<div class="container-fluid">
						
						<?php echo GuiHeaderHelper::logo(); ?>
						<?php echo GuiHeaderHelper::menuToggler(); ?>
					
						<!-- BEGIN TOP NAVIGATION MENU -->					
						<?php echo GuiHeaderHelper::topNavegationMenu(); ?>
							
							<!-- BEGIN NOTIFICATION DROPDOWN -->	
							<?php //echo GuiNotificationBarHelper::show(); ?>
							<!-- END NOTIFICATION DROPDOWN -->
							
							<!-- BEGIN INBOX DROPDOWN -->
							<?php //echo GuiInboxBarHelper::show(); ?>
							<!-- END INBOX DROPDOWN -->
							
							
							<!-- BEGIN TODO DROPDOWN -->
							<?php //echo GuiTaskBarHelper::show(); ?>
							<!-- END TODO DROPDOWN -->
							
							<!-- Display user dropdown -->
							<?php 
								echo GuiUserDropdownHelper::show($username); 
							?>
							
			
						<?php echo GuiHeaderHelper::endTopNavegationMenu(); ?>
					</div>
				</div>
				<!-- END TOP NAVIGATION BAR -->
			</div>
			<!-- END HEADER -->
			
			
			
			<!-- BEGIN CONTAINER -->
			<div class="page-container row-fluid">
				<!-- BEGIN SIDEBAR -->
				<?php  GuiLeftHelper::initLeftPanel(); ?>
					<?php  GuiLeftHelper::showSearchForm(); ?>	
					<?php echo $menu; ?>	
				<?php  GuiLeftHelper::endLeftPanel(); ?>
				
				<!-- END SIDEBAR -->
		<?php
	}
	
	static function endPage(){
		PageHelper::endPage(); 
		PageHelper::footerPage(); 
		JsHelper::addCoreJs(); 
		JsHelper::addGuiHandler(); 
		JsHelper::addUtils(); 
		?>
		<script type='text/javascript'>
			jQuery(document).ready(function() {		
				App.init(); // initlayout and core plugins

			});
		</script>
		<?php
		
		//Menu de usuario
		//GuiUserDropdownHelper::addItem("","user","Usuarios");
		//GuiUserDropdownHelper::addItem("","calendar","Calendario");
		//GuiUserDropdownHelper::addItem("","envelope","Mensajes");
		//GuiUserDropdownHelper::addItem("","tasks","Puntos");
		//GuiUserDropdownHelper::addSeparator();
		GuiUserDropdownHelper::addItem("index.php?option=com_ztadmin&task=userLogout","key","Salir");
		
		
		
		
	}
	
	
	
	
	
}








