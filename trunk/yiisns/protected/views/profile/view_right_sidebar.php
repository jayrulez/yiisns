<div id="profile-sidebar-right" class="sidebar-content-inner">
	<div class="sidebar-item" id="user-identity-block">
		<div class="sidebar-item-content">
			<?php $this->widget('UserIdentityWidget', array(
				'userId'=>$user->id,
				'viewerId'=>Yii::app()->user->getId(),
			)); ?>
		</div>
	</div>
</div>