<div id="aspect-block">
	<div id="aspect-name"><?php echo Yii::t('application', '{aspectName}', array('{aspectName}'=>$aspect->name)); ?></div>
	<div id="aspect-contacts">
	<?php if(count($aspect->contacts)): ?>
		<?php foreach($aspect->contacts as $contact): ?>
			<?php echo $contact->contact->getLink(); ?>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="no-contacts"><?php echo Yii::t('application', 'No contacts'); ?></div>
	<?php endif; ?>
	</div>
</div>