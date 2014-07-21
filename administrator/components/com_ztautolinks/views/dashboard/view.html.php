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

if (!class_exists('ZtautolinksViewDashboard')) {

    class ZtautolinksViewDashboard extends JViewLegacy {

        /**
         * Display dashboard
         * @param string $tpl
         */
        public function display($tpl = null) {
            $items = $this->get('Items');
            $list = array();
            foreach ($items as $item) {
                $list[] = new ZtautolinksItem($item);
            }
            $this->state = $this->get('State');
            $this->items = $list;
            $this->pagination = $this->get('Pagination');
            $this->_displayToolbar();
            parent::display($tpl);
        }

        /**
         * Display toolbar
         */
        protected function _displayToolbar() {
            JToolbarHelper::title(JText::_('COM_ZTAUTOLINKS'));
            JToolBarHelper::addNew('item.add');
            JToolbarHelper::publish('dashboard.publish');
            JToolbarHelper::unpublish('dashboard.unpublish');
            JToolBarHelper::deleteList(JText::_('COM_ZTAUTOLINKS_REMOVE_ITEMS_CONFIRM'), 'dashboard.delete');
        }

    }

}