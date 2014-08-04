<?php

/**
 * Zt Autolinks
 * @package Joomla.Component
 * @subpackage com_ztautolinks
 * @version 0.5.7
 *
 * @copyright   Copyright (c) 2013 APL Solutions (http://apl.vn)
 *
 */
defined('_JEXEC') or die;

/**
 * Script file of Zt Autolinks plugin
 */
class plgSystemZtAutolinksInstallerScript {

    /**
     * Construction
     */
    function __construct() {
        /* Load language */
        $lang = JFactory::getLanguage();
        $lang->load('com_ztautolinks', JPATH_ADMINISTRATOR);
    }

    /**
     * method to install the component
     * @param object $parent Parent object
     * @return void
     */
    function install($parent) {
        
    }

    /**
     * method to uninstall the component
     * @param object $parent Parent object
     * @return void
     */
    function uninstall($parent) {
        
    }

    /**
     * method to update the component
     * @param object $parent Parent object
     * @return void
     */
    function update($parent) {
        
    }

    /**
     * method to run before an install/update/uninstall method
     * @param type $type
     * @param object $parent Parent object
     * @return void
     */
    function preflight($type, $parent) {
        
    }

    /**
     * Method to run after an install/update/uninstall method
     * @uses
     * Postflight is executed after the Joomla install, update or discover_update actions have completed. 
     * It is not executed after uninstall. 
     * Postflight is executed after the extension is registered in the database. 
     * The type of action (install, update or discover_install) is passed to postflight in the $type operand. 
     * Postflight cannot cause an abort of the Joomla install, update or discover_install action.
     * @param string $type
     * @param type $parent
     */
    function postflight($type, $parent) {
		/* Only enable plugin on install/update */
		if($type !== 'install' && $type !== 'update') return;
        /* Enable plugin */
        $db = JFactory::getDbo();
        $query = 'UPDATE ' . $db->quoteName('#__extensions') . ' SET ' . $db->quoteName('enabled') . ' = 1 WHERE ' . $db->quoteName('type') . ' = ' . $db->quote('plugin') . ' AND ' . $db->quoteName('element') . ' = ' . $db->quote('ztautolinks');
        $db->setQuery($query);
        $db->execute();
    }

}
