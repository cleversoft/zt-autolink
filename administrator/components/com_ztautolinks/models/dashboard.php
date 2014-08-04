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
if (!class_exists('ZtautolinksModelDashboard')) {
    jimport('joomla.application.component.modellist');

    /**
     * Dashboard model class
     */
    class ZtautolinksModelDashboard extends JModelList {

        /**
         * Build query to get items
         * @return string
         */
        protected function _buildQuery($options = array()) {
            $db = JFactory::getDbo();
            $query['SELECT'][] = 'i.*';
            $query['FROM'] = $db->quoteName('#__ztautolinks') . ' AS i';

            if (isset($options['WHERE'])) {
                foreach ($options['WHERE'] as $where) {
                    $query['WHERE'][] = $where;
                }
            }
            $query['ORDER BY'][] = 'i.' . $db->quoteName('priority') . ' DESC';
            $query['ORDER BY'][] = 'i.' . $db->quoteName('count') . ' DESC';
            /**
             * Now we are ready to build query
             */
            $sql = '';
            foreach ($query as $key => $item) {
                if (is_array($item)) {
                    if ($key == 'WHERE') {
                        $sql .= $key . ' ' . implode(' AND ', $item);
                    } else {
                        $sql .= $key . ' ' . implode(' , ', $item);
                    }
                } else {
                    $sql .= $key . ' ' . $item;
                }
                $sql .= ' ';
            }
            return $sql;
        }

        /**
         * Override parent method to call _buildQuery
         * @return string
         */
        protected function _getListQuery() {
            return $this->_buildQuery();
        }

        /**
         * Change published status
         * @param string $items
         * @param integer $value
         * @return boolean
         */
        public function publish($items, $value = 1) {
            $db = JFactory::getDbo();
            $query = ' UPDATE ' . $db->quoteName('#__ztautolinks');
            $query .= ' SET ' . $db->quoteName('published') . '=' . (int) $value;
            $query .= ' WHERE ' . $db->quoteName('id') . ' IN ( ' . implode(',', $items) . ' ) ';
            $db->setQuery($query);
            return $db->execute();
        }

        /**
         * Delete array of items
         * @param type $items
         * @return type
         */
        public function delete($items) {
            $db = JFactory::getDbo();
            $query = ' DELETE FROM ' . $db->quoteName('#__ztautolinks');
            $query .= ' WHERE ' . $db->quoteName('id') . ' IN ( ' . implode(',', $items) . ' ) ';
            $db->setQuery($query);
            return $db->execute();
        }

        public function plgGetItems() {
            $db = JFactory::getDbo();
            $options['WHERE'][] = 'i.' . $db->quoteName('published') . ' = ' . (int) 1;
            $query = $this->_buildQuery($options);
            $db->setQuery($query);
            return $db->loadObjectList();
        }

    }

}