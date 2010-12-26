<div class="action" id="profile-view">
	<div class="action-content">
		<!--<?php if(($viewer = Yii::app()->user->getModel()) !== null && $user->id !== $viewer->id): ?>
		<?php echo $user->getRelationshipLink($viewer->id); ?>
		<?php endif; ?>-->
		<div class="stream" id="post-stream">
			<?php $this->widget('PostStreamWidget', array(
				'userId'=>$user->id,
			));
			?>
		</div>
	</div>
</div>
<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>$this->renderPartial('view_right_sidebar', array(
		'user'=>$user,
	), true),
)); ?>

