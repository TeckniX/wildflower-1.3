<h2 class="section"><?php __('Add a new event'); ?></h2>
<?php
	echo
	    $form->create('WildEvent', array('url' => $here, 'class' => 'horizontal-form')),
	    $form->input('title', array('label' => 'Event title', 'size' => 61)),
		$form->input('created', array('label' => 'Event date')),
	    $form->input('content', array('class' => 'tinymce', 'rows'=>20));
?>

<div class="horizontal-form-buttons">
    <div class="submit wf-form-button">
        <input type="submit" value="<?php __('Create event'); ?>" />
    </div>
    <div class="cancel-edit"> <?php __('or'); ?> <?php echo $html->link(__('Cancel', true), array('action' => 'index')); ?></div>
</div>

<?php 
    echo 
    $form->end();
?>

<?php $partialLayout->blockStart('sidebar'); ?>
    <li class="main_sidebar">
        <ul class="sidebar-menu-alt edit-sections-menu">
            <li><?php echo $html->link('Event thumbnail ', array('action' => 'thumb', $this->data['WildEvent']['id']), array('escape' => false)); ?></li>
            <li><?php echo $html->link('Browse older versions', '#Revisions', array('rel' => 'events-revisions')); ?></li>
        </ul>
    </li>
<?php $partialLayout->blockEnd(); ?>