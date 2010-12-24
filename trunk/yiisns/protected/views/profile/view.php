<div class="action" id="profile-view">
	<div class="action-content">
		<?php if($user->id === Yii::app()->user->getId() || Util::areContacts($user->id, Yii::app()->user->getId())): ?>
			
		<?php else: ?>
			<?php echo CHtml::link(Yii::t('application', 'Add as contact.'), array('/contact/sendRequest', 'id'=>$user->id)); ?>
		<?php endif; ?>
	</div>
</div>

