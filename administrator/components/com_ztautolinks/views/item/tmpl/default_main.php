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
<!-- Keyword -->
<div class="control-group">
    <label class="control-label" for="inputKeyword" >Keyword</label>
    <div class="controls">
        <input type="text" id="inputKeyword" name="jform[keyword]" placeholder="Keyword" value="<?php echo $this->item->get('keyword'); ?>">
        <div clas="">
            <small>Enter your keyword that will use for replace</small>
        </div>
    </div>                    
</div>
<!-- Link -->
<div class="control-group">
    <label class="control-label" for="inputLink">Link</label>
    <div class="controls">
        <label class="radio">
            <input type="radio" name="jform[isInternal]" id="isInternal1" value="1" <?php echo ($this->item->get('isInternal', 0) == 1) ? 'checked' : '' ?> >           
            Joomla! Component item
            <small>Choose item at right panel</small>           
        </label>
        <label class="radio">
            <input type="radio" name="jform[isInternal]" id="isInternal0" value="0" <?php echo ($this->item->get('isInternal', 0) == 0) ? 'checked' : '' ?>>
            Custom URL
        </label>
        <input type="text" id="inputLink" name="jform[link]" placeholder="Link" value="<?php echo $this->item->get('link', 'http://zootemplate.com'); ?>">
        <input type="hidden" id="inputLinkInternal" name="jform[linkInternal]" value="<?php echo $this->item->get('link', ''); ?>">
        <div clas="">
            <small>Enter your link</small>
        </div>
    </div>
</div>
<!-- Count -->
<div class="control-group">
    <label class="control-label" for="inputLimits">Limits</label>
    <div class="controls">
        <input type="text" id="inputLink" name="jform[limits]" placeholder="Limit" value="<?php echo $this->item->get('limits', 1); ?>">
        <div clas="">
            <small>Limit number instance of keyword will be replaced</small>
        </div>
    </div>
</div>
<!-- Occurrence -->
<div class="control-group">
    <label class="control-label" for="inputOccurrence">Occurrence</label>
    <div class="controls">
        <select id="inputOccurrence" name="jform[occurrence]">           
            <option value="1" <?php echo ((int) $this->item->get('occurrence') == 1) ? 'selected' : ''; ?> >Top</option>
            <option value="2" <?php echo ((int) $this->item->get('occurrence') == 2) ? 'selected' : ''; ?> >End</option>                            
            <option value="3" <?php echo ((int) $this->item->get('occurrence') == 3) ? 'selected' : ''; ?> >Random</option>
        </select>
        <div clas="">
            <small>Which keyword in array list will be replaced</small>
        </div>
    </div>
</div>
<!-- Priority -->
<div class="control-group">
    <label class="control-label" for="inputPriority">Priority</label>
    <div class="controls">
        <input type="text" id="inputPriority" name="jform[priority]" placeholder="Priority" value="<?php echo $this->item->get('priority', 1); ?>">
        <div clas="">
            <small>Lower number will be higher</small>
        </div>
    </div>
</div>   
<script>
    jQuery(document).ready(function() {
        jQuery("#isInternal1").change(function() {
            if (jQuery(this).attr("checked")) {
                jQuery('#inputLink').prop('disabled', true);
            } else {
                jQuery('#inputLink').prop('disabled', false);
            }
        })
        jQuery("#isInternal0").change(function() {
            if (jQuery(this).attr("checked")) {
                jQuery('#inputLink').prop('disabled', false);
            } else {
                jQuery('#inputLink').prop('disabled', true);
            }
        })
    })
</script>