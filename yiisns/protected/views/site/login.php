<div class="action" id="site-login">
	<div class="action-content">
		<div class="user-login-form">
			<?php echo CHtml::beginForm(Yii::app()->getUser()->loginUrl,'post',array('class'=>'wf')); ?>
				<div class="form-header">
					<div class="title">
						<?php echo Yii::t('application', '{appName} Login', array(
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
					<div class="row indent bottom clearfix">
						<?php echo CHtml::activeCheckBox($form,'autologin', array('class'=>'checkbox')); ?>
						<?php echo CHtml::activeLabel($form,'autologin', array('class'=>'inline')); ?>
					</div>
				</fieldset>
				<fieldset class="buttons bottom">
					<?php echo CHtml::submitButton(Yii::t('application', 'Login'), array('class'=>'submit')); ?>
				</fieldset>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>

