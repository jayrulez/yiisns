<?php
$this->pageTitle=$user->getDisplayName();
?>
<div class="action" id="user-view">
	<div class="action-content">
		<div class="user-profile">
			<?php echo $user->getDisplayName(); ?>
			<?php echo $user->getRelationshipLink(Yii::app()->getUser()->getId()); ?>
			<?php if($user->id === Yii::app()->getUser()->getId()): ?>
			<?php echo CHtml::link(Yii::t('application','Edit profile'), array('/editprofile/basic')); ?>
			<?php endif; ?>
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
	'content'=>'&nbsp;',
)); ?>