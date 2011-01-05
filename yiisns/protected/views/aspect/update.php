<?php
$this->pageTitle=Yii::t('application', 'Update aspect');
?>
<div class="action" id="aspect-update">
	<div class="action-content">
		<div class="form-container">
			<?php echo CHtml::beginForm(array('/aspect/update', 'id'=>$model->id),'post',array('class'=>'wf')); ?>
				<div class="form-header">
					<div class="title">
						<?php echo Yii::t('application', 'Update aspect'); ?>
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
					<?php echo CHtml::submitButton(Yii::t('application', 'Update'), array('class'=>'submit')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>'&nbsp;',
)); ?>