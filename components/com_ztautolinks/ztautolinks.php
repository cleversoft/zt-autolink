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

/* Register tables directory */
JTable::addIncludePath(__DIR__ . '/tables');
/* Register autoloading for ZtautolinksItem */
JLoader::register('Ztautolinks', JPATH_COMPONENT_ADMINISTRATOR . '/libraries/item.php');

/* Controller process */
$jinput = JFactory::getApplication()->input;
$controller = JControllerLegacy::getInstance('Ztautolinks');
$controller->execute($jinput->getCmd('task'));
$controller->redirect();