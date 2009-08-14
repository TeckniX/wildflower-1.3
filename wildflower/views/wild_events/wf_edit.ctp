<h2 class="section"><?php __('Edit event'); ?></h2>
<?php
if ($session->check('Message.flash')) {
        $session->flash();
    }

	echo
	    $form->create('WildEvent', array('url' => $html->url(array('action' => 'wf_update', 'base' => false)), 'class' => 'editor_form')),
	    $form->input('title', array('label' => 'Event title', 'size' => 61)),
		$form->input('subtitle', array('label' => 'Event sub-title', 'size' => 61)),
		$form->input('evtdate', array('label' => 'Event date')),
		$form->input('location', array('label' => 'Event location','options' => array('Home'=>'Home', 'Office'=>'Office', 'Other'=>'Other'), 'type' => 'select', 'multiple' => 'checkbox', 'after'=>'<div class="clear"></div>')),
	    $form->input('content', array(
        'type' => 'textarea',
        'class' => 'tinymce fill_screen',
        'rows' => '30',
        'label' => __('Event info', true),
        'div' => array('class' => 'input editor')
   		)),
		$form->hidden('draft'),
		$form->hidden('id');
?>

<div id="edit-buttons">
    <?php echo $this->element('wf_edit_buttons'); ?>
</div>

<?php 
    echo 
    $form->end();
?>

<?php $partialLayout->blockStart('sidebar'); ?>
    <li class="main_sidebar">
        <ul class="sidebar-menu-alt edit-sections-menu">
        	<li><?php echo $html->link('Options <small>like status, friendly url, etc.</small>', array('action' => 'options', $this->data['WildEvent']['id']), array('escape' => false)); ?></li>
            <li><?php echo $html->link('Event thumbnail ', array('action' => 'thumb', $this->data['WildEvent']['id']), array('escape' => false)); ?></li>
            <li><?php echo $html->link('Browse older versions', '#Revisions', array('rel' => 'events-revisions')); ?></li>
			<li style="padding-top: 10px;"><?php echo $html->link($html->image('trash.gif').' Delete event ', array('action' => 'delete', $this->data['WildEvent']['id']), array('escape' => false,'style'=>'text-decoration:none')); ?></li>
        </ul>
    </li>
<?php $partialLayout->blockEnd(); ?>