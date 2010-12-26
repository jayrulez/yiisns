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
							<?php echo CHtml::link(Util::getFuzzyTime($post->create_time), array('/post/view', 'id'=>$post->id)); ?>
						</div>
						<?php if(count($post->comments)): ?>
						<div class="post-comments">
							<div class="post-comments-content">
							<?php foreach($post->comments as $counter => $comment): ?>
								<div class="post-comment">
									<div class="post-comment-content clearfix">
										<div class="post-comment-user-icon">
											<?php echo $comment->user->getImageLink(User::PHOTO_SIZE_MINI); ?>
										</div>
										<div class="post-comment-entry">
											<div class="post-comment-entry-data">
												<div class="post-comment-content-text">
													<?php echo $comment->user->getLink(); ?> <?php echo $comment->content; ?>
												</div>
											</div>
											<div class="post-comment-entry-extra">
												<div class="post-comment-options">
													<?php echo Util::getFuzzyTime($comment->create_time); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php if(($counter+1) !== count($post->comments)): ?>
								<div class="sequence-break"></div>
								<?php endif; ?>
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