<?php
$this->pageTitle=Yii::t('application', 'Error');
?>
<div class="action" id="site-error">
	<div class="action-header">
		<div class="title"><?php echo Yii::t('application', 'Error {code}', array('{code}'=>$code)); ?></div>
	</div>
	<div class="action-content">
		<div class="error"><?php echo CHtml::encode($message); ?></div>
	</div>
</div>