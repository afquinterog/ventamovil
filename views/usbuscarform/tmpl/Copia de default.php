<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;


//GUIHelper::mensajeSuperior( JText::_('CORREOS_TITULO_PAGINA_INICIO') );
$showError1 = ($this->error == 1) ? "" : "hide" ;
$showError2 = ($this->error == 2) ? "" : "hide" ;
?>
 <!-- BEGIN LOGO -->
  <div class="logo">
    <!-- <img src="templates/chronos/img/logounebig.png" alt="" /> -->
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="index.php" method='post'>
      <h3 class="form-title">App Montejo V1.0</h3>
      <div class="alert alert-error <?php echo $showError1;?>">
        <button class="close" data-dismiss="alert"></button>
        <span>Ingrese un usuario y clave v&aacute;lida.</span>
      </div>
	  
	  <div class="alert alert-error <?php echo $showError2;?>">
        <button class="close" data-dismiss="alert"></button>
        <span>El usuario se encuentra bloqueado.</span>
      </div>
	  
	  
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Usuario</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Usuario" name="username"/>
          </div>
        </div>
      </div>
	  
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Clave</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Clave" name="password"/>
          </div>
        </div>
      </div>
	  
      <div class="form-actions">
        <label class="checkbox">
        <input type="checkbox" name="remember" value="1"/> Recordame
        </label>
        <button type="submit" class="btn green pull-right">
			Ingresar <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
	  
      <div class="forget-password">
        <h4>Olvido su clave ?</h4>
        <p>
          no se preocupe, siga este <a href="#" class="" id="forget-password">enlace</a>
        </p>
      </div>
	  
      <div class="create-account">
        <p>
          No tiene una cuenta aun?&nbsp; 
          <a href="#" id="register-btn" class="">Crear una cuenta</a>
        </p>
      </div>
	  <input type="hidden" name="option" value="com_ztadmin" />
	  <input type="hidden" name="task" value="userLogin" />
	  <?php echo JHtml::_( 'form.token' ); ?>
    </form>	
    <!-- END LOGIN FORM -->      
	
   
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    2014 &copy; TusConsultores.com 
  </div>
  
 <script type='text/javascript'>
		document.body.className = 'login';
 </script>
 
 <?php
	JsHelper::addCoreJs(); 
	
 ?>
 
 <script type='text/javascript'>
	jQuery(document).ready(function() {		
		App.init(); // initlayout and core plugins
	});
</script>