<?php
$this->pageTitle=Yii::t('application', 'Profile Picture');
?>
<div class="action" id="editprofile-picture">
	<div class="action-content">
		<div class="form-container">
			<?php echo CHtml::beginForm(array('/editprofile/picture'),'post',array('class'=>'wf','enctype'=>'multipart/form-data')); ?>
				<div class="form-header">
					<div class="title">
						<?php echo Yii::t('application', 'Profile Picture'); ?>
					</div>
				</div>
				<?php echo CHtml::errorSummary($form); ?>
				<fieldset class="top">
					<div class="row top bottom clearfix">
						<?php echo CHtml::activeLabel($form,'file'); ?>
						<?php echo CHtml::activeFileField($form,'file', array('class'=>'text')); ?>
					</div>
				</fieldset>
				<fieldset class="buttons bottom">
					<?php echo CHtml::submitButton(Yii::t('application', 'Upload'), array('class'=>'submit')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

