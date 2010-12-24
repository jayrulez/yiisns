<div id="post-stream-content">
	<div id="posts">
		<?php if(count($posts)): ?>
		<?php foreach($posts as $post): ?>
		<div class="post">
			<?php echo $post->user->getLink(); ?> <?php echo $post->content; ?>
		</div>
		<?php endforeach; ?>
		<?php else: ?>
			<?php echo Yii::t('application', 'No posts.'); ?>
		<?php endif; ?>
	</div>
</div>