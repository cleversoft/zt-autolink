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
if (!class_exists('ZtautolinksController')) {

    class ZtautolinksController extends JControllerLegacy {

        /**
         * @var		string	The default view.	 
         */
        protected $default_view = 'dashboard';

        public function redirect() {
            JModelLegacy::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/models');
            $model = JModelLegacy::getInstance('Item', 'ZtautolinksModel');
            $item = $model->getItem();
            $item->count++;
            $model->save($item->getProperties());
            JFactory::getApplication()->redirect(JRoute::_($item->link));
        }

    }

}