<?php if (empty($images)): ?>
    <p>No files uploaded yet.</p>
<?php else: ?>
    <ul>
    <?php foreach ($images as $image): ?>
        <li>
            <img alt="<?php echo $image['WildAsset']['name']; // ALT attr is used by the image insert ?>" 
                title="Click to select this image" 
                src="<?php echo $html->url(WildAsset::getThumbUrl($image['WildAsset']['name'])); ?>">
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
