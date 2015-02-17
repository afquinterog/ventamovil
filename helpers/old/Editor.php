<?php 
class Editor{

	public static function includeEditor(){
		$document =& JFactory::getDocument();
		$document->addScript(JURI::root() . "media/system/js/custom/tiny_mce/tiny_mce.js");
		echo "
		<script type=\"text/javascript\">
			tinyMCE.init({
			// General options
			mode : \"textareas\",
			theme : \"advanced\",
			plugins : \"autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager\",

			// Theme options
			theme_advanced_buttons1 : \"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect\",
			theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
			theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",
			theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage\",
			theme_advanced_toolbar_location : \"top\",
			theme_advanced_toolbar_align : \"left\",
			theme_advanced_statusbar_location : \"bottom\",
			theme_advanced_resizing : true,

			// Skin options
			skin : \"o2k7\",
			skin_variant : \"silver\",

			// Example content CSS (should be your site CSS)
			content_css : \"css/example.css\",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : \"js/template_list.js\",
			external_link_list_url : \"js/link_list.js\",
			external_image_list_url : \"js/image_list.js\",
			media_external_list_url : \"js/media_list.js\",

			// Replace values for the template plugin
			template_replace_values : {
					username : \"Some User\",
					staffid : \"991234\"
        }
		
				
		});
		</script>";
		
	}
	
	public static function includeEditor2($editors){
		$document =& JFactory::getDocument();
		$document->addScript(JURI::root() . "components/com_ztadmin/libraries/ckeditor/ckeditor.js");
		$document->addScript(JURI::root() . "components/com_ztadmin/libraries/ckfinder/ckfinder.js");
		//$route = "http://localhost/celuredadmin/components/com_ztadmin/libraries/ckfinder";
		$routeCkFinder = Configuration::getValue("CKFINDER_PATH");
		
		echo "
		<script type=\"text/javascript\">
			CKFinder.setupCKEditor( null, 'components/com_ztadmin/libraries/ckfinder/' );
		";
		
		foreach($editors as $editor){
			
			echo "CKEDITOR.replace( 	'$editor', 
								{
								filebrowserBrowseUrl : '$routeCkFinder/ckfinder.html',
								filebrowserImageBrowseUrl : '$routeCkFinder/ckfinder.html?type=Images',
								filebrowserFlashBrowseUrl : '$routeCkFinder/ckfinder.html?type=Flash',
								filebrowserUploadUrl : '$routeCkFinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
								filebrowserImageUploadUrl : '$routeCkFinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
								filebrowserFlashUploadUrl : '$routeCkFinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
								});";
		
		}
		
		echo "</script>";
		
	}
	
}








