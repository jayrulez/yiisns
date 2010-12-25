<div class="action" id="home-index">
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
	'id'=>'right_sidebar',
	'content'=>$this->renderPartial('index_right_sidebar', array(
		'user'=>$user,
	), true),
)); ?>