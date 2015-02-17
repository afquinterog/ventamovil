<?php 

/**
Usage:

Configuration::setValue('CANTIDAD_MENSAJES', '30');
$cantidad = Configuration::getValue('CANTIDAD_MENSAJES');

*/
class GuiLeftHelper{
	
	static function initLeftPanel(){
		echo "
		<div class='page-sidebar nav-collapse collapse'>
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class='sidebar-toggler hidden-phone'></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				";
				
	}
	
	static function showSearchForm(){
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
	
	static function endLeftPanel(){
		echo "</div>";
	}
	
	
	
	
	
	
	
}








