<div class="action" id="aspect-create">
	<div class="action-content">
		<div class="aspect-create-form">
			<?php echo CHtml::beginForm(array('/aspect/create'),'post',array('class'=>'wf')); ?>
				<div class="form-header">
					<div class="title">
						<?php echo Yii::t('application', 'Create an aspect'); ?>
					</div>
				</div>
				<?php echo CHtml::errorSummary($model); ?>
				<fieldset class="top">
					<div class="row top bottom clearfix">
						<?php echo CHtml::activeLabel($model,'name'); ?>
						<?php echo CHtml::activeTextField($model,'name', array('class'=>'text')); ?>
					</div>
				</fieldset>
				<fieldset class="buttons bottom">
					<?php echo CHtml::submitButton(Yii::t('application', 'Create'), array('class'=>'submit')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

