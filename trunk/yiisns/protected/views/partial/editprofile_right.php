<div class="sidebar-item">
	<div class="sidebar-item-content">
		<ul>
			<li><?php echo CHtml::link(Yii::t('application','View My Profile'), $user->getUrl()); ?></li>
			<li><?php echo CHtml::link(Yii::t('application','Basic Information'), array('/editprofile/basic')); ?></li>
			<li><?php echo CHtml::link(Yii::t('application','Profile Picture'), array('/editprofile/picture')); ?></li>
		</ul>
	</div>
</div>