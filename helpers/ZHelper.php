<?php 
class ZHelper{

	/**
	 * Generate javascript code to update using ajax a specific div.
	 * This library use prototype as base library
	 * 
	 * @param string div The id of the div to update
	 * @param string link The link to get the data
	 * @param string evalScripts true if we want evaluate the javascript in the answer
	 * @param string form the id of the form to send as parameter to the request null if not required params
	 * @param string callBackfunction  the function to call when the request end
	 * 
	 * 
	 */
	 
	
	public static function update( $div , $link ,  $form , $callBackCode = NULL , 
								   $evalScripts = "true" ,  $showWaitDialog = false ){
								   
		
		if( $form != NULL ){
			$parameters = " data: jQuery('#$form').serialize(),"; 
		}
		else{
			$parameters = "";
		}
		
		if( $callBackCode != NULL ){
			$callBackCode = ", onComplete: function (){ $callBackCode }";
		}
		else{
			$callBackCode = "";
		}
		
		if( $showWaitDialog ){
			$loadingDialogName = "genericdialog";
			$loadingDialog = ZHelper::showDialogMessage(
													   "Cargando los datos" ,
													   "Espere unos momentos mientras procesamos los datos",
													   "",
													   $loadingDialogName,
													   "false"
														);
														
			$closeLoading = "jQuery('#$loadingDialogName').dialog('close');";
		}
		else{
			$loadingDialog = "";
			$closeLoading = "";
		}
		
		
		
		$ajaxCall = "
					jQuery.ajax({
						url: '$link',
						$parameters
						asyn: true,
						success: 
							function(data) {
								jQuery('#$div').html(data);
								$callBackCode
							}		
						});
					";
		return $ajaxCall;
	}
	
	
	/**
	 * Generate javascript code to update using ajax a specific div.
	 * This library use prototype as base library
	 * 
	 * @param string div The id of the div to update
	 * @param string link The link to get the data
	 * @param string evalScripts true if we want evaluate the javascript in the answer
	 * @param string form the id of the form to send as parameter to the request null if not required params
	 * @param string callBackfunction  the function to call when the request end
	 * 
	 * 
	 */
	public static function periodicalUpdater( $div , $link ,  $form , $callBackCode = NULL , 
											  $effect= false , 
											  $options ,  
											  $frequency = 10 , $decay = 1 , $evalScripts = "true" ){
		
		if( $form != NULL ){
			$parameters = "parameters: $('$form').serialize(),"; 
		}
		else{
			$parameters = "";
		}
		
		if( $callBackCode != NULL ){
			$callBackCode = ", onComplete: function (){ $callBackCode }";
		}
		else{
			$callBackCode = "";
		}
		
		if( $effect == true ){
			$effect = isset( $options['effect'] ) ? $options['effect'] :  "" ;
			$effectTime = isset( $options['effectTime'] ) ? $options['effectTime'] :  "" ;
			$jseffect = "
							var options = {};
							jQuery('#$div').effect( '$effect' , options , $effectTime ); 
						";
		}
		else{
			$jseffect = "";
		}
		$ajaxCall = "	new Ajax.PeriodicalUpdater(
												'$div', 
												'$link', 
												{
							  						$parameters
													evalScripts: $evalScripts ,
													onSuccess: function(transport) {
														$('$div').innerHTML = transport.responseText;
														
														$jseffect
														
														//var options = {};
														//jQuery('#$div').effect( 'slide' , options , 800 );
													}
													$callBackCode,			 
							  						frequency: $frequency, 
							  						decay: $decay
							  					}
							  					);
					";
		return $ajaxCall;
	}
	
	

	
	
/**
	 * Generate javascript code to create an ajax call.
	 * This library use prototype as base library
	 * 
	 * @param string link The link to get the data
	 * @param string evalScripts true if we want evaluate the javascript in the answer
	 * @param string form the id of the form to send as parameter to the request null if not required params
	 * @param string callBackfunction  the function to call when the request end
	 * 
	 * 
	 */
	public static function request( $link ,  $form , $callBackCode = NULL , $evalScripts = "true" ){
		
		if( $form != NULL ){
			$parameters = "parameters: $('$form').serialize(),"; 
		}
		
		if( $callBackCode != NULL ){
			$callBackCode = ", onComplete: function (){ $callBackCode }";
		}
		else{
			$callBackCode = "";
		}
		$ajaxCall = "new Ajax.Request( 
										'$link' ,
										{
											$parameters
											evalScripts: $evalScripts 
											$callBackCode			 
										}
									);return false;
					";
		return $ajaxCall;
	}
	
	
/**
	 * Send Ajax call and update a div
	 * 
	 * @param string component action component
	 * @param string task task to execute
	 * @param boolean isAjax is ajax ( include joomla ajax required )
	 * @param div the div to update
	 * @param boolean dialog if true show dialog on finish
	 * @param array options aditional options
	 * 	            'params' => the request params
	 *              'form' => form to send
	 *               
	 * 
	 */
	public static function sendAjax( 
									 $component , 
									 $task ,  
									 $params ,    
									 $div="genericform"  ,   
									 $options ,
									 $dialog = false,  
									 $isAjax= true 
									 
									)
	{
	

		$ajax = ( $isAjax == true ) ? "tmpl=component&format=raw" : "";
		$params = ( isset( $params ) && $params != "" ) ? "&" . $params :  "" ;
		
		$link = JRoute::_('index.php?option='.$component.'&task='.$task.$params.'&'.$ajax);
		//Generic Options
		$form = isset( $options['form'] ) ? $options['form'] :  "" ;
		$callBackCode = isset( $options['callBackCode'] ) ? $options['callBackCode'] :  "" ;
		$evalScripts = isset( $options['evalScripts'] ) ? $options['evalScripts'] :  "true" ;
		$showLoading = isset( $options['showLoading'] ) ? $options['showLoading'] :  true ;
		
		if( $dialog == true ){
		
			$title = isset( $options['title'] ) ? $options['title'] :  "" ;
			$width = isset( $options['width'] ) ? $options['width'] :  "500" ; 
			$height = isset( $options['height'] ) ? $options['height'] :  "500" ;  
			$closeCode = isset( $options['closeCode'] ) ? $options['closeCode'] :  "" ;
			$hideEffect = isset( $options['hideEffect'] ) ? $options['hideEffect'] :  "" ;
			$modal = isset( $options['modal'] ) ? $options['modal'] :  "true" ;     
			$draggable = isset( $options['draggable'] ) ? $options['draggable'] :  "true" ;     
			
			$ajaxQuery	= ZHelper::createAndShowDialog(
									$title, 
									$link , 
									$form , 
									$width , 
									$height , 
									$closeCode,
									$hideEffect,
									$div,
									$modal,
									$draggable ,
									$showLoading   
									);
		}
		else{
			$ajaxQuery = ZHelper::update(
										 		$div , 
										 		$link ,  
										 		$form , 
										 		$callBackCode, 
										 		$evalScripts , 
										 		$showLoading 
												);
		}
		
		return $ajaxQuery;													
	}
	
	
	/**
	 * Send Ajax call and update a div periodically
	 * 
	 * @param string component action component
	 * @param string task task to execute
	 * @param boolean isAjax is ajax ( include joomla ajax required )
	 * @param div the div to update
	 * @param array options aditional options
	 * 	            'params' => the request params
	 *              'form' => form to send
	 * @param boolean dialog if true show dialog on finish
	 * @param boolean isAjax if true send ajax request
	 *               
	 * 
	 */
	public static function sendPeriodicalAjax( 
									 $component , 
									 $task ,  
									 $params ,    
									 $div="genericform"  ,   
									 $options ,
									 $frequency,
									 $decay, 
									 $dialog = false,  
									 $isAjax= true 
									 
									)
	{
	
		
		$ajax = ( $isAjax == true ) ? "tmpl=component&format=raw" : "";
		$params = ( isset( $params ) && $params != "" ) ? "&" . $params :  "" ;
		
		$link = JRoute::_('index.php?option='.$component.'&task='.$task.$params.'&'.$ajax);
		
		//Generic Options
		$form = isset( $options['form'] ) ? $options['form'] :  "" ;
		$callBackCode = isset( $options['callBackCode'] ) ? $options['callBackCode'] :  "" ;
		$evalScripts = isset( $options['evalScripts'] ) ? $options['evalScripts'] :  "true" ;
		$showLoading = isset( $options['showLoading'] ) ? $options['showLoading'] :  "true" ;
		
		if( $dialog == true ){
		
			$title = isset( $options['title'] ) ? $options['title'] :  "" ;
			$width = isset( $options['width'] ) ? $options['width'] :  "500" ; 
			$height = isset( $options['height'] ) ? $options['height'] :  "500" ;  
			$closeCode = isset( $options['closeCode'] ) ? $options['closeCode'] :  "" ;
			$hideEffect = isset( $options['hideEffect'] ) ? $options['hideEffect'] :  "" ;
			$modal = isset( $options['modal'] ) ? $options['modal'] :  "true" ;     
			$draggable = isset( $options['draggable'] ) ? $options['draggable'] :  "true" ;     
			
			$ajaxQuery	= ZHelper::createAndShowDialog(
									$title, 
									$link , 
									$form , 
									$width , 
									$height , 
									$closeCode,
									$hideEffect,
									$div,
									$modal
									);
		}
		else{
			
			$effect = isset( $options['effect'] ) ? true : false ;
			
			$ajaxQuery = ZHelper::periodicalUpdater(
										 		$div , 
										 		$link ,  
										 		$form , 
										 		$callBackCode,
										 		$effect,
										 		$options,
										 		$frequency,
										 		$decay, 
										 		$evalScripts 
												);
		}
		
		return $ajaxQuery;													
	}
	
	/**
	 * Create a dialog with the content of a specific div
	 * 
	 * @param string div the div with the dialog content
	 * @param string title the dialog title
	 * @param int height the dialog height
	 * @param int width the dialog width
	 * @param string closeCode the javascript to execute when the dialog is closed
	 * @param string modal true if the dialog is modal
	 * @param string draggable true if the dialog is draggable
	 * 
	 */
	public static function createAndShowDialog2( $div , $title ,  $width , $height  , $closeCode , $hideEffect = "",  
												$modal = "true" , $draggable = "true"  ){
		
												
	    
		$dialogCode = "
						if( jQuery('#$div').is(':data(dialog)')){
							jQuery('#$div').dialog( 'option' , 'title' , '$title');
							jQuery('#$div').dialog( 'option' , 'height' , '$height');
							jQuery('#$div').dialog( 'option' , 'width' , '$width');
							jQuery('#$div').dialog( 'option' , 'draggable' , '$draggable');
							jQuery('#$div').dialog( 'option' , 'modal' , '$modal');
							jQuery('#$div').dialog( 'option' , 'hide' , '$hideEffect');
							jQuery('#$div').bind( 'dialogClose' , function (event , ui ) { $closeCode } );
							jQuery('#$div').dialog('open');
						}
						else{
							jQuery('#$div').dialog( {
								bgiframe: true,
								autoOpen: false,
								height: $height ,
								width: $width,
								modal: $modal,
								draggable : $draggable,
								title : '$title',
								hide : '$hideEffect',
								close: function(event, ui) {
									$closeCode
								}
							});
							jQuery('#$div').dialog('open');
						}
					";
		return $dialogCode;
	}
	
/**
	 * Create a dialog with the content of a specific div
	 * 
	 * @param string div the div with the dialog content
	 * @param string title the dialog title
	 * @param int height the dialog height
	 * @param int width the dialog width
	 * @param string closeCode the javascript to execute when the dialog is closed
	 * @param string modal true if the dialog is modal
	 * @param string draggable true if the dialog is draggable
	 * 
	 */
	public static function createAndShowDialog(  $title , 
												 $link , 
												 $form , 
												 $width , 
												 $height  , 
												 $closeCode , 
												 $hideEffect = "",  
												 $div="genericform" ,
												 $modal = "true" , 
												 $draggable = "true",
												 $showLoading = true  
												 ){
		
												
	    
		$dialogCode = "
						if( jQuery('#$div').is(':data(dialog)')){
							jQuery('#$div').dialog( 'option' , 'title' , '$title');
							jQuery('#$div').dialog( 'option' , 'height' , '$height');
							jQuery('#$div').dialog( 'option' , 'width' , '$width');
							jQuery('#$div').dialog( 'option' , 'draggable' , '$draggable');
							jQuery('#$div').dialog( 'option' , 'modal' , '$modal');
							jQuery('#$div').dialog( 'option' , 'hide' , '$hideEffect');
							jQuery('#$div').bind( 'dialogClose' , function (event , ui ) { $closeCode } );
							jQuery('#$div').dialog('open');
						}
						else{
							jQuery('#$div').dialog( {
								bgiframe: true,
								autoOpen: false,
								height: $height ,
								width: $width,
								modal: $modal,
								draggable : $draggable,
								title : '$title',
								hide : '$hideEffect',
								close: function(event, ui) {
									$closeCode
								}
							});
							jQuery('#$div').dialog('open');
						}
					";
		$ajaxCall = ZHelper::update( $div , $link , $form , $dialogCode , true , $showLoading );
		
		return $ajaxCall;
	}
	
	/**
	 * Show a dialog to the user in popup form
	 */
	public static function showDialogMessage( $title , 
											  $text , 
											  $type="" , 
											  $div = "genericdialog" , 
											  $includeScript = "true",
											  $dialogCode = "true"
											    
											  ){
		if( strcmp ( $type , "error" ) == 0  ){
			$type = "ui-state-error";
		}	
		$script = "
					jQuery('#$div').dialog('destroy');
					$('$div').innerHTML = '$text';
	
					jQuery('#$div').dialog({
						modal: true,
						title: '$title',
						dialogClass: '$type',
						buttons: {
							Cerrar: function() {
								jQuery(this).dialog('close');
							}
						}
					});
					";
		if(  strcmp($includeScript, "true") == 0 ){
			ZHelper::initScript();
			echo $script;
			ZHelper::endScript();	
		}
		else{
			return $script;
		}
		
		
	  
	}
	
	/**
	 * Show a message to the user
	 * 
	 * @param string div the div with the dialog content
	 * @param string 
	 * 
	 */
	public static function showMessage( $message , $type ){
		$seconds = 7;
		
		if( $message  != null )
 		{
 			ZHelper::initScript();
 			$divMessage = "<div class='$type'>$message</div>";
 			echo "$('messages').innerHTML = \"$divMessage\" ;";
 			?>
 			new PeriodicalExecuter(function(pe) {
  				if ( $('messages').innerHTML != '' ){
  					$('messages').innerHTML = '';
  					pe.stop();
  				}
  			}, 
  			<?php echo $seconds;?>
  			);
 			<?php 
 			//echo ZHelper::periodicalUpdater( 'messages' , 'nothing.php' , '');
 			ZHelper::endScript();	
 		} 
	}
	
	/**
	 * Creates an Ipod Style Menu 
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function createIpodMenu( $component , 
										   $menudata , 
										   $title = "", 
										   $iniText = "Inicio", 
										   $backLink = "false" 
										   ){
		echo "
				jQuery('#$component').menu({ 
					content: $('$menudata').innerHTML,
					backLink: $backLink,
					crumbDefaultText : '$title',
					topLinkText: '$iniText'
				});
			";
	}
	
	/**
	 * Creates a progress bar 
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function createProgressBar( $divName , $percent  ){
		echo "jQuery('#$divName').progressbar({
					value: $percent	
			 });";
	}
	
	/**
	 * Creates a datepicker
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function createDatePicker( $id , $format = "yy-mm-dd" , $options = NULL  ){
		
		$minDate = isset( $options['minDate']) ? $options['minDate'] : "null";
		$maxDate = isset( $options['maxDate']) ? $options['maxDate'] : "null";
		$firstDayOfWeek = isset( $options['firstDay']) ? $options['firstDay'] : 1;
		
		//To display more than one month
		$rows = isset( $options['rows']) ? $options['rows'] : "1";
		$cols = isset( $options['cols']) ? $options['cols'] : "1";
		
		echo "jQuery('#$id').datepicker( 
				{ 
					dateFormat: '$format',
					nextText: 'Siguiente',
					prevText: 'Anterior',
					maxDate: $maxDate,
					minDate: $minDate,
					firstDay: $firstDayOfWeek,
					numberOfMonths: [ $rows , $cols ],
					showButtonPanel: true,
					showWeek: true,
					currentText: 'Hoy',
					closeText : 'Listo!',
					changeYear: true,
					changeMonth: true,
					appendText: '(yyyy-mm-dd)' ,
					monthNames: ['Enero','Febrero','Marzo','Abril',
								 'Mayo','Junio','Julio','Agosto','Septiembre',
								 'Octubre','Noviembre','Deciembre'],
					monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul',
									  'Ago','Sep','Oct','Nov','Dec'],
					dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 
							  'S&aacute;bado'],
				    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
					
				} );";
	}
	
	/**
	 * Creates a datepicker
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function createSlider( $id , $field ,  $value , $min = 1 , $max = 100 ){
		echo "jQuery('#$id').slider({
				value: $value ,
				min: $min,
				max: $max,
				slide: function(event, ui) {
					jQuery('#$field').val( ui.value ) ;
				}
			});";
	}
	
	/**
	 * Creates ajax link button
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function createAjaxLink( $text , $onclick ){
		echo "<div style='margin-top: 5px;text-align:center;width:100%' >
				<input class='fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all' 
					onclick=\"$onclick\" 
				type='button' value='$text'/>
			</div>";
	}
	
	/**
	 * Initialize a script context
	 */
	public static function initScript( $onload = false  ){
		echo "<script type='text/javascript'>
			";
		if( $onload == true ){
			echo "jQuery(document).ready(function() { ";
		}
	}
	
	/**
	 * Ends a previous initialized script context
	 */
	public static function endScript( $onload = false ){
		if( $onload == true ){
			echo "	})";
		}
		echo "
			</script>";
		
	}
	/**
	 * Creates a form 
	 * 
	 * @param string formName the name of the form
	 * 
	 */
	public static function openForm( $formName , $method="post" , $action="" , $attrbs="" ){
		echo "
			  <form id='$formName'  method='$method' action='$action' $attrbs >
		     ";
	}
	
	/**
	 * Creates an input 
	 * 
	 * @param string fieldId the id and name of the field
	 * @param string value the value of the input
	 * @param string type the input type
	 * @param string attrbs aditional attributes
	 */
	public static function createInput( $fieldId , $value="" , $type="text"  , $attrbs="" ){
		return  "<input type='$type' id='$fieldId' name='$fieldId' value='$value' $attrbs >";
	}
	
	/**
	 * Creates a link 
	 * 
	 * @param string text the link text
	 * @param string onclick the onclick actions
	 */
	public static function createLink( $text , $onclick ){
		return "<a href=\"#\" onclick=\"$onclick\">$text</a>";
	}
	
	/**
	 * Creates an image link 
	 * 
	 * @param string text the link text
	 * @param string onclick the onclick actions
	 * @param string image the image text
	 */
	public static function createImageLink( $text , $onclick , $image , $directory = '/images/' ,  $id='' ,  $style = ''  ){
		$imageData = ZHelper::createImage( $image , $directory);
		return "<a name='$id' id='$id' 
				href='#' onclick=\"$onclick\"  title='$text' style='$style'  >$imageData</a>";
	}
	
	/**
	 * Creates an html image 
	 *
	 * @param string img the image name with extension
	 * @param string directory the directory image
	 */
	public static function createImage( $img , $directory , $style = "border='0'" , $alt=""  ){
		return JHTML::image( $directory . $img , $alt , $style );
	}
	
	/**
	 * Close a form
	 * 
	 */
	public static function closeForm(   ){
		echo "
			  </form>
		     ";
	}
	
	
	/**
	 * Creates a div 
	 * 
	 * @param string id the div id
	 * @param string class the div class
	 * @param string style the div style
	 */
	public static function openDiv( $id , $class="" , $style=""  ){
		$class = ( strcmp($class , "") != 0 ) ? "class='$class'" : "";
		$style = ( strcmp($style , "") != 0 ) ? "style='$style'" : "";
		echo "
			  <div id='$id'  $class $style >
		     ";
	}
	
	
	/**
	 * Close a form
	 * 
	 */
	public static function closeDiv(  ){
		echo "
			  </div>
		     ";
	}
	
	/**
	 * Clean a div
	 * 
	 */
	public static function cleanDiv( $divId , $includeJs = false  ){
		$action = "$('$divId').innerHTML = ''";
		$action = ( $includeJs == true  ) ? ZHelper::initScript . $action . ZHelper::endScript : $action;
		return $action;
	}
	/**
	 * Creates a table header ( table )
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function createNoEditableTableHeader( $tableClass , $titleClass ,  $title , $width = 100 , $columns = 2 ){
		$columns = $columns * 2;
		echo "
			  <table border='0' cellpadding='2' cellspacing='2' width='$width%' class='$tableClass'>
		        <thead>
		            <tr>
		                <th colspan='$columns*2' align='left' class='$titleClass'>$title</th>
		            </tr>
		        </thead>
		        <tbody>
		        ";
	}
	
	/**
	 * Creates a row header
	 * 
	 * @param boolean ini is true if the row is begining or false if we want to end a row
	 * 
	 */
	function createNoEditableTableRow( $ini = true ){
		echo ($ini == true ? "<tr>" : "</tr>" );
	}
	
	/**
	 * Creates a form field 
	 * 
	 * @param string name the column description
	 * @param string value the column value
	 * @param string className the column description class
	 * @param string classValue the column value class
	 * 
	 */
	public static function createNoEditableTableField( $name , $value , $id , $tooltip ,$className = "c1" , $classValue ="c2" ){
		echo "	
                    <td class='$className'  id='$id'  title='$tooltip' >$name</td>
                    <td style='width:35%' class='$classValue' nowrap>
                       $value
                    </td>
                
		        ";
	}
	
	/**
	 * Creates an empty field
	 * 
	 * @param string className the column description class
	 * @param string classValue the column value class
	 * 
	 */
	public static function createEmptyField( $className = "c1" , $classValue ="c2" ){
		echo "	
                    <td class='$className'></td>
                    <td class='$classValue' nowrap>
                    </td>
                
		        ";
	}
	
	/**
	 * Close a form ( table )
	 * 
	 * @param string component the <a> component to show the menu
	 * @param string menudata div with the menu data
	 * 
	 */
	public static function closeNoEditableTable(  ){
		echo " <tr><td>&nbsp;</td></tr>
				</tbody>
			  </table>
				";
	}
	
	/**
	 * Print a new line code
	 */
	public static function newLine(){
		echo "<br/>";
	}
	
	public static function createToolTip( $divId , $element ){
	
    	$toolTip = 
    			"<div id='$divId'>&nbsp;</div> 
				<style>
				<!--
					#$divId { 
					    display:none; 
					    background:transparent url(images/tooltip/white_arrow.png); 
					    font-size:12px; 
					    height:70px; 
					    width:160px; 
					    padding:25px; 
					    color:#000;     
				}
				-->
				</style>
				
				<script type='text/javascript'>
					<!--
					jQuery(document).ready(
						function() { 
						    jQuery('#$element').tooltip(
						    							{
						    								tip : '#$divId',
						    								position: 'top center'
						    							}
						    ); 
						}
					);
					//-->
				</script>
    	";
   		return $toolTip;
	}
	
	
	public static function createBasicTable( $style = "" , $id="" ){
		$id = isset( $id ) ? "id='$id'" : "" ;
		echo "<table $style $id>";
	}
	
	public static function openRowBasicTable( $style = ""  ){
		echo "<tr $style >";
	}
	
	public static function openColumnBasicTable( $style = ""  ){
		echo "<td $style >";
	}
	
	public static function closeColumnBasicTable( $style = ""  ){
		echo "</td>";
	}
	
	public static function closeRowBasicTable( $style = ""  ){
		echo "</tr>";
	}
	
	public static function closeBasicTable(  ){
		echo "</table>";
	}
	
	/**
	 * Create an app table 
	 */
	public static function createAppTable(  $width = "100" , $id="" ){
		$id = isset( $id ) ? "id='$id'" : "" ;
		$table = "<table border='0' width='$width%' >
   		 		  	<tbody>
    					<tr><td valign='top'>
    			<table class='info-table' border='0' cellpadding='2' cellspacing='2' width='100%'>";
		echo $table;
	}
	
	public static function closeAppTable(   ){
		echo "</table>";
	}
	
	public static function createAppTableHeader( $title = "" , $align='left' , $colspan = 2    ){
		
		$header = "<thead>
        	 		<th colspan='$colspan' class='info-header' align='$align'>$title</th>
        		  </thead>";
		echo $header;
	}	
	
	public static function openAppTableBody(   ){	
		$body = "<tbody>";
		echo $body;
	}

	public static function closeAppTableBody(   ){	
		$body = "</tbody>";
		echo $body;
	}	
	
	public static function createAppWhiteRow(   ){	
		$row = "<tr><td></td></tr>";
		echo $row;
	}	
	
	public static function openAppRow(   ){	
		$row = "<tr>";
		echo $row;
	}	
	public static function closeAppRow(   ){	
		$row = "</tr>";
		echo $row;
	}	
	   
	public static function createAppColumn(  $data , $tdclass  ){	
		$row = "<td class='$tdclass' ><a href='#'> $data </td>";
		echo $row;
	}	
	
	public static function copyDiv( $idSource , $idDest , $javascript = false  ){
		$code = ( $javascript == true ) ? 
				ZHelper::initScript() . "$('$idDest').innerHTML = $('$idSource').innerHTML" . ZHelper::endScript() :
				"$('$idDest').innerHTML = $('$idSource').innerHTML"
				; 
		return $code;
		
	}
	
	
	
	
	
	
}
