<?php 

/**
Usage:

*/
class GuiTaskBarHelper{
	
	static function show(){
		echo "
					<li class='dropdown' id='header_task_bar'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						<i class='icon-tasks'></i>
						<span class='badge'>5</span>
						</a>
						<ul class='dropdown-menu extended tasks' id='ul_task_bar'>
							<li>
								<p>You have 12 pending tasks</p>
							</li>
						</ul>
					</li>
				";
				
	}
	
	/**
	* Adds a item to the notification bar
	* types(success, important, warning, error)
	*/
	static function addItem($link, $description, $percent, $type, $animation=false){
	
		//Success message
		if($type == "success"){
			$class =  "progress progress-success ";
			$animation = ($animation == true) ? "progress-striped active" : "";
		}
		
		//Important message
		if($type == "danger"){
			$class =  "progress progress-success ";
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
					<a href='$link'>
						<span class='task'>
							<span class='desc'>$description</span>
							<span class='percent'>$percent%</span>
						</span>
						<span class='$class '>
							<span style='width: $percent%;' class='bar'></span>
						</span>
					</a>
				</li>
				";
		
		$data = UtilHelper::toOneLine($data);
		UtilHelper::append('ul_task_bar',$data);
	}
	
	/**
	* Link to see all the items
	*/
	static function seeAll($msg){
		$data = "<li class='external'>
				<a href='inbox.html'>See all messages <i class='m-icon-swapright'></i></a>
			  </li>";
		$data = UtilHelper::toOneLine($data);
		UtilHelper::append('ul_task_bar',$data);
	}
	
	

	
}








