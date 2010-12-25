<div id="filter-block">
	<ul>
		<li><?php echo CHtml::link(Yii::t('application', 'All results'), array('/search/index', 'q'=>$q,)); ?></li>
		<li><?php echo CHtml::link(Yii::t('application', 'Users'), array('/search/index', 'q'=>$q, 'search_type'=>'users',)); ?></li>
		<li><?php echo CHtml::link(Yii::t('application', 'Posts'), array('/search/index', 'q'=>$q, 'search_type'=>'posts',)); ?></li>
	</ul>
</div>