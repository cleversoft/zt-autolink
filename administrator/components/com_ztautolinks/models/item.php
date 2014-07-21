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

if (!class_exists('ZtautolinksModelItem')) {
    jimport('joomla.application.component.modeladmin');

    class ZtautolinksModelItem extends JModelAdmin {

        /**
         * 
         * @param type $data
         * @param type $loadData
         * @return type
         */
        public function getForm($data = array(), $loadData = true) {
            $form = $this->loadForm(
                    'com_ztautolinks.item', 'item', array('control' => 'jform', 'load_data' => $loadData)
            );
            return $form;
        }

        protected function loadFormData() {
            return $this->getItem();
        }

        public function getTable($type = 'Items', $prefix = 'ZtautolinksTable', $config = array()) {
            return JTable::getInstance($type, $prefix, $config);
        }

        public function checkin($pks = array()) {
            return true;
        }

        public function checkout($pk = null) {
            return true;
        }

    }

}