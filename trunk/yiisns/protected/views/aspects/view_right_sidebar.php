<div id="aspect-sidebar-right" class="sidebar-content-inner">
	<div class="sidebar-item" id="aspect-block">
		<div class="sidebar-item-header clearfix">
			<div class="title"><?php echo Yii::t('application', '{aspectName}', array('{aspectName}'=>$aspect->name)); ?></div>
			<div class="link"><?php echo CHtml::link(Yii::t('application','edit'), array('/aspect/update', 'id'=>$aspect->id)); ?></div>
		</div>
		<div class="sidebar-item-content">
			<?php $this->renderPartial('/partials/aspect_block', array(
					'aspect'=>$aspect,
					'contactsPerRow'=>9,
					'showLink'=>false,
				)); ?>
		</div>
	</div>
</div>