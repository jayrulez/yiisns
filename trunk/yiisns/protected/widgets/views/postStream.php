<div id="post-stream-content">
	<div id="posts">
		<?php if(count($posts)): ?>
		<?php foreach($posts as $post): ?>
		<div class="post">
			<?php echo $post->user->getLink(); ?> <?php echo $post->content; ?>
			<?php if($post->user_id === Yii::app()->user->getId()): ?>
			<?php echo CHtml::link(Yii::t('application', 'delete'), array('/post/delete', 'id'=>$post->id)); ?>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
		<?php else: ?>
			<?php echo Yii::t('application', 'No posts.'); ?>
		<?php endif; ?>
	</div>
</div>