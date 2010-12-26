<div class="action" id="site-error">
	<div class="action-header">
		<h2 class="header-text"><?php echo Yii::t('application', 'Error: {code}', array('{code}'=>$code)); ?></h2>
	</div>
	<div class="action-content">
		<div class="error">
		<?php echo CHtml::encode($message); ?>
		</div>
	</div>
</div>
