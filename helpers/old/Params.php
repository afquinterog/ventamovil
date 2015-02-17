<?php 

/**
Usage:

Configuration::setValue("CANTIDAD_MENSAJES", "30");
$cantidad = Configuration::getValue("CANTIDAD_MENSAJES");

*/
class Params{
	
	
	function articulo(){
		return '{"show_title":"1","link_titles":"0","show_intro":"0","show_category":"0","link_category":"0","show_parent_category":"0","link_parent_category":"0",
				"show_author":"0","link_author":"0","show_create_date":"0","show_modify_date":"0","show_publish_date":"0","show_item_navigation":"0","show_vote":"0",
				"show_icons":"0","show_print_icon":"0","show_email_icon":"0","show_hits":"0","show_noauth":"","urls_position":"","menu-anchor_title":"","menu-anchor_css":"",
				"menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"",
				"robots":"","secure":0,"gk_desc":"","gk_cols":"1","gk_group":"0","gk_class":"","gk_subcontent":"0","gk_subcontent_pos_positions":"menu1"}';
		
	}
	
	function agrupador(){
		return '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,
				"gk_showtitle":"1","gk_desc":"","gk_cols":"1","gk_group":"1",
				"gk_class":"","gk_subcontent":"0","gk_subcontent_pos_positions":"menu1"}';
	}
	
	
	
	
	
	
}








