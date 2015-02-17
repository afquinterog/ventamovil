<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Menu{
	
	
	function test(){
		/*$items = Menu::getItems('A',0);
		
		echo Menu::buildMenuItem($items[1]);*/
		/*if(Menu::haveChilds($items[1]->id)){
			echo "has childs";
		}*/
		Menu::getMenu('A');
		
	}
	
	static function getMenu($type='A'){
		$items = Menu::getItems($type,0);
		$menu = "";
		foreach($items as $item){
			$menu = $menu . Menu::buildMenuItem($item);
		}
		return $menu;
	}
	
	
	
	static function buildMenuItem($item){
		if( !Menu::haveChilds($item->id) ){
			//Pone el </a>
			return Menu::buildLeaf($item);
		}
		else{
			 $itemData = Menu::buildItem($item);
			 //echo "construye item";
			 $childs = Menu::getItemChilds($item);
			 //echo "childs";
			 //print_r($childs);
			 $itemChilds = "";
			 foreach($childs as $child){
				$itemChilds = $itemChilds . Menu::buildMenuItem($child);
			 }
			 return $itemData . $itemChilds . "</ul></li>";
		}
		
	}
	
	static function getItems($type,$parent=0){
		$db = JFactory::getDBO();
		//Obtiene los items de primer nivel
		$tbMenus = $db->nameQuote('#__zmenus');
		$query = "SELECT 
						* 
				  FROM 
						$tbMenus
				  WHERE 
						parent = %s AND
						type = '%s'
				  ORDER BY
						iorder 
				 "; 
		$query = sprintf($query, $parent, $type);
		//echo $query;
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	static function getItemChilds($parent){
		$db = JFactory::getDBO();
		//Obtiene los items de primer nivel
		$tbMenus = $db->nameQuote('#__zmenus');
		$query = "SELECT 
						* 
				  FROM 
						$tbMenus
				  WHERE 
						parent = %s 
				ORDER BY
						iorder 
				 ";
		$query = sprintf($query, $parent->id);
		$db->setQuery($query);
	    $result = $db->loadObjectList();
		return $result;
	}
	
	
	static function haveChilds($item){
		$db = & JFactory::getDBO();
		//Obtiene los items de primer nivel
		$tbMenus = $db->nameQuote('#__zmenus');
		$query = "SELECT 
						count(*) 
				  FROM 
						$tbMenus
				  WHERE 
						parent = %s 
				 ";
				 
		$query = sprintf($query, $item);
		$db->setQuery($query);
	    $result = $db->loadResult();
		return ($result >0 ) ? true: false;
	}
	
	//<span class='selected' id=''></span>
	static function buildItem($item){
		$class = ($item->start == 'S') ? "start" : "";
		$data = "<li class='$class' id='{$item->id}'>
					<a href='{$item->link}'>
					<i class='icon-{$item->icon}'></i> 
					<span class='title'>{$item->title}</span>
					<span class='arrow'></span>
					</a>
				<ul class='sub-menu'>";
		return $data;
				
	}
	
	static function buildLeaf($item){
		$class = ($item->start == 'S') ? "start" : "";
		$data = "<li class='$class' id='{$item->id}'>
					<a href='{$item->link}'>
					<i class='icon-{$item->icon}'></i> 
					<span class='title'>{$item->title}</span>
					<span class='selected'></span>
					</a>
				</li>";
		return $data;
	}
	
	static function setActive($id){
		echo "<script type='text/javascript'>";
		echo "jQuery(document).ready(function() {";
		echo "jQuery('#" . $id . "').addClass('active');";
		echo "jQuery('#" . $id . " > ul').css('display' ,'block');";
		echo "jQuery('#" . $id . " > ul >li > ul').css('display' ,'none');";
		echo "});";
		echo "</script>";
	}
	
	
	static function changeMenuText($id, $text){
		echo "<script type='text/javascript'>
				jQuery(document).ready(function(){ 
					 jQuery('#{$id}').find( '.title' ).text( '{$text}' ); 
				});
				</script>
			  ";
		
	}
	
}








