<?php
use app\components\Hello;
?>

<?=$namess?>
<?=$namecc?>

<div> Виджет Hello говорит: <?=Hello::widget(['message' => 'Hello world']); ?> </div>