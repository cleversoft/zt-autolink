<?php

/**
 * ZT Autolinks
 * @package Joomla.Component
 * @subpackage com_ztautolinks
 * @version 0.5.7
 *
 * @copyright (C) 2011 - 2013 by JOOservices Ltd - All rights reserved!
 * @license GNU/GPL, see LICENSE.php
 * @link 
 * @link http://crefly.com - http://crefly.com/support
 * @link http://joooservices.com
 *
 */
defined('_JEXEC') or die;

if (!class_exists('ZtalModelItems')) {
    jimport('joomla.application.component.modellist');

    class ZtalModelItems extends JModelList {

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
         * Redirect to _buildQuery
         * @return type
         */
        protected function getListQuery() {
            return $this->_buildQuery();
        }

        /**
         * Get items list
         * @return \ZtalItem
         */
        public function getItems() {
            $db = JFactory::getDbo();
            $filter['WHERE'][] = 'i.' . $db->quoteName('published') . ' = 1';
            $db->setQuery($this->_buildQuery($filter));
            $result = $db->loadObjectList();
            $list = array();
            if ($result) {
                foreach ($result as $item) {
                    $list[] = new ZtalItem($item);
                }
            }
            return $list;
        }
        
        /**
         * Get all items
         * @return \ZtalItem
         */
        public function getAllItems() {
            $db = JFactory::getDbo();
            $db->setQuery($this->_buildQuery());
            $result = $db->loadObjectList();
            $list = array();
            if ($result) {
                foreach ($result as $item) {
                    $list[] = new ZtalItem($item);
                }
            }
            return $list;
        }
        
        /**
         * Get item by id
         * @param integer $id
         * @return \ZtalItem
         */
        public function getItem($id) {
            $db = JFactory::getDbo();
            $query = ' SELECT * FROM ' . $db->quoteName('#__ztautolinks');
            $query .= ' WHERE ' . $db->quoteName('id') . '=' . (int) $id;
            $db->setQuery($query);
            $item = $db->loadObject();
            if ($item) {
                return new ZtalItem($item);
            } else {
                return new ZtalItem ();
            }
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

    }

}