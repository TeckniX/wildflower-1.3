<div class="submit" id="save-preview">
    <input type="submit" value="<?php __('Preview'); ?>" />
</div>

<?php if ($isDraft): ?>    
    
<div class="submit" id="save-draft">
    <input type="submit" value="<?php __('Save, but don\'t publish'); ?>" name="data[__save][draft]" />
</div>

<div class="submit" id="save-publish">
    <input type="submit" value="<?php __('Publish'); ?>" name="data[__save][publish]" />
</div>

<?php else: ?>
    
<div class="submit" id="save-draft">
    <input type="submit" value="<?php __('Save as the newest version'); ?>" />
    <?php 
        if ($this->params['controller'] == 'pages') {
            $entityUrl = $this->data['Page']['url'];
            $entity = 'page';
        } else if ($this->params['controller'] == 'posts') {
            $entityUrl = '/' . Configure::read('Wildflower.postsParent') . '/' . $this->data['Post']['slug'];
            $entity = 'post';
		} else if ($this->params['controller'] == 'wild_events') {
            $entityUrl = '/' . Configure::read('Wildflower.eventsParent') . '/' . $this->data['WildEvent']['slug'];
            $entity = 'events';
        }
        echo $html->link("View this $entity", $entityUrl, array('class' => 'editor_view_link')); 
    ?>
</div>

<?php endif; ?>