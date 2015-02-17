<?php

/**
* @version			1.0
* @package			TusConsultores
* @copyright		Copyright (C) 2014 Tusconsultores.com
* @Fecha			11/08/2014 08:10:15 p.m.
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableTareas_registros extends JTable {
    /**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__ztareas_registro', 'id', $db );
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		return true;
	}

}
?>