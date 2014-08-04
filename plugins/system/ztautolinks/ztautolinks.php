<?php

/**
 * ZAuto Links
 * @package Joomla.Plugin
 * @subpackage system_ztautolink
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

/**
 * Class exists checking
 */
if (!class_exists('plgSystemZtAutolinks')) {
    jimport('joomla.plugin.plugin');

    /**
     * Plugin entrypoint
     */
    class plgSystemZtAutolinks extends JPlugin {

        private $_buffer = null;

        /**
         * DOMDocument
         * @var object
         */
        private $_dom = null;
        private $_list = array();

        /**
         * Construction
         * @param type $subject
         * @param array $config
         */
        public function __construct(&$subject, $config = array()) {
            parent::__construct($subject, $config);
        }

        /**
         * Check if Zt Autolinks component is installed & enabled
         * @return boolean
         */
        private function _isComponentEnabled() {
            $db = JFactory::getDbo();
            $db->setQuery(' SELECT  ' . $db->quoteName('enabled') . ' FROM ' . $db->quoteName('#__extensions') . ' WHERE ' . $db->quoteName('name') . ' = ' . $db->quote('ztautolinks'));
            return (bool) $db->loadResult();
        }

        /**
         * 
         */
        public function onAfterRender() {
            /**
             * Only process for frontend
             */
            if (JFactory::getApplication()->isSite()) {
                if ($this->_isComponentEnabled()) {
                    /* Load required classes */
                    if (is_file(JPATH_ADMINISTRATOR . '/components/com_ztautolinks/libraries/item.php')) {
                        require_once JPATH_ADMINISTRATOR . '/components/com_ztautolinks/libraries/item.php';
                        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_ztautolinks/models');
                        $this->_execute();
                    }
                }
            }
        }

        /**
         * Primary function
         */
        private function _execute() {
            /* Get body and load into DOMDocument */
            $buffer = JResponse::getBody();
            $this->_dom = new DOMDocument();
            @$this->_dom->loadHtml($buffer);
            $list = $this->_getList();
            foreach ($list as $item) {
                $this->_findAndReplaceKeyword($item);
            }

            /* Save back to Joomla! body */
            JResponse::setBody($this->_dom->saveHTML());
        }

        /**
         * Replace each keyword
         * @param type $item
         */
        private function _findAndReplaceKeyword($item) {
            $nodes = $this->_getNodesList($item);			
            if (( count($nodes) > 0) && $this->_list[trim($item->keyword)] > 0) {
                foreach ($nodes as $node) {
                    $this->_nodeReplace($node, $item);
                }

                $this->_findAndReplaceKeyword($item);
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
                $list[$item->keyword] = new ZtautolinksItem($item);
            }
            return $list;
        }

        /**
         * Process to get list nodes by keyword
         * @param array $list
         * @return array
         */
        private function _getNodesList($item) {
            /* Init nodes array */
            $nodes = array();
            /* Find nodes of keyword */
            $keyword = trim($item->get('keyword'));
            $textNodes = $this->_findNodesOfKeyword($keyword);
            /* Validation */
            if ($textNodes) {
                foreach ($textNodes as $node) {
                    if ($this->_isValidNode($node, $keyword)) {
                        $nodes[] = $node;
                    }
                }
            }
            $totalNodes = count($nodes);
            /* Found nodes */
            if ($totalNodes) {
                /* Update nodes limit by occurrence and limit */
                /* Init limit value of keyword */
                if (!isset($this->_list[$keyword])) {
                    $this->_list[$keyword] = $item->get('limits');
                }
                /* Is not reached limit */
                if ($this->_list[$keyword] > 0) {
                    /* If this keyword founded in nodes */
                    if (count($nodes) > 0) {
                        /* Do ordering node array by occurrence */
                        switch ($item->get('occurrence')) {
                            case 1 : /* top */
                                break;
                            case 2: /* end */
                                $nodes = array_reverse($nodes);
                                break;
                            case 3: /* random */
                                shuffle($nodes);
                                break;
                        }
                        /* Cut node array by count limit */
                        if ($this->_list[$keyword] == 0) {
                            
                        } else {
                            if (count($nodes) > $this->_list[$keyword]) {
                                $nodes = array_slice($nodes, 0, $this->_list[$keyword]);
                            }
                        }
                    }
                }
            }
            return $nodes;
        }

        /**
         * Find nodes with keyword
         * @param string $keyword
         * @return array
         */
        private function _findNodesOfKeyword($keyword) {
            $xpath = new DOMXpath($this->_dom);
            /**
             * Only catch from body
             * @uses This process only filter text() with keyword. We'll need do more check later to get exactly needed keyword
             */
            $query = '/html/body//text()[contains(.,"' . $keyword . '")]';
            $textNodes = $xpath->query($query);
            return $textNodes;
        }

        /**
         * Check to make sure this valid node that we want to use
         * @param object $node
         * @return boolean
         */
        private function _isValidNode($node, $keyword) {
            $value = $node->nodeValue;
            /* Do find exactly "keyword" in this text */
            $pattern = '/([!|(|){|}|;|\'|,|.|?|:|"|[|\]|\s|])(' . $keyword . ')([!|(|){|}|;|\'|,|.|?|:|"|[|\]|\s])/';
            $return = preg_match_all($pattern, $value, $matches);
            if ($return !== false) {
                if ($return > 0) {
                    /* Make sure it's not under a tag */
                    if ($node->nodeName != 'a') {
                        $parentNode = $node->parentNode;
                        if ($parentNode) {
                            return $parentNode->nodeName != 'a';
                        } else {
                            return true;
                        }
                    }
                }
            }
            return false;
        }

        /**
         * Process to replace each node
         * @param object $node
         * @param object $item
         * @return \plgSystemZtAutolinks
         */
        private function _nodeReplace($node, $item) {
            $keyword = trim($item->get('keyword'));

            $pattern = '~\b' . $keyword . '\b~';

            /* Make wrapper for this keyword */
            $keyword = '<ztautolinks>' . $keyword . '</ztautolinks>';
            $text = preg_replace($pattern, $keyword, $node->nodeValue);

            /* Find keyword in this text */
            while (($pos = strpos($text, $keyword)) !== false) {

                /* Create fragment that will use to insert into document */
                $fragment = $this->_dom->createDocumentFragment();
                $fragment->appendChild(new DOMText(substr($text, 0, $pos)));

                /* Create new DOM Node with real keyword */
                $word = substr($text, $pos, strlen($keyword));
                $rWord = str_replace('<ztautolinks>', '', $word);
                $rWord = str_replace('</ztautolinks>', '', $rWord);

                /* Make wrapper */
                $highlight = $this->_dom->createElement($item->params->get('tag', 'a'));
                $highlight->appendChild(new DOMText($rWord));

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

                /* Replace wrapper */
                $text = substr($text, $pos + strlen($keyword));
                $text = str_replace('<ztautolinks>', '', $text);
                $text = str_replace('</ztautolinks>', '', $text);

                if (!empty($text)) {
                    $fragment->appendChild(new DOMText($text));
                } else {
                    
                }

                if (is_object($node->parentNode)) {
                    $node->parentNode->replaceChild($fragment, $node);
					$this->_list[trim($item->get('keyword'))]--;
                } else {
                    
                }
            }
            return $this;
        }

    }

}
