<?php 
    echo 
    $form->create('WildEvent', array('url' => $html->url(array('action' => 'update', 'base' => false)), 'class' => 'horizontal-form')),
    '<div>',
    $form->hidden('id'),
	$form->hidden('title'),
    '</div>';
?>

<h2 class="section">Event Thumbnail</h2>
<?php
	if (empty($images)):?>
       	 	<p>No files uploaded yet.</p>
    	<?php else: ?>

	        <ul class="file-list list">
	        <?php foreach ($images as $file): 
				$largeImage = WildAsset::getUploadUrl($file['WildAsset']['name']);
				if(!empty($this->data['WildEvent']['thumbnail']) and $this->data['WildEvent']['thumbnail'] == $largeImage):
					$css = ' selected';
				else:
					$css = '';
				endif;
				?>
	            <li id="file-<?php echo $file['WildAsset']['id']; ?>" class="actions-handle<?=$css?>">
	
	        	    <img class="thumbnail" width="50" height="50" src="<?php echo $html->url("/wildflower/thumbnail/{$file['WildAsset']['name']}/50/50/1"); ?>" alt="<?php echo $file['WildAsset']['name']; ?>" />
	
	                <h3><?php echo hsc($file['WildAsset']['name']); ?></h3>
					
	                <span class="imgUrl"><?= $largeImage ?></span>
	
	                <span class="cleaner"></span>
	            </li>
	
	        <?php endforeach; ?>
	        </ul>
<?php 
			echo $this->element('wf_pagination'); 
		endif; 
    echo 
	$form->input('WildEvent.thumbnail', array('type'=>'hidden', 'label' => 'Thumbnail', 'size' => 61));
?>

<div id="edit-buttons">
    <div class="submit save-section">
        <input type="submit" value="<?php __('Save Thumbnail'); ?>" />
    </div>
    <div class="cancel-edit"> <?php __('or'); ?> <?php echo $html->link(__('Cancel and go back to event edit', true), array('action' => 'edit', $this->data['WildEvent']['id'])); ?></div>
</div>

<?php echo $form->end(); ?>

<?php $partialLayout->blockStart('sidebar'); ?>
    <li class="sidebar-box">
        <h4>Editing thumbnail for event...</h4>
        <?php echo $html->link($this->data['WildEvent']['title'], array('action' => 'edit', $this->data['WildEvent']['id']), array('class' => 'edited-item-link')); ?>
    </li>
<?php $partialLayout->blockEnd(); ?>

<script type="text/javascript">
    $('li.actions-handle').click(function() {
	   $('li.selected').removeClass('selected');
	   $(this).addClass('selected');
	   $('#WildEventThumbnail').val($(this).children('span.imgUrl').html());
	    return false;
	});
	$('li.actions-handle').hover (function() {
              $(this).addClass('hover');
            },
        function(){
              $(this).removeClass('hover');
            }
    );
	$('.paginator').after('<a href="#" id="remove">Remove Thumb</a>');
	$('#remove').click(function(){
		$('li.selected').removeClass('selected');
		$('#WildEventThumbnail').val('');
	});
</script>