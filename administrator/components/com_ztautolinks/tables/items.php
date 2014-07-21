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

if (!class_exists('ZtautolinksTableItems')) {

    /**
     * ZT Autolink main table
     */
    class ZtautolinksTableItems extends JTable {

        /**
         * Record ID
         * @var integer 
         */
        public $id = null;

        /**
         * Public status
         * @var integer
         */
        public $published = null;

        /**
         * Keyword
         * @var string
         */
        public $keyword = null;

        /**
         * Link
         * @var string 
         */
        public $link = null;

        /**
         * Count
         * @var integer 
         */
        public $count = null;

        /**
         * Occurence
         * @var integer 
         */
        public $occurrence = null;

        /**
         * Priority
         * @var integer 
         */
        public $priority = null;

        /**
         * Status
         * @var integer
         */
        public $status = null;

        /**
         * Addition data
         * @var string 
         */
        public $params = null;

        /**
         * Construction
         * @param pointer $db
         */
        public function __construct(&$db) {
            parent::__construct('#__ztautolinks', 'id', $db);
        }

        /**
         * Check for valid data
         * @return boolean
         */
        public function check() {
            if (parent::check()) {
                if ($this->keyword == '' || $this->link == '')
                    return false;
                /* External */
                if (strpos($this->link, JUri::root(), 0) === false) {
                    if (!filter_var($this->get('link'), FILTER_VALIDATE_URL)) {
                        JFactory::getApplication()->enqueueMessage(JText::_('COM_ZTAUTOLINKS_INVALID_URL'), 'warning');
                        return false;
                    }
                }
                $this->params = new JRegistry($this->params);
                $this->params = (string) $this->params;
                return parent::check();
            }
        }

    }

}