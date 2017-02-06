<?php
use yii\widgets\LinkPager;


?>


<h1>Комментарий</h1>
<ul>
<?php foreach ($comments as $comment){ ?>
	<li><a href="<?=Yii::$app->urlManager->createUrl(['site/user','name' => $comment->name])?>"><?=$comment->name?> </a>: <?=$comment->text?></li>

<?php  } ?>
</ul>

<?=LinkPager::widget(['pagination' => $pagination]) ?>