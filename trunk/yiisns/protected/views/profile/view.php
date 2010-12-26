<div class="action" id="profile-view">
	<div class="action-content">
		<div class="user-identity-container">
			<?php $this->widget('UserIdentityWidget', array(
				'user'=>$user,
				'viewerId'=>Yii::app()->user->getId(),
			)); ?>	
		</div>
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

