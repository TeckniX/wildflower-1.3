<?php
/**
 * Wildflower generic page template.
 *
 * @package wildflower
 */
?>
<div class="page">
    <h2><?php echo $page['WildPage']['title']; ?></h2>
    <div id="contentLeft">
    	<?php echo $this->element('sub_nav', array('id' => $page['WildPage']['id'])); ?>
	</div>
    <div id="contentRight">
        <?php echo $wild->processWidgets($page['WildPage']['content']); ?>
    </div>
    
    <?php echo $this->element('edit_this', array('id' => $page['WildPage']['id'])) ?>
</div>
