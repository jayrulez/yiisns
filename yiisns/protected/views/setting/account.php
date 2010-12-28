<div class="action" id="setting-account">
	<div class="action-header">
		<div class="title">
			<?php echo Yii::t('application', 'Account settings'); ?>
		</div>
	</div>
	<div class="action-content">
	</div>
</div>
<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>$this->renderPartial('right_sidebar', array(), true),
)); ?>