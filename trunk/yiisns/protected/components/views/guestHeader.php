<div id="header-content" class="clearfix">
	<div id="home-link">
		<?php echo CHtml::link('', Yii::app()->homeUrl); ?>
	</div>
	<div id="main-nav">
		<ul id="guest-nav">
			<li><?php echo CHtml::link(Yii::t('application', 'login'), Yii::app()->user->loginUrl); ?></li>
			<li><?php echo CHtml::link(Yii::t('application', 'register'), Yii::app()->user->registerUrl); ?></li>
		</ul>
	</div>
</div>