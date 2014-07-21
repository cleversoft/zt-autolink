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

/* Permission checking */
if (!JFactory::getUser()->authorise('core.manage', 'com_ztautolinks')) {
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
/* Register tables directory */
JTable::addIncludePath(__DIR__ . '/tables');
/* Register autoloading for ZtautolinksItem */
JLoader::register('ZtautolinksItem', dirname(__FILE__) . '/libraries/item.php');

/* Controller process */
$jinput = JFactory::getApplication()->input;
$controller = JControllerLegacy::getInstance('Ztautolinks');
$controller->execute($jinput->getCmd('task'));
$controller->redirect();