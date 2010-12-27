		<div class="stream-item" id="post-<?php echo $post->id; ?>">
			<div class="stream-item-content clearfix">
				<div class="stream-user-icon">
					<?php echo $post->user->getImageLink(User::PHOTO_SIZE_SMALL); ?>
				</div>
				<div class="stream-entry">
					<div class="stream-entry-data">
						<div class="stream-user-link">
							<?php echo $post->user->getLink(); ?>
						</div>
						<div class="stream-content-text">
							<?php echo $post->content; ?>
						</div>
					</div>
					<div class="stream-entry-extra">
						<div class="stream-entry-options">
							<?php echo CHtml::link(Util::getFuzzyTime($post->create_time), array('/post/view', 'id'=>$post->id)); ?>
						</div>
						<?php if(count($post->comments)): ?>
						<div class="stream-comments">
							<div class="stream-comments-content">
							<?php foreach($post->comments as $counter => $comment): ?>
								<div class="stream-comment">
									<div class="stream-comment-content clearfix">
										<div class="stream-comment-user-icon">
											<?php echo $comment->user->getImageLink(User::PHOTO_SIZE_MINI); ?>
										</div>
										<div class="stream-comment-entry">
											<div class="stream-comment-entry-data">
												<div class="stream-comment-content-text">
													<span class="user-link"><?php echo $comment->user->getLink(); ?></span> <?php echo $comment->content; ?>
												</div>
											</div>
											<div class="stream-comment-entry-extra">
												<div class="stream-comment-options">
													<?php echo Util::getFuzzyTime($comment->create_time); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php if(($counter+1) !== count($post->comments)): ?>
								<div class="separator"></div>
								<?php endif; ?>
							<?php endforeach; ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="stream-comment-form">
							<?php $this->widget('PostCommentFormWidget', array(
								'postId'=>$post->id,
							)); ?>
						</div>
					</div>
				</div>
			</div>
		</div>