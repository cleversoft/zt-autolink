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
if (!class_exists('ZtautolinksControllerItem')) {
    jimport('joomla.application.component.controllerform');

    /**
     * ZtalControllerItem
     */
    class ZtautolinksControllerItem extends JControllerForm {

        /**
         * 
         * @param type $config
         */
        public function __construct($config = array()) {
            /* Set default view list */
            $this->view_list = 'dashboard';
            parent::__construct($config);
        }

        protected function checkEditId($context, $id) {
            return true;
        }

    }

}