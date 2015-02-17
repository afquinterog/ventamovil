<?php 

/**
Usage:

*/
class GuiUserDropdownHelper{
	
	static function show($username){
		echo "
					<li class='dropdown user'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						<img alt='' src='assets/img/avatar1_small.jpg' />
						<span class='username'>$username</span>
						<i class='icon-angle-down'></i>
						</a>
						<ul class='dropdown-menu' id='ul_user_dropdown'>
						</ul>
					</li>
				";
				
	}
	
	/**
	* Adds a item to the notification bar
	* icons (user,calendar,envelope,tasks,key)
	*/
	static function addItem($link, $icon, $text){
		$data = "<li><a href='$link'><i class='icon-$icon'></i>&nbsp;$text</a></li>";	
		$data = UtilHelper::toOneLine($data);
		UtilHelper::append('ul_user_dropdown',$data);
	}
	
	/**
	* Adds a item to the notification bar
	* icons (user,calendar,envelope,tasks,key)
	*/
	static function addSeparator(){
		$data = "<li class='divider'></li>";	
		$data = UtilHelper::toOneLine($data);
		UtilHelper::append('ul_user_dropdown',$data);
	}
	
	

	
}








