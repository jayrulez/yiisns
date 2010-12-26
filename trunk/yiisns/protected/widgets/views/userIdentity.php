<div class="user-identity clearfix">
	<div class="user-image">
		<?php echo $user->getImageLink(User::PHOTO_SIZE_MEDIUM); ?>
	</div>
	<div class="user-info">
		<p><?php echo $user->getLink(); ?></p>
		<?php if(($relationshipLink = $user->getRelationshipLink($viewerId)) !== null): ?>
		<p><?php echo $relationshipLink; ?></p>
		<?php endif; ?>
	</div>
</div>