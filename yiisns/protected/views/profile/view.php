<div class="action" id="profile-view">
	<div class="action-content">
		<?php if(($viewer = Yii::app()->user->getModel()) !== null && $user->id !== $viewer->id): ?>
		<?php echo $user->getRelationshipLink($viewer->id); ?>
		<?php endif; ?>
	</div>
</div>

