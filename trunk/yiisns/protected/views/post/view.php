<?php
$this->pageTitle=$post->getShortenedContent();
?>
<div class="action" id="post-view">
	<div class="action-content">
		<div class="stream" id="post-stream">
			<div class="stream-content">
				<div class="stream-items">
					<?php Yii::app()->controller->widget('PostViewWidget', array(
						'post'=>$post,
					)); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php Layout::addBlock('sidebar.right', array(
	'id'=>'right_sidebar',
	'content'=>'&nbsp;',
)); ?>