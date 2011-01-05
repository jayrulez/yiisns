<?php
$this->pageTitle=$aspect->name;
?>
<div class="action" id="aspect-view">
	<div class="action-content">
		<!--post-form-->
		<?php $this->widget('PostFormWidget', array(
			'aspectIds'=>array($aspect->id),
		)); ?>
		<!--/post-form-->
		<div class="stream" id="post-stream">
			<?php $this->widget('PostStreamWidget', array(
				'aspectId'=>$aspect->id,
			)); ?>
		</div>
	</div>
</div>

<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>$this->renderPartial('/partial/aspect_view_right', array(
		'aspect'=>$aspect,
		'controller'=>$this,
	),true),
)); ?>