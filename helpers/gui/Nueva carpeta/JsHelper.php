<?php 

/**
Usage:

*/
class JsHelper{
	
	
	static function addCoreJs(){
		?>
			<!-- Inclusion javascript -->
			<script src="templates/chronos/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>	
			<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->	
			<script src="templates/chronos/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>		
			<script src="templates/chronos/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
			<!--[if lt IE 9]>
			<script src="templates/chronos/plugins/excanvas.js"></script>
			<script src="templates/chronos/plugins/respond.js"></script>	
			<![endif]-->	
			<script src="templates/chronos/plugins/breakpoints/breakpoints.js" type="text/javascript"></script>	
			<!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js -->	
			<script src="templates/chronos/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
			<script src="templates/chronos/plugins/jquery.blockui.js" type="text/javascript"></script>	
			<script src="templates/chronos/plugins/jquery.cookie.js" type="text/javascript"></script>
			<script src="templates/chronos/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>	
			
			<script src="templates/chronos/plugins/jquery.printElement.js" type="text/javascript" ></script>	
			
			<script src="templates/chronos/scripts/app.js" type="text/javascript" ></script>	
			
			<!--Fin Inclusion javascript -->	
			
			
			<!--<script src="templates/chronos/plugins/bootstrap-tag/js/bootstrap-tag.js" type="text/javascript" ></script> -->
			
			<!-- Date picker
			<script src="templates/chronos/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
			-->
			
			<!-- autocomplete
			<script src="templates/chronos/plugins/jquerytokeninput/js/jquery.tokeninput.js" type="text/javascript" ></script> 
			-->
			
	
		<?php
	}
	
	static function addJqvMap(){
		?>
		<script src="templates/chronos/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
		<script src="templates/chronos/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
		<?php
	}
	
	static function addJQueryFlot(){
		?>
		<script src="templates/chronos/plugins/flot/jquery.flot.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
		<?php
	}
	
	static function addJQueryPulsate(){
		?>
		<script src="templates/chronos/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
		<?php
	}
	
	static function addDateRange(){
		?>
		<script src="templates/chronos/plugins/bootstrap-daterangepicker/date.js" type="text/javascript"></script>
		<script src="templates/chronos/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>	
		<?php
	}
	
	static function addJQueryGritter(){
		?>
		<script src="templates/chronos/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
		<?php
	}
	
	static function addCalendar(){
		?>
		<script src="templates/chronos/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
		<?php
	}
	
	static function addPieChart(){
		?>
		<script src="templates/chronos/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
		<?php
	}
	

	static function addJQuerySparkline(){
		?>
		<script src="templates/chronos/plugins/jquery.sparkline.min.js" type="text/javascript"></script>	
		<?php
	}
	
	static function addGuiHandler(){
		?>
		<script src="templates/chronos/scripts/app.js" type="text/javascript"></script>
		<?php
	}
	
	static function addUtils(){
		?>
		<script type='text/javascript'>
			function toggle(source, name) {
				//checkboxes = document.getElementsByName('mensajes[]');
				checkboxes = document.getElementsByName( name );
				//alert('aca'  + checkboxes.length);
				//alert(source.checked);
				for(var i=0, n=checkboxes.length;i<n;i++) {
					if(source.checked){
						checkboxes[i].parentNode.setAttribute("class", "checked");
						checkboxes[i].checked = true;
					}
					else{
						checkboxes[i].parentNode.setAttribute("class", "");
						checkboxes[i].checked = false;
					}
				}
			}
		</script>
		<?php
	}
	
	
	
}








