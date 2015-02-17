<?php 
class FileHelper{


	/**
	* Guarda un archivo en una ruta con un nombre
	*Usage
		jimport('joomla.filesystem.file');
		//Guarda adjunto 1
		$data = JRequest::getVar('file1', null, 'files'); 
		$nombre = JFile::makeSafe($data['name']);
		$nombre = JFile::stripExt($nombre);
		if($nombre != ""){
			FileHelper::guardarArchivo($data, "images/adjuntos/", "{$id}_{$nombre}");
		}
	*/
	
	function guardarArchivo($data, $ruta, $nombre){
		jimport('joomla.filesystem.file');
		$nombreOriginal = JFile::makeSafe($data['name']);
		$ext =  JFile::getExt($nombreOriginal);
		//$nombreOriginal = explode(".",$nombreOriginal);
		$tmp 	= $data["tmp_name"];
		if(JFile::copy($tmp, $ruta . $nombre . "." . $ext)){
			return true;
		}
		else{
			return false;
		}
		
		//$dest = "../celured/templates/gk_bikestore/images/style1/" . DS . $nombre ;
		
		//Redimensionar imagen antes de copiar
		/*if(Image::resize($nombreTmp, $dest, 175 , 0 )){
			//return JText::_("M_OK") . JText::_("LOGO_CAMBIAR");
			return true;
		}
		else{
			//return JText::_("M_ERR") . JText::_("PROCESO_ERROR");
			return false
		}*/
	}
}








