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
if (!class_exists('ZtautolinksViewItem')) {

    /**
     * Item controller
     */
    class ZtautolinksViewItem extends JViewLegacy {

        /**
         * Display item
         * @param string $tpl
         */
        public function display($tpl = null) {
            /* Set view variables */
            $this->form = $this->get('Form');
            $this->item = $this->get('Item');
            $this->state = $this->get('State');
            /* Display toolbar */
            $this->_displayToolbar();
            parent::display($tpl);
        }

        /**
         * Display toolbar
         */
        protected function _displayToolbar() {
            JFactory::getApplication()->input->set('hidemainmenu', true);
            JToolbarHelper::title(JText::_('COM_ZTAUTOLINKS'));
            JToolBarHelper::apply('item.apply');
            JToolBarHelper::save('item.save');
            JToolBarHelper::save2new('item.save2new');
            JToolBarHelper::cancel('item.cancel');
        }

    }

}