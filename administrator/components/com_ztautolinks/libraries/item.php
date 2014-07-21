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
 * Class exists checking
 */
if (!class_exists('ZtautolinksItem')) {

    /**
     * Zt Autolink item object class
     */
    class ZtautolinksItem extends JObject {

        /**
         * Construction
         * @param object $properties
         */
        public function __construct($properties = null) {
            parent::__construct($properties);
            if ($this->get('params') instanceof JRegistry) {
                
            } else {
                $this->set('params', new JRegistry($this->get('params')));
            }
        }

        /**
         * Check if this link is internal
         * @return boolean
         */
        public function isInternal() {
            if (strpos($this->link, JUri::root(), 0) === false) {
                return false;
            }
            return true;
        }

        /**
         * 
         * @return string
         */
        public function getRedirectLink() {
            if ($this->params->get('redirect') == 1) {
                return JRoute::_('index.php?option=com_ztautolinks&task=linkRedirect&id=' . $this->id);
            } else {
                if ($this->isInternal()) {
                    return JRoute::_($this->link);
                } else {
                    return $this->link;
                }
            }
        }

        /**
         * Get item link use for redirect
         * @return string
         */
        public function getLink() {
            return $this->link;
        }

        /**
         * 
         * @return string
         */
        public function getOccurrenceText() {
            switch ($this->get('occurrence', 0)) {
                case 1:
                    return 'Top';
                    break;
                case 2:
                    return 'End';
                    break;
                case 3:
                    return 'Random';
                default:
                    return 'Random';
                    break;
            }
        }

        /**
         * 
         * @return string
         */
        public function getEditLink() {
            return JRoute::_('index.php?option=com_ztautolinks&task=item.edit&id=' . $this->get('id'));
        }

        /**
         * Save to table
         * @return boolean
         */
        public function save() {
            $table = JTable::getInstance('Items', 'ZtautolinksTable');
            if ($table) {
                $table->bind($this->getProperties());
                if ($table->check()) {
                    return $table->store();
                }
            }
            return false;
        }

    }

}