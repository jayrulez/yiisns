<div class="action" id="aspect-manage">
	<div class="action-header">
		<div class="title">
			<?php echo Yii::t('application', 'Manage aspects'); ?>
		</div>
	</div>
	<div class="action-content">
		<?php foreach($user->aspects as $aspect): ?>
		<div class="aspect">
			<?php foreach($aspect->contacts as $contact): ?>
				<?php echo $contact->contact->getImageLink(User::PHOTO_SIZE_SMALL); ?>
			<?php endforeach; ?>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php Layout::addBlock('sidebar.left', array(
	'id'=>'left_sidebar',
	'content'=>$this->renderPartial('manage_left_sidebar', array(
		'user'=>$user,
	), true),
)); ?>