<div id="header-content" class="clearfix">
	<div id="home-link">
		<?php echo CHtml::link('', Yii::app()->homeUrl); ?>
	</div>
	<div id="main-nav">
		<ul id="user-nav">
			<li><?php echo CHtml::link(Yii::t('application', 'logout'), array('/site/logout')); ?></li>
		</ul>
	</div>
</div>