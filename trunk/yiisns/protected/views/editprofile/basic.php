<?php
$this->pageTitle=Yii::t('application', 'Basic Profile');
?>
<div class="action" id="editprofile-basic">
	<div class="action-content">
		<div class="form-container">
			<?php echo CHtml::beginForm(array('/editprofile/basic'),'post',array('class'=>'wf')); ?>
				<div class="form-header">
					<div class="title">
						<?php echo Yii::t('application', 'Edit Basic Profile'); ?>
					</div>
				</div>
				<?php echo CHtml::errorSummary($model); ?>
				<fieldset class="top">
					<div class="row top clearfix">
						<?php echo CHtml::activeLabel($model,'first_name'); ?>
						<?php echo CHtml::activeTextField($model,'first_name', array('class'=>'text')); ?>
					</div>
					<div class="row clearfix">
						<?php echo CHtml::activeLabel($model,'last_name'); ?>
						<?php echo CHtml::activeTextField($model,'last_name', array('class'=>'text')); ?>
					</div>
					<div class="row clearfix">
						<?php echo CHtml::activeLabel($model,'gender'); ?>
						<?php echo CHtml::activeDropDownList($model,'gender', Profile::getGenders(), array(
							'prompt'=>Yii::t('application','Select:'),
						)); ?>
					</div>
					<div class="row bottom clearfix">
						<?php echo CHtml::activeLabel($model,'birthday'); ?>
						<?php echo CHtml::activeTextField($model,'birthday', array('class'=>'text')); ?>
					</div>
				</fieldset>
				<fieldset class="buttons bottom">
					<?php echo CHtml::submitButton(Yii::t('application', 'Save Changes'), array('class'=>'submit')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

