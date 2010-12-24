<div class="action" id="aspect-index">
	<div class="action-content">
		<div id="post-form">
			<?php $this->widget('PostFormWidget'); ?>
		</div>
		<div class="stream" id="post-stream">
			<?php $this->widget('PostStreamWidget'); ?>
		</div>
	</div>
</div>
<?php Layout::addBlock('sidebar.right', array(
	'id'=>'aspects_block',
	'content'=>$this->renderPartial('aspects_block', array(
		'user'=>$user,
	), true),
)); ?>