<div id="aspect-sidebar-right" class="sidebar-content-inner">
	<div class="sidebar-item" id="user-identity-block">
		<div class="sidebar-item-content">
			<?php $this->widget('UserIdentityWidget', array(
				'user'=>$user,
				'viewerId'=>Yii::app()->user->getId(),
			)); ?>
		</div>
	</div>
	
	<div class="separator"></div>
	
	<div class="sidebar-item" id="aspects-block">
	
		<div class="sidebar-item-header clearfix">
			<div class="title"><?php echo Yii::t('application', 'My Contacts'); ?></div>
			<div class="link"><?php echo CHtml::link(Yii::t('application', 'manage contacts'), array('/contact/manage')); ?></div>
		</div>
		
		<div class="sidebar-item-content">
		<?php if(count($user->aspects)): ?>
		
			<?php foreach($user->aspects as $aspect): ?>
				<?php $this->renderPartial('/partials/aspect_block', array(
					'aspect'=>$aspect,
					'contactsPerRow'=>9,
					'showLink'=>true,
				)); ?>
			<?php endforeach; ?>
			
		<?php else: ?>
			<div class="no-aspects"><?php echo Yii::t('application', 'No aspects'); ?></div>
		<?php endif; ?>
		</div>
	</div>
</div>