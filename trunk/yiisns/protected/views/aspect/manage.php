<?php
$this->pageTitle=Yii::t('application', 'Manage aspects');
?>
<div class="action" id="aspect-manage">
	<div class="action-header clearfix">
		<div class="title">
			<?php echo Yii::t('application','Manage aspects'); ?>
		</div>
		<div class="misc">
			<?php echo CHtml::link(Yii::t('application','Create aspect'), array('/aspect/create')); ?>
		</div>
	</div>
	<div class="action-content">
	</div>
</div>

<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>'&nbsp;',
)); ?>