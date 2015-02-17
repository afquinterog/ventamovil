<?php 
class ZExcelHelper{

	
	/**
	 * Create Objective Table with the specified objective data
	 * 
	 * 
	 */
	public static function exportData( $data , $options   ){
	
		//Excel Export Files
		require_once( JPATH_SITE . DS . 'libraries' . DS .  'phpexcel' . DS . 'PHPExcel.php' );
		require_once( JPATH_SITE . DS . 'libraries' . DS .  'phpexcel' . DS . 'PHPExcel' . DS . 'IOFactory.php' );
		 
		
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("TusConsultores")
									 ->setLastModifiedBy("TusConsultores")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Report generated whit ZFramework")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("TusConsultores");
		$headerStyleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startcolor' => array(
					'argb' => 'FFA0A0A0',
				),
				'endcolor' => array(
					'argb' => 'FFFFFFFF',
				),
			),
		);
		
		$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
						 'AA','AB', 'AC', 'AD', 'AE', 'AF','AG' );

		$columns = $options['columns'];
		$numColumns = count( $columns );
		
		$columnIndex = 0 ;
		//Put column titles
		foreach( $columns as $column ){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $columnIndex , 1 , $column['description'] ) ;
			$objPHPExcel->getActiveSheet()->getStyle( $letters[ $columnIndex ].'1' )
					->applyFromArray( $headerStyleArray );
			$objPHPExcel->getActiveSheet()->getColumnDimension( $letters[ $columnIndex ] )->setAutoSize( true );
			$columnIndex = $columnIndex + 1 ;
		}
			
		//Puts the data
		$rowIndex = 2 ;

		foreach( $data as $row ){
			$columnIndex = 0 ;
			foreach( $columns as $column ){
				$property = $column['property'] ;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 
												$columnIndex , $rowIndex , $row->$property 
										) ;
				$columnIndex = $columnIndex + 1 ;   
			}
			$rowIndex = $rowIndex + 1 ; 
		}
		
		
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle( $options['title'] ) ; 
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
				
		// Save Excel 2007 file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$fileName = $options['path'];
		error_reporting(E_ALL);
		ini_set('display_errors','On');

		//echo "fn = $fileName "; 
		if( is_readable($fileName ) ){
			unlink( $fileName ) ;
		}
		$objWriter->save(  $fileName ) ;
		
		//The http path of the file
		$urlpath = $options['urlfile'];
		
		//Guarda url en la sesion 
		Session::setVar('actualReport', $urlpath);
		
		//echo "fn = $urlpath "; 
		//exit;
		?>
		<script type='text/javascript'>
		    //window.alert('data');
			window.open('http://www.google.com');
			window.open('<?php echo $urlpath; ?>' );
		</script>		
<?php
		}
		
		
		public static function openExcel( $file ){
			//Excel Export Files
			require_once( JPATH_SITE . DS . 'libraries' . DS .  'phpexcel' . DS . 'PHPExcel.php' );
			require_once( JPATH_SITE . DS . 'libraries' . DS .  'phpexcel' . DS . 'PHPExcel' . DS . 'IOFactory.php' );
			
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			//$objReader->setReadDataOnly(true);
			$objPhpExcel = $objReader->load( $file );	
			return $objPhpExcel;
			
		}
		
		public static function readExcel($objPhpExcel, $row, $col){
			$objWorksheet = $objPhpExcel->getActiveSheet();
			$data = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
			return $data;
		}
		
		public static function writeExcel($objPhpExcel, $row, $col, $value){
			//$objPhpExcel->setActiveSheetIndex($sheet)->setCellValue($cell, $value);
			//$objWorksheet = $objPhpExcel->getActiveSheet();
			$objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}
		
		
		public static function saveExcel($objPhpExcel, $name){
			$objWriter = PHPExcel_IOFactory::createWriter($objPhpExcel, 'Excel5'); 
			$objWriter->save( $name ) ;
		}
}


/**Usage Example
 * 
excelName = "mensajes.xls";
$opts = array(
			'title' => "Reporte de mensajes",
			'urlfile' => JURI::root() ."components/" . $option . '/temp/' . $excelName ,
			'path' =>   JPATH_COMPONENT . DS . 'temp' . DS . $excelName,
			'columns' =>  array(		
								array(
									'description' => "Nombre",
									'property' => "name"
								),
								array(
									'description' => "Dependencia",
									'property' => "dependency"
								),
								array(
									'description' => "Tipo",
									'property' => "type"
								),
								array(
									'description' => "Fecha de envio",
									'property' => "createddate"
								),
								array(
									'description' => "Mensaje",
									'property' => "message"
								),
								array(
									'description' => "Empresa",
									'property' => "factory"
								),
								array(
									'description' => "Adjunto",
									'property' => "file"
								)
							)
								
			);
ZExcelHelper::exportData( $this->rows , $opts  );
 * 
 * 
 * 
 * 
 */
?>


