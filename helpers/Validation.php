<?php 

/**
Javascript Form Validation

Usage:

Validation::initValidation("form");
Validation::required("nombre", true); //First validation always true
Validation::email("correo");
Validation::number("movil");
Validation::endValidation();

*/
class Validation{

	
	
	public static function initValidation($form){
		?>	
		<script src="templates/chronos/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>
		<script src="templates/chronos/plugins/jquery-validation/dist/additional-methods.min.js" type="text/javascript" ></script> 
		<script src="templates/chronos/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js" type="text/javascript" ></script> 
		<script src="templates/chronos/plugins/jquery-validation/localization/messages_es.js" type="text/javascript" ></script> 
			
		<script type='text/javascript'>
			
			var form1 = $('#<?php echo $form; ?>');
			var error1 = $('.alert-error', form1);
			var success1 = $('.alert-success', form1);
			
			form1.validate({
				lang : 'es',
				errorElement: 'span', //default input error message container
				errorClass: 'help-inline', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: '',
				rules: {
		<?php
	}
	

	public static function required($name, $first=false){
		echo ( !$first  ? "," : "");
		?>
		<?php echo $name; ?> : {
                        required: true
                    }
		<?php 
		
	}
	
	public static function email($name, $first=false){
		echo ( !$first ? "," : "");
		?>
			<?php echo $name; ?> : {
                        required: true,
						email:true
                    }
		<?php
			
	}
	
	public static function minSize($name, $size, $first=false){
		echo ( !$first ? "," : "");
		?>
			<?php echo $name; ?> : {
                        required: true,
						minlength: <?php echo $size; ?>,
                    }
		<?php
		
	}
	
	public static function url($name, $first=false){
		echo ( !$first ? "," : "");
		?>
			<?php echo $name; ?> : {
                        required: true,
						url: true
                    }
		<?php
	}
	
	public static function number($name, $first=false){
		echo ( !$first ? "," : "");
		?>
			<?php echo $name; ?> : {
                        required: true,
						number: true
                    }
		<?php
	}
	
	public static function digits($name, $first=false){
		echo ( !$first ? "," : "");
		?>
			<?php echo $name; ?> : {
                        required: true,
						digits: true
                    }
		<?php
	}
	
	
	public static function endValidation(){
		?>
			},
			
			invalidHandler: function (event, validator) { //display error alert on form submit              
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
			},

			highlight: function (element) { // hightlight error inputs
				$(element)
					.closest('.help-inline').removeClass('ok'); // display OK icon
				$(element)
					.closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
			},

			unhighlight: function (element) { // revert the change dony by hightlight
				$(element)
					.closest('.control-group').removeClass('error'); // set error class to the control group
			},

			success: function (label) {
				label
					.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
				.closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
			},

			submitHandler: function (form) {
				success1.show();
				error1.hide();
				form.submit();
			}
		});
		
		</script>
		
		<?php
		
		
	}
	
}








