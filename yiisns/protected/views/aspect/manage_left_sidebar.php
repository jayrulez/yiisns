<?php foreach($user->contacts as $contact): ?>
	<?php echo $contact->contact->getImageLink(User::PHOTO_SIZE_MINI); ?>
<?php endforeach; ?>