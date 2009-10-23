<div id="primary-content">

    <?php
        $cssClasses = array('post');
        if (isset($this->params['ChangeIndicator'])) {
            $changedId = $this->params['ChangeIndicator']['id'];
            if ($changedId == $post['Post']['id']) {
                array_push($cssClasses, 'changed');
                unset($this->params['ChangeIndicator']);
            }
        }
    ?>

    <?php foreach ($posts as $post) { ?>
    <div class="<?php echo join(' ', $cssClasses) ?>" id="post-<?php echo $post['Post']['id'] ?>">
        <h2><?php echo $html->link($post['Post']['title'], Post::getUrl($post['Post']['slug'])); ?></h2>
        <small class="post-date">Posted <?php echo $time->nice($post['Post']['created']) ?></small>
        
<<<<<<< HEAD:wildflower/views/wild_posts/index.ctp
        <div class="entry">
        	<?php echo $html->image('/wildflower/thumbnail/'. end(explode('/',$post['WildPost']['thumbnail'])).'/100/1000', array('style'=>'text-align: right')); ?>
        	<?php echo $wild->processWidgets($post['WildPost']['content']); ?></div>
=======
        <div class="entry"><?php echo $wild->processWidgets($post['Post']['content']); ?></div>
>>>>>>> 853920ce542235a426a12ae3ae2e697a80080143:wildflower/views/posts/index.ctp
        
        <?php if (!empty($post['Category'])): ?>
        <p class="postmeta">Posted in <?php echo $category->getList($post['Category']); ?>.</p>
        <?php endif; ?>
        
        <?php echo $this->element('edit_this', array('id' => $post['Post']['id'])); ?>
        
    </div>
    <?php } ?>
    
    <?php echo $this->element('admin_pagination') ?>
    
</div>
