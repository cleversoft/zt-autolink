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
 * Class exists checking
 */
if (!class_exists('ZtautolinksControllerDashboard')) {
    jimport('joomla.application.component.controlleradmin');

    /**
     * Dashboard controller
     */
    class ZtautolinksControllerDashboard extends JControllerAdmin {

        /**
         * Get model proxy
         * @param string $name
         * @param string $prefix
         * @param array $config
         * @return object
         */
        public function getModel($name = 'Dashboard', $prefix = 'ZtautolinksModel', $config = array('ignore_request' => true)) {
            $model = parent::getModel($name, $prefix, $config);
            return $model;
        }

    }

}
