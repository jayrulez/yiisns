<div class="action" id="search-index">
	<div class="action-content">
		<div id="search-results">
			<!--<div id="search-results-title"><?php echo Yii::t('application', 'Your search for: {q}', array(
				'{q}'=>$q,
			)); ?></div>-->
			
			<?php if(count($results)): ?>
				<?php if(isset($results['users'])): ?>
				<div id="user-search-results">
					<div id="user-search-results-title"><?php echo Yii::t('application', 'User results for: {q}', array(
						'{q}'=>$q,
					)); ?></div>
					<?php foreach($results['users'] as $user): ?>
						<?php echo $user->getLink(); ?>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			<?php else: ?>
			<div id="no-search-results"><?php echo Yii::t('application', 'Nothing was found.'); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php Layout::addBlock('sidebar.left', array(
	'id'=>'filter_block',
	'content'=>$this->renderPartial('filter_block', array('q'=>$q), true),
)); ?>