<?php

/**
 * Zt Autolinks
 * @package Joomla.Component
 * @subpackage com_ztautolinks
 * @version 0.5.5
 *
 * @copyright   Copyright (c) 2013 APL Solutions (http://apl.vn)
 *
 */
defined('_JEXEC') or die;

/**
 * Script file of Zt Autolinks component
 */
class com_ZtAutolinksInstallerScript {

    /**
     * JDatabase object
     * @var object
     */
    private $_db;

    /**
     * Table name
     * @var type 
     */
    private $_tablename;

    /**
     * Error code
     * @var type 
     */
    private $_error;

    /**
     * Table struct
     * @var type 
     */
    private $_tablestruct;

    /**
     * Construction
     */
    function __construct() {
        /* Load language */
        $lang = JFactory::getLanguage();
        $lang->load('com_ztautolinks', JPATH_ADMINISTRATOR);
        /* Init data */
        $this->_db = JFactory::getDbo();
        $this->_tablename = "#__ztautolinks";
        $this->_error = 0;
        /* Init table struct */
        $this->_tablestruct = array(
            'id' => array('type' => 'INT(11)', 'key' => 'PRIMARY', 'extra' => 'AUTO_INCREMENT'),
            'published' => array('type' => 'TINYINT(1)', 'key' => '', 'extra' => ''),
            'keyword' => array('type' => 'VARCHAR(255)', 'key' => 'UNIQUE', 'extra' => ''),
            'link' => array('type' => 'VARCHAR(255)', 'key' => '', 'extra' => ''),
            'limits' => array('type' => 'INT(11)', 'key' => '', 'extra' => ''),
            'occurrence' => array('type' => 'TINYINT(4)', 'key' => '', 'extra' => ''),
            'priority' => array('type' => 'INT(11)', 'key' => '', 'extra' => ''),
            'status' => array('type' => 'TINYINT(4)', 'key' => '', 'extra' => ''),
            'count' => array('type' => 'INT(11)', 'key' => '', 'extra' => ''),
            'params' => array('type' => 'TEXT', 'key' => '', 'extra' => ''),
        );
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
        foreach ($this->_tablestruct as $columnName => $columData) {
            $query = $this->_db->getQuery(true);
            $query->select($this->_db->quoteName($columnName));
            $query->from($this->_db->quoteName($this->_tablename));
            $this->_db->setQuery($query);
            $ret = $this->_db->execute();
            if ($ret === false) {
                $this->_db->setQuery("ALTER TABLE " . $this->_db->quoteName($this->_tablename) . " ADD " . $this->_db->quoteName($columnName) . " " . $columData['type'] . " NOT NULL");
                $ret = $this->_db->execute();
            } else {
                /**
                 * Colum existed
                 * @todo Check column data type
                 */
            }

            /* Enable plugin */
            $db = JFactory::getDbo();
            $query = 'UPDATE ' . $db->quoteName('#__extensions') . ' SET ' . $db->quoteName('enabled') . ' = 1 WHERE ' . $db->quoteName('type') . ' = ' . $db->quote('plugin') . ' AND ' . $db->quoteName('element') . ' = ' . $db->quote('ztautolinks');
            $db->setQuery($query);
            $db->execute();
        }
    }

}
