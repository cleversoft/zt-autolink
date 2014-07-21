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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$form = $this->form;
?>
<div id="zautolink">
    <form method="post" action="index.php?option=com_ztautolinks" name="adminForm" id="adminForm" class="form-validate">       

        <!-- main fieldsets -->
        <div class="width-60 fltlft">
            <?php
            foreach ($form->getFieldsets() as $fieldsets => $fieldset):
                if ($fieldset->name !== 'COM_ZTAUTOLINKS_FIELDSET_PARAMETERS') :
                    ?>
                    <fieldset class="adminform">
                        <!-- Fieldset -->
                        <legend>
                            <?php echo JText::_($fieldset->name); ?>
                        </legend>
                        <!-- Fields -->
                        <ul>
                            <?php
                            foreach ($form->getFieldset($fieldset->name) as $field):
                                if ($field->hidden || $field->type == 'Modal_Article'):
                                    echo $field->input;
                                else:
                                    ?>
                                    <li>
                                        <?php echo $field->label; ?>                                  
                                        <?php echo $field->input ?>
                                    </li>

                                <?php
                                endif;
                            endforeach;
                            ?>
                        </ul>
                    </fieldset>
                    <?php
                endif;
            endforeach;
            ?>
        </div>
        <!-- extra fieldsets -->
        <div class="width-40 fltrt">
            <?php
            foreach ($form->getFieldsets('params') as $fieldsets => $fieldset):
                ?>
                <?php echo JHtml::_('sliders.start', 'ztalitem-sliders-' . $this->item->id, array('useCookie' => 1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('COM_ZTAUTOLINKS_FIELDSET_PARAMS'), 'params'); ?>
                <fieldset class="panelform">            
                    <!-- Fields -->
                    <ul class="adminformlist">
                        <?php
                        foreach ($form->getFieldset($fieldset->name) as $field):
                            if ($field->hidden):
                                echo $field->input;
                            else:
                                ?>
                                <li>
                                    <?php echo $field->label; ?>
                                    <?php echo $field->input; ?>
                                </li>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    </ul>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
                <?php
            endforeach;
            ?>
        </div>

        <input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
        <input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />     
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>             

    </form>
</div>
<style type="text/css">
    #zautolink .width-60{
        width: 60%;
    }
    #zautolink .width-40{
        width: 40%;
    }
    .fltlft{
        float: left;
    }
    .fltrt{
        float: right;
    }
    #zautolink fieldset li {
        list-style: none;
        margin: 0;
        padding: 5px;
        clear: both;
    }
    #zautolink .modal.btn{
        margin-left: 145px;
        margin-bottom: 10px;
    }
    fieldset.adminform label{
        min-width: 135px;
        padding: 0 5px 0 0;
        float: left;
        clear: left;
        display: block;
        margin: 5px 0;
    }
    fieldset.adminform fieldset.radio label, fieldset.panelform fieldset.radio label {
        min-width: 60px;
        padding-left: 0;
        padding-right: 10px;
        float: left;
        clear: none;
        width: 40px;
        display: inline;
    }
    fieldset.radio input {
        float: left;
        width: auto;
        margin: 7px 5px 5px 0;
    }
    .radio input[type="radio"], .checkbox input[type="checkbox"]{
        margin-left: -15px;
    }
    fieldset.adminform legend {
        margin: 0;
        padding: 0;
        border: 0;
        width: auto;
        display: inline-block;
    }
    legend {
        color: #146295;
        font-size: 1.182em;
        font-weight: bold;
    }

    fieldset.adminform{
        border: 1px #ccc solid;
        background-color: #fff;
        padding: 5px 17px 17px 17px;
        margin: 10px;
        overflow: hidden;
    }
    .pane-sliders .panel h3 {
        background: #fafafa;
        color: #666;
    }
    .pane-sliders .title {
        margin: 0;
        padding: 2px 2px 2px 5px;
        color: #666;
        cursor: pointer;
    }
    .pane-toggler-down {
        border-bottom: 1px solid #ccc;
        font-size: 1.182em;
    }
    .pane-sliders .panel {
        margin-bottom: 3px;
        border: solid 1px #ccc;
    }
    .pane-sliders {
        margin: 27px 0 0 0;
        position: relative;
    }
    fieldset.panelform label{
        min-width: 145px;
        max-width: 250px;
        padding: 0 5px 0 0;
        float: left;
    }
</style>