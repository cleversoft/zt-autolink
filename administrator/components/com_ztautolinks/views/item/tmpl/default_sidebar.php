<div class="row-fluid">
    <div class="span12">
        <div class="control-group">                
            <div class="controls">
                <label class="control-label" for="inputPublished" >Published</label>
                <select name="jform[published]">
                    <option value="1" <?php ($this->item->get('published', 1) == 1) ? 'selected' : ''; ?> >Yes</option>
                    <option value="0" <?php ($this->item->get('published', 1) == 0) ? 'selected' : ''; ?> >No</option>                
                </select>
            </div>
        </div>
    </div>    
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well well-small">                            
            <!-- Tag -->
            <div class="control-group">
                <label class="control-label" for="inputTag" >Tag</label>
                <div class="controls">
                    <input type="text" id="inputTag" name="jform[params][tag]" placeholder="Tag" value="<?php echo $this->item->params->get('tag', 'a'); ?>">
                    <div clas="">
                        <small>Which tag will be use</small>
                    </div>
                </div>       
            </div>
            <!-- Title -->
            <div class="control-group">
                <label class="control-label" for="inputTitle" >Title</label>
                <div class="controls">
                    <input type="text" id="inputTitle" name="jform[params][title]" placeholder="Title" value="<?php echo $this->item->params->get('title', $this->item->get('keyword')); ?>">
                    <div clas="">
                        <small>Which tag will be use</small>
                    </div>
                </div>       
            </div>
            <!-- Class -->
            <div class="control-group">
                <label class="control-label" for="inputClass" >Class</label>
                <div class="controls">
                    <input type="text" id="inputClass" name="jform[params][class]" placeholder="Class" value="<?php echo $this->item->params->get('class', 'ztautolinks'); ?>">
                    <div clas="">
                        <small>Element classname</small>
                    </div>
                </div>                    
            </div>            
            <!-- Redirect Link -->
            <div class="control-group">
                <label class="control-label" for="inputRedirectlink" >Redirect link</label>
                <div class="controls">
                    <select id="inputRedirectlink" name="jform[params][redirectLink]">
                        <option value="1" <?php echo ($this->item->params->get('redirectLink', 1) == 1) ? 'selected' : ''; ?> >Yes</option>
                        <option value="0" <?php echo ($this->item->params->get('redirectLink', 1) == 0) ? 'selected' : ''; ?>>No</option>                
                    </select>
                    <div clas="">
                        <small>Use internal redirect link</small>
                    </div>
                </div>                    
            </div>                           
            <!-- Follow -->
            <div class="control-group">
                <label class="control-label" for="inputFollow" >Follow</label>
                <div class="controls">
                    <select name="jform[params][follow]">
                        <option value="1" <?php echo ($this->item->params->get('follow', 1) == 1) ? 'selected' : ''; ?> >Yes</option>
                        <option value="0" <?php echo ($this->item->params->get('follow', 1) == 0) ? 'selected' : ''; ?>>No</option>                
                    </select>
                    <div clas="">
                        <small>Follow or noFollow for a link</small>
                    </div>
                </div>                    
            </div>
            <!-- Rel -->
            <div class="control-group">
                <label class="control-label" for="inputRel" >Target</label>
                <div class="controls">
                    <input type="text" id="inputRel" name="jform[params][target]" placeholder="Target" value="<?php echo $this->item->params->get('rel', '_blank'); ?>">
                    <div clas="">
                        <small></small>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 well well-small">
            <?php foreach ($this->form->getFieldsets("params") as $fieldsets => $fieldset): ?>                                    
                <fieldset class="panelform">
                    <dl>
                        <?php foreach ($this->form->getFieldset($fieldset->name) as $field): ?>
                            <?php if ($field->hidden) : ?>
                                <?php echo $field->input; ?>
                            <?php else: ?>
                                <dt>
                                <?php echo JText::_($field->label); ?>
                                </dt>
                                <dd>
                                    <?php echo $field->input; ?>
                                </dd>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    </dl>
                </fieldset>
            <?php endforeach; ?>
        </div>
    </div>
</div>