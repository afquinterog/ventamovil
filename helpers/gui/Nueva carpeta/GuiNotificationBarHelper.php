<?php 

/**
Usage:

*/
class GuiNotificationBarHelper{
	
	static function show(){
		echo "
					<li class='dropdown' id='header_notification_bar'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						<i class='icon-warning-sign'></i>
						<span class='badge'>10</span>
						</a>
						<ul class='dropdown-menu extended notification' id='ul_notification_bar'>
							<li>
								<p>You have 14 new notifications</p>
							</li>
						</ul>
					</li>
				";
				
	}
	
	/**
	* Adds a item to the notification bar
	* types(success, important, warning, error)
	*/
	static function addItem($msg, $description, $type){
		//Success message
		if($type == "success"){
			$label =  "success";
			$icon  =  "plus";
		}
		
		//Important message
		if($type == "important"){
			$label = "important";
			$icon  = "bolt";
		}
		
		//warning message
		if($type == "warning"){
			$label = "warning";
			$icon  = "bell";
		}
		
		//error message
		if($type == "error"){
			$label = "info";
			$icon  = "bullhorn";
		}
		
		$data = "<li>
					<a href='#'>
						<span class='label label-$label'><i class='icon-$icon'></i></span>
						$msg
						<span class='time'>&nbsp;$description</span>
					</a>
				</li> 
				";
		
		$data = UtilHelper::toOneLine($data);
		UtilHelper::append('ul_notification_bar',$data);
	}
	
	

	
}








