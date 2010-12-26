<div id="post-stream-content">
	<div id="posts">
		<?php if(count($posts)): ?>
		<?php foreach($posts as $post): ?>
		<div class="post" id="post-<?php echo $post->id; ?>">
			<div class="post-content clearfix">
				<div class="post-user-icon">
					<?php echo $post->user->getImageLink(User::PHOTO_SIZE_SMALL); ?>
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
							<?php echo CHtml::link(Yii::t('application', Util::getFuzzyTime($post->create_time)), array('/post/view', 'id'=>$post->id)); ?>
						</div>
						<?php if(count($post->comments)): ?>
						<div class="post-comments">
							<div class="post-comments-content">
							<?php foreach($post->comments as $comment): ?>
								<div class="post-comment">
									<?php echo $comment->content; ?>
								</div>
							<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="post-comment-form">
							<?php $this->widget('PostCommentFormWidget', array(
								'postId'=>$post->id,
							)); ?>
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