<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

/**
 * Supports a modal article picker.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_content
 * @since       1.6
 */
class JFormFieldModal_Article extends JFormField {

    /**
     * The form field type.
     *
     * @var		string
     * @since   1.6
     */
    protected $type = 'Modal_Article';

    /**
     * Method to get the field input markup.
     *
     * @return  string	The field input markup.
     * @since   1.6
     */
    protected function getInput() {

        // Load language
        JFactory::getLanguage()->load('com_content', JPATH_ADMINISTRATOR);

        // Load the modal behavior script.
        JHtml::_('behavior.modal', 'a.modal');

        // Build the script.
        $script = array();

        // Select button script
        $script[] = '	function jSelectArticle_' . $this->id . '(id, title, catid, object, link, lang) {';
        $script[] = '		document.getElementById("jform_link").value = "' . JUri::root() . '" + link';        
        $script[] = '		SqueezeBox.close();';
        $script[] = '	}';

        // Add the script to the document head.
        JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

        // Setup variables for display.
        $html = array();
        $link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticle_' . $this->id;

        if (isset($this->element['language'])) {
            $link .= '&amp;forcedLanguage=' . $this->element['language'];
        }

        if ((int) $this->value > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                    ->select($db->quoteName('title'))
                    ->from($db->quoteName('#__content'))
                    ->where($db->quoteName('id') . ' = ' . (int) $this->value);
            $db->setQuery($query);

            try {
                $title = $db->loadResult();
            } catch (RuntimeException $e) {
                JError::raiseWarning(500, $e->getMessage());
            }
        }

        if (empty($title)) {
            $title = JText::_('COM_CONTENT_SELECT_AN_ARTICLE');
        }
        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        // The active article id field.
        if (0 == (int) $this->value) {
            $value = '';
        } else {
            $value = (int) $this->value;
        }

        // The current article display field.

        $html[] = '<a class="modal btn hasTooltip" title="' . JText::_('COM_CONTENT_CHANGE_ARTICLE') . '"  href="' . $link . '&amp;' . JSession::getFormToken() . '=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}" style="float:left;"><i class="icon-file"></i> ' . JText::_('COM_ZTAUTOLINKS_SELECT_JOOMLA_ARTICLE') . '</a>';

        return implode("\n", $html);
    }

}
