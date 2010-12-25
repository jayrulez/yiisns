<div id="post-stream-content">
	<div id="posts">
		<?php if(count($posts)): ?>
		<?php foreach($posts as $post): ?>
		<div class="post">
			<div class="post-content clearfix">
				<div class="post-user-icon">
					<?php echo $post->user->getImage(); ?>
				</div>
				<div class="post-entry">
					<div class="post-entry-data">
						<div class="post-user-link">
							<?php echo $post->user->getLink(); ?>
						</div>
						<div class="post-content-text">
							<?php echo $post->content; ?>
						</div>
					</div>
					<div class="post-entry-extra">
						<div class="post-options">
							<?php echo CHtml::link(Yii::t('application', $post->create_time), array('/post/view', 'id'=>$post->id)); ?>
						</div>
						<div class="post-comments">
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		<?php else: ?>
			<?php echo Yii::t('application', 'No posts.'); ?>
		<?php endif; ?>
	</div>
</div>