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

JHtml::_('behavior.multiselect');
?>

<form action="index.php?option=com_ztautolinks&view=dashboard" method="post" name="adminForm" id="adminForm">

    <table class="adminlist table table-hover">
        <thead>
            <tr>
                <th width="1%">
                    <?php echo JText::_('COM_ZTAUTOLINKS_ID'); ?>
                </th>
                <th class="center">
                    <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_KEYWORD'); ?>
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_LINK'); ?>
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_LIMIT'); ?>
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_OCCURRENCE'); ?>
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_PRIORITY'); ?>
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_COUNT'); ?>
                </th>
                <th class="title">
                    <?php echo JText::_('COM_ZTAUTOLINKS_PUBLISHED'); ?>
                </th>
            </tr>
        </thead>
        <tbody>  
            <!-- Items list -->
            <?php if (isset($this->items) && is_array($this->items)) : ?>
                <?php foreach ($this->items as $key => $item): ?>                   
                    <tr class="row<?php echo $key % 2; ?>">
                        <!-- ID -->
                        <td>
                            <?php echo $item->id; ?>
                        </td>
                        <!-- Checkbox -->
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $key, $item->id); ?>
                        </td>
                        <!-- Keyword -->
                        <td>
                            <strong><a href="<?php echo $item->getEditLink(); ?>"><?php echo $item->keyword; ?></a></strong>
                        </td>
                        <!-- Link -->
                        <td>       
                            <div class="">
                                <a href="<?php echo $item->getRedirectLink(); ?>" target="_blank"><?php echo $item->link; ?></a>                            
                                <?php if (!$item->isInternal()) : ?>
                                    <small style="text-align: right; ">External</small>
                                <?php endif ?>
                            </div>

                        </td>
                        <!-- Limits -->
                        <td class="center">
                            <?php echo $item->limits; ?>
                        </td>
                        <!-- Occurrence -->
                        <td class="center">
                            <?php echo $item->getOccurrenceText(); ?>
                        </td>
                        <td class="center">
                            <?php echo $item->priority;
                            ?>
                        </td>
                        <td class="center">
                            <?php echo $item->count; ?>
                        </td>
                        <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->published, $key, 'dashboard.'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot></tfoot>
    </table>

    <?php if (count($this->items) > 0) : ?>
        <div class="pagination">
            <?php echo $this->pagination->getListFooter(); ?>
            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    <?php endif; ?>        

    <input type="hidden" name="task" value="" />     
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>

</form>