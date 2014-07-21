<?php
/**
 * ZAuto Links
 * @package Joomla.Component
 * @subpackage com_zautolinks
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
?>
<?php if (isset($this->items) && is_array($this->items)) : ?>
    <?php foreach ($this->items as $key => $item): ?>
        <tr class="row<?php echo $key % 2; ?>">
            <!-- ID -->
            <td>
                <?php echo $item->id; ?>
            </td>
            <!-- Checkbox -->
            <td>
                <?php echo JHtml::_('grid.id', $key, $item->id); ?>
            </td>
            <!-- Keyword -->
            <td>
                <a href="<?php echo JRoute::_('index.php?option=com_ztautolinks&view=item&id=' . $item->id); ?>"><?php echo $item->keyword; ?></a>
            </td>
            <!-- Link -->
            <td>           
                <?php if (filter_var($item->get('link'), FILTER_VALIDATE_URL)) { ?>
                    <a href="<?php echo $item->get('link'); ?>" target="_blank"><?php echo $item->get('link'); ?></a> 
                <?php } else { ?>
                    <a href="<?php echo JUri::root() . $item->get('link'); ?>" target="_blank"><?php echo $item->get('link'); ?></a> 
                <?php } ?>                    
            </td>
            <!-- Limits -->
            <td>
                <?php echo $item->limits; ?>
            </td>
            <td>
                <?php
                switch ($item->occurrence) {
                    case 1:
                        echo 'Top';
                        break;
                    case 2:
                        echo 'End';
                        break;
                    case 3:
                        echo 'Random';
                        break;
                }
                ?>
            </td>
            <td>
                <?php echo $item->priority;
                ?>
            </td>
            <td>
                <?php echo $item->count; ?>
            </td>
            <td>
                <?php echo $item->published; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>