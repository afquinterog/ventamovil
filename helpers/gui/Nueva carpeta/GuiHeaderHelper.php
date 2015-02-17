<?php 

/**
Usage:

Configuration::setValue('CANTIDAD_MENSAJES', '30');
$cantidad = Configuration::getValue('CANTIDAD_MENSAJES');

*/
class GuiHeaderHelper{
	
	static function logo(){
		echo "
				<a class='brand' href='index.php'><b>App Montejo V 1.0</b>
				<img src='templates/chronos/img/logo2.png' alt='' />
				</a>
				";
				
	}
	
	static function menuToggler(){
		echo "<a href='javascript:;' class='btn-navbar collapsed' data-toggle='collapse' data-target='.nav-collapse'>
				<img src='templates/chronos/img/menu-toggler.png' alt='' />
				</a> ";
	}
	
	
	function showSearchForm(){
		echo "<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class='sidebar-search'>
						<div class='input-box'>
							<a href='javascript:;' class='remove'></a>
							<input type='text' placeholder='Buscar...' />				
							<input type='button' class='submit' value=' ' />
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>";
	}
	
	
	static function topNavegationMenu(){
		echo "<ul class='nav pull-right'>";
	}
	
	static function endTopNavegationMenu(){
		echo "</ul>";
	}
	
	
	
	
	
}








