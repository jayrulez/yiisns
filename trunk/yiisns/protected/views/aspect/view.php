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
	'id'=>'right_sidebar',
	'content'=>$this->renderPartial('view_right_sidebar', array(
		'aspect'=>$aspect,
	), true),
)); ?>