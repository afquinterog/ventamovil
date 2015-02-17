<?php 

/**
Usage:
show($icon, $number, $desc, $link, $viewMore, $span)

$icon: all available in font-awesome.css (templates/chronos/plugins/font-awesome)
Ej: glass, music, user, search, tablet

$span: the span on the row -> the row is divided in 12 equals parts

GraphicButtonHelper::show("tablet", "15", "Nuevos pedidos", "index.php", "Ver m&aacute;s", 3);
*/
class GraphicButtonHelper{
	
	static function show($icon, $number, $desc, $link, $viewMore, $span, $color="blue"){
		echo "<div class='span$span responsive' data-tablet='span$span' data-desktop='span$span'>
					<div class='dashboard-stat $color'>
						<div class='visual'>
							<i class='icon-$icon'></i>
						</div>
						<div class='details'>
							<div class='number'>
								$number
							</div>
							<div class='desc'>									
								$desc
							</div>
						</div>
						<a class='more' href='$link'>
						$viewMore <i class='m-icon-swapright m-icon-white'></i>
						</a>						
					</div>
				</div>
				";
				
	}
}








