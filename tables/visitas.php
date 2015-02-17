<?php

/**
* @version			1.0
* @package			TusConsultores
* @copyright		Copyright (C) 2014 Tusconsultores.com
* @Fecha			18/08/2014 09:13:25 p.m.
*/


// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableVisitas extends JTable {
    /**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__zvisitas', 'id', $db );
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