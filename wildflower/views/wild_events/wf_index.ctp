<h2><?php __('Events');?></h2>
<?php
	if ($session->check('Message.flash')) {
        $session->flash();
    }
	 
	echo $calendar->calendar($year, $month, $data, $base_url, true);
?>

<?php $partialLayout->blockStart('sidebar'); ?>
    <li><?php echo $html->link(
        '<span>' . __('Add a new event', true) . '</span>',
        array('action' => 'wf_create'),
        array('class' => 'add', 'escape' => false)); ?>
    </li> 
<?php $partialLayout->blockEnd(); ?> 