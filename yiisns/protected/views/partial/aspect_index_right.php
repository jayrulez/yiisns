<div class="sidebar-item">
	<div class="sidebar-item-header clearfix">
		<div class="title">
			<?php echo Yii::t('application','Aspects'); ?>
		</div>
		<div class="misc">
			<?php echo CHtml::link(Yii::t('application','manage aspects'), array('/aspect/manage')); ?>
		</div>
	</div>
	<div class="sidebar-item-content">
		<?php foreach($aspects as $aspect): ?>
		<?php if(count($aspect->contacts)): ?>
		<div class="aspect">
			<div class="aspect-info">
				<?php echo $aspect->getLink(); ?>
				<?php echo Yii::t('application', '{contactCount} contacts',  array(
					'{contactCount}'=>$aspect->getContactCount(),
				)); ?>
			</div>
			<div class="aspect-contacts clearfix">
				<?php $controller->renderPartial('/partial/aspect_contacts', array(
					'contacts'=>$aspect->contacts,
					'contactsPerRow'=>9,
					'controller'=>$controller,
				)); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>