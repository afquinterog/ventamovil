<?php 

/**
Usage:
show($icon, $number, $desc, $link, $viewMore, $span)

$icon: all available in font-awesome.css (templates/chronos/plugins/font-awesome)
Ej: glass, music, user, search, tablet

$span: the span on the row -> the row is divided in 12 equals parts

GraphicButtonHelper::show("tablet", "15", "Nuevos pedidos", "index.php", "Ver m&aacute;s", 3);
*/
class PortletHelper{
	
	static function show($title, $icon='globe', $color="light-grey"){
	
		echo "<div class='portlet box $color'>
				<div class='portlet-title'>
					<h4><i class='icon-$icon'></i>$title</h4>
					<div class='tools'>
						<a href='javascript:;' class='collapse'></a>
						<a href='#portlet-config' data-toggle='modal' class='config'></a>
						<a href='javascript:;' class='reload'></a>
						<a href='javascript:;' class='remove'></a>
					</div>
				</div>
				<div class='portlet-body'>
					
					
				
				";		
	}
	
	static function end(){
		echo "

				</div>
			</div>
		";
	}
}








