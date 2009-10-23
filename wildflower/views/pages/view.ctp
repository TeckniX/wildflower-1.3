<?php
/**
 * Wildflower generic page template.
 *
 * @package wildflower
 */
?>
<div class="page">
<<<<<<< HEAD:app/views/themed/wildflower/wild_pages/view.ctp
    <h2><?php echo $page['WildPage']['title']; ?></h2>
    <div id="contentLeft">
    	<?php echo $this->element('sub_nav', array('id' => $page['WildPage']['id'])); ?>
	</div>
    <div id="contentRight">
        <?php echo $wild->processWidgets($page['WildPage']['content']); ?>
=======
    <h2><?php echo $page['Page']['title']; ?></h2>
    
    <div class="entry">
       <?php echo $wild->processWidgets($page['Page']['content']); ?>
>>>>>>> 853920ce542235a426a12ae3ae2e697a80080143:wildflower/views/pages/view.ctp
    </div>
    
    <?php echo $this->element('edit_this', array('id' => $page['Page']['id'])) ?>
</div>

