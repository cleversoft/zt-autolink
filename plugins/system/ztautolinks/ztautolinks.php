<?php

/**
 * ZAuto Links
 * @package Joomla.Plugin
 * @subpackage system_ztautolink
 * @version 0.5.5
 *
 * @copyright (C) 2011 - 2013 by JOOservices Ltd - All rights reserved!
 * @license GNU/GPL, see LICENSE.php
 * @link 
 * @link http://crefly.com - http://crefly.com/support
 * @link http://joooservices.com
 *
 */
defined('_JEXEC') or die;

/**
 * Class exists checking
 */
if (!class_exists('plgSystemZtAutolinks')) {
    jimport('joomla.plugin.plugin');

    /**
     * Plugin entrypoint
     */
    class plgSystemZtAutolinks extends JPlugin {

        /**
         * DOMDocument
         * @var object
         */
        private $_dom = null;

        /**
         * Construction
         * @param type $subject
         * @param array $config
         */
        public function __construct(&$subject, $config = array()) {
            parent::__construct($subject, $config);
            /* Load required classes */
            if (is_file(JPATH_ADMINISTRATOR . '/components/com_ztautolinks/libraries/item.php')) {
                require_once JPATH_ADMINISTRATOR . '/components/com_ztautolinks/libraries/item.php';
                JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_ztautolinks/models');
            }
        }

        /**
         * 
         */
        public function onAfterRender() {
            /**
             * Only process for frontend
             */
            if (JFactory::getApplication()->isSite()) {
                /* Get body and load into DOMDocument */
                $buffer = JResponse::getBody();
                $this->_dom = new DOMDocument();
                @$this->_dom->loadHtml($buffer);
                /* Process */
                $this->_findAndReplaceKeywords();
                /* Save back to Joomla! body */
                JResponse::setBody($this->_dom->saveHTML());
            }
        }

        /**
         * Get array of keywords need to process
         * @return type
         */
        private function _getList() {
            /* Get model */
            $model = JModelLegacy::getInstance('Dashboard', 'ZtautolinksModel');
            $items = $model->plgGetItems();
            $list = array();
            /* Put item into ZtautolinksItem object class */
            foreach ($items as $item) {
                $list[] = new ZtautolinksItem($item);
            }
            return $list;
        }

        /**
         * Find nodes with keyword
         * @param string $keyword
         * @return array
         */
        private function _findNodesOfKeyword($keyword) {
            $xpath = new DOMXpath($this->_dom);
            $textNodes = $xpath->query('//text()[contains(.,"' . $keyword . '")]');
            return $textNodes;
        }

        /**
         * Process to get list nodes by keywords
         * @param array $list
         * @return array
         */
        private function _getNodesList($list) {
            $nodes = array();
            foreach ($list as $item) {
                $keyword = $item->get('keyword');
                $textNodes = $this->_findNodesOfKeyword($keyword);
                $index = 0;
                foreach ($textNodes as $node) {
                    if ($this->_isValidNode($node)) {
                        $nodes[$keyword][] = $node;
                    }
                    $index++;
                }
            }
            return $nodes;
        }

        /**
         * Check to make sure this valid node that we want to use
         * @param object $node
         * @return boolean
         */
        private function _isValidNode($node) {
            /* Make sure this node is not under any <a> tag */
            $xpath = $node->getNodePath();
            return (strpos($xpath, '/a') === false && strpos($xpath, 'a/') === false && strpos($xpath, '/a/') === false);
        }

        /**
         * Process to replace each node
         * @param object $node
         * @param object $item
         * @return \plgSystemZtAutolinks
         */
        private function _nodeReplace($node, $item) {
            $keyword = $item->get('keyword');
            $text = $node->nodeValue;

            /* Find keyword in this text */
            while (($pos = strpos($text, $keyword)) !== false) {

                /* Create fragment that will use to insert into document */
                $fragment = $this->_dom->createDocumentFragment();
                $fragment->appendChild(new DOMText(substr($text, 0, $pos)));

                $word = substr($text, $pos, strlen($keyword));

                /* Make wrapper */
                $highlight = $this->_dom->createElement($item->params->get('tag', 'a'));
                $highlight->appendChild(new DOMText($word));

                /* Only for <a> tag */
                if ($item->params->get('tag', 'a') == 'a') {
                    $highlight->setAttribute('href', $item->getRedirectLink());
                    if ($item->params->get('follow'))
                        $highlight->setAttribute('rel', $item->params->get('follow'));
                    if ($item->params->get('target'))
                        $highlight->setAttribute('target', $item->params->get('target'));
                }
                /* General attributes */
                if ($item->params->get('title'))
                    $highlight->setAttribute('title', $item->params->get('title'));
                if ($item->params->get('class'))
                    $highlight->setAttribute('class', $item->params->get('class', 'ztautolink'));
                if ($item->params->get('style'))
                    $highlight->setAttribute('style', $item->params->get('style'));

                $fragment->appendChild($highlight);

                $text = substr($text, $pos + strlen($keyword));

                if (!empty($text)) {
                    $fragment->appendChild(new DOMText($text));
                } else {
                    
                }

                if (is_object($node->parentNode)) {
                    $node->parentNode->replaceChild($fragment, $node);
                } else {
                    
                }
            }
            return $this;
        }

        /**
         * Primary process
         */
        private function _findAndReplaceKeywords() {
            /* Get keywords list */
            $list = $this->_getList();
            /* Get nodes list */
            $nodes = $this->_getNodesList($list);

            /**
             * Do process
             */
            foreach ($list as $item) {
                $keyword = $item->get('keyword');
                /* If this keyword founded in nodes */
                if (isset($nodes[$keyword])) {
                    /* Do ordering node array by occurrence */
                    $node = $nodes[$keyword];
                    switch ($item->get('occurrence')) {
                        case 1 : /* top */
                            break;
                        case 2: /* end */
                            $node = array_reverse($node);
                            break;
                        case 3: /* random */
                            shuffle($node);
                            break;
                    }
                    /* Cut node array by count limit */
                    if (count($node) > $item->get('limits')) {
                        $node = array_slice($node, 0, $item->get('limits'));
                    }
                    /* Do replace */
                    foreach ($node as $wNode) {
                        $this->_nodeReplace($wNode, $item);
                    }
                }
            }
        }

    }

}
