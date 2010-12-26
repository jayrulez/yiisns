<div id="home-sidebar-right" class="sidebar-content-inner">
	<div class="sidebar-item" id="user-identity-block">
		<?php $this->widget('UserIdentityWidget'); ?>
	</div>
	
	<div class="break"></div>
	
	<div class="sidebar-item" id="aspects-block">
	
		<div class="sidebar-item-header clearfix">
			<div class="title"><?php echo Yii::t('application', 'Aspects'); ?></div>
			<div class="link"><?php echo CHtml::link(Yii::t('application', 'manage aspects'), array('/aspect/manage')); ?></div>
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