<?php
$this->pageTitle=Yii::t('application', 'All aspects');
?>
<div class="action" id="aspect-index">
	<div class="action-content">
		<!--post-form-->
		<?php $this->widget('PostFormWidget'); ?>
		<!--/post-form-->
		<div class="stream" id="post-stream">
			<?php $this->widget('PostStreamWidget'); ?>
		</div>
	</div>
</div>

<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>$this->renderPartial('/partial/aspect_index_right', array(
		'aspects'=>$user->aspects,
		'controller'=>$this,
	), true),
)); ?>