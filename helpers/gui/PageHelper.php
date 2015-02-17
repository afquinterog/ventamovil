<?php 

/**
Usage:

*/
class PageHelper{
	
	/**
	* Initialize the page
	*/
	static function initPage($title, $showMenu=true){
		
		
		echo "<div class='all-elements'>";
		
		$showMenu ? PageHelper::menu() : "";
		
		echo "
			
					<div id='content' class='page-content'>
						<div class='page-header'>
							<a href='#' class='deploy-sidebar'></a>
							<p class='bread-crumb'>$title</p>
						</div>
						<div class='content-header'>
							<a href='index.php' class='content-logo'></a>
						</div>
						
						<div class='content'>
				";		
	}

	
	/**
	* End page
	*/
	static function endPage(){
		echo "
				<div class='content-footer'>
					<p class='copyright-content'>Copyright 2014.<br> Une Telef&oacute;nica de Pereira</p>
					<a href='#' class='go-up-footer'></a>
					<!--<a href='#' class='facebook-footer'></a>-->
					<!--<a href='#' class='twitter-footer'></a> -->
					<div class='clear'></div>
				</div>
			</div></div></div>
			 ";
	}
	
	static function menu(){
		?>
		
			<div id="sidebar" class="page-sidebar">
				<div class="page-sidebar-scroll">
					<div class="sidebar-section">
						<p>Opciones</p>
						<a href="#" class="sidebar-close"></a>
					</div>
					<div class="sidebar-header">
						<!-- <a href="index.html" class="sidebar-logo"></a>-->
					</div>
					
					<div class="navigation-items">
						<div class="nav-item">
							<a href="index.php" class="home-nav">Inicio<em class="selected-nav"></em></a> 
						</div> 
						<div class="nav-item">
							<!-- <a href="#" class="contact-nav submenu-deploy">Nueva Venta<em class="dropdown-nav"></em></a>-->
							<a href="#" class="contact-nav">Nueva Venta<em class="dropdown-nav"></em></a>
							<!--<div class="nav-item-submenu">
								<a href="index.php?option=com_ztadmin">1. Buscar cliente	 <em class="unselected-sub-nav"></em></a>
							</div> -->
						</div> 
						<div class="nav-item">
							<a href="index.php?option=com_ztadmin&task=usVisitaList" class="media-nav">Visitas<em class="dropdown-nav"></em></a>
							<!--<div class="nav-item-submenu">
								<a href="index.php?option=com_ztadmin">Competencia<em class="unselected-sub-nav"></em></a>
							</div>-->
						</div>

						<div class="nav-item">
							<a href="index.php?option=com_ztadmin&task=usTareaList" class="media-nav">Tareas<em class="dropdown-nav"></em></a>
							<!--<div class="nav-item-submenu">
								<a href="index.php?option=com_ztadmin&task=usTareaList">Listado<em class="unselected-sub-nav"></em></a>
							</div> -->
						</div> 			

						<div class="nav-item">
							<a href="index.php?option=com_ztadmin&task=usVentasList" class="media-nav">Ventas<em class="dropdown-nav"></em></a>
							<!--<div class="nav-item-submenu">
								<a href="index.php?option=com_ztadmin&task=usTareaList">Listado<em class="unselected-sub-nav"></em></a>
							</div> -->
						</div> 											
						
						<!--<div class="nav-item">
							<a href="index.php?option=com_ztadmin" class="contact-nav">Mis pedidos<em class="unselected-nav"></em></a>
						</div>-->						
						
						<div class="sidebar-decoration"></div>
					</div>
					
					<div class="sidebar-section">
						<p>Configuraci&oacute;n</p>
						<a href="#" class="sidebar-updates"></a>
					</div>
					<div class="sidebar-notifications">
						<div class="sidebar-green">
							<h3><a href="index.php?option=com_ztadmin&task=userLogout">Cerrar sesi&oacute;n</a></h3>
							<p>Cierra la sesi&oacute;n actual</p>
						</div>
						<div class="sidebar-decoration"></div>
						
					</div>

					<div class="sidebar-section copyright-sidebar">
						<p>Copyright 2014. Une Telef&oacute;nica de Pereira.</p>
					</div>                  
				</div>
			</div>
		
		
		<?php
		
	}

	
	static function mensajeOk($msg){
		echo "<div class='big-notification green-notification'>
				<h4 class='uppercase'>Mensaje</h4>
				<a class='close-big-notification' href='#'>x</a>
				<p>$msg</p>
			  </div>";
	}
	
	static function mensajeNOK($msg){
		echo "<div class='big-notification red-notification'>
				<h4 class='uppercase'>Error</h4>
				<a class='close-big-notification' href='#'>x</a>
				<p>$msg</p>
			  </div>";
	}
	
	static function showMessage(){
		$msg   = Session::getVar("msg");
		$error = Session::getVar("error");
		if( $error == false && $msg!=""){
			PageHelper::mensajeOk($msg);
		}elseif( $msg!="" ){
			PageHelper::mensajeNOk($msg);
		}
		Session::setVar("msg", "");
		Session::setVar("error", "");
	}
	

	
}








