<div class="action" id="aspect-view">
	<div class="action-content">
		<div id="post-form">
			<?php $this->widget('PostFormWidget', array(
				'aspectIds'=>array($aspect->id),
			)); ?>
		</div>
		<div class="stream" id="post-stream">
			<?php $this->widget('PostStreamWidget', array(
				'aspectId'=>$aspect->id,
			)); ?>
		</div>
	</div>
</div>
<?php Layout::addBlock('sidebar.right', array(
	'id'=>'aspect_block',
	'content'=>$this->renderPartial('aspect_block', array(
		'aspect'=>$aspect,
	), true),
)); ?>