<div class="sidebar-item">
	<div class="sidebar-item-header clearfix">
		<div class="title"><?php echo $aspect->name; ?></div>
		<div class="misc"><?php echo CHtml::link(Yii::t('application', 'edit'), array('/aspect/update', 'id'=>$aspect->id)); ?></div>
	</div>
	<div class="sidebar-item-content">
		<?php if(count($aspect->contacts)): ?>
		<div class="aspect">
			<div class="aspect-contacts clearfix">
				<?php $controller->renderPartial('/partial/aspect_contacts', array(
					'contacts'=>$aspect->contacts,
					'contactsPerRow'=>9,
					'controller'=>$controller,
				)); ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>