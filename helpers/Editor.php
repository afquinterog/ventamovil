<?php 
class Editor{

	public static function includeEditor2($editors){
		$document =& JFactory::getDocument();
		$document->addScript(JURI::root() . "libraries/ckeditor/ckeditor.js");
		$document->addScript(JURI::root() . "libraries/ckfinder/ckfinder.js");
		//$route = "http://localhost/celuredadmin/components/com_ztadmin/libraries/ckfinder";
		$routeCkFinder = Configuration::getValue("CKFINDER_PATH");
		
		echo "
		<script type=\"text/javascript\">
			CKFinder.setupCKEditor( null, 'libraries/ckfinder/' );
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








