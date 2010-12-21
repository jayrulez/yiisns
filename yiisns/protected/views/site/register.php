<div class="action" id="site-register">
	<div class="action-content">
		<div class="user-registration-form">
			<?php echo CHtml::beginForm(Yii::app()->getUser()->registerUrl,'post',array('class'=>'wf')); ?>
				<div class="form-header">
					<div class="title">
						<?php echo Yii::t('application', '{appName} Registration', array(
							'{appName}'=>Yii::app()->name,
						)); ?>
					</div>
				</div>
				<?php echo CHtml::errorSummary($form); ?>
				<fieldset class="top">
					<div class="row top clearfix">
						<?php echo CHtml::activeLabel($form,'username'); ?>
						<?php echo CHtml::activeTextField($form,'username', array('class'=>'text')); ?>
					</div>
					<div class="row clearfix">
						<?php echo CHtml::activeLabel($form,'password'); ?>
						<?php echo CHtml::activePasswordField($form,'password', array('class'=>'text')); ?>
					</div>
				</fieldset>
				<fieldset class="buttons bottom">
					<?php echo CHtml::submitButton(Yii::t('application', 'Register'), array('class'=>'submit')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

