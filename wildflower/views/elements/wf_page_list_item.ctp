<div class="actions-handle">
	<div class="nubbin">
    	<div class="row-actions">
    	<ul>
    		<li class="delete"><?php echo $html->link($html->image('trash.gif', array('alt' => 'trash')), array('action' => 'delete'), array('escape' => false)); ?></li>
			<li class="edit"><?php echo $html->link('View', $data['WildPage']['url'], array('class' => '', 'rel' => 'permalink', 'title' => 'View this page.')) ?></li>
			<li class="move"><?php echo $html->image('drag_handle.gif', array('alt' => 'trash', 'css'=>'drag_handle')); ?></li>
    	</ul>
		</div>
	</div>
    <span class="row-check"><?php echo $form->checkbox('id.' . $data['WildPage']['id']) ?></span>
    <?php
        $tree->addItemAttribute('id', 'page-' . $data['WildPage']['id']);
        $tree->addItemAttribute('class', 'level-' . $depth);
        if (ListHelper::isOdd()) {
            $tree->addItemAttribute('class', 'odd');
        }
        
        // Draft status        
        if ($data['WildPage']['draft']) {
            echo '<small class="draft-status">(', __('Draft', true), ')</small> ';
        }
    
        echo $html->link($data['WildPage']['title'], array('action' => 'edit', $data['WildPage']['id']), array('title' => 'Edit this page.')); 
    ?>
    <span class="cleaner"></span>
</div>