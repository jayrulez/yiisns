<div class="stream-content">
	<div class="stream-items">
		<?php if(count($posts)): ?>
		<?php foreach($posts as $post): ?>
		<?php Yii::app()->controller->widget('PostViewWidget', array(
			'post'=>$post,
		)); ?>
		<?php endforeach; ?>
		<?php else: ?>
			<?php echo Yii::t('application', 'No posts.'); ?>
		<?php endif; ?>
	</div>
</div>