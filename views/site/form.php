<?php
/**
 * Created by PhpStorm.
 * User: talik
 * Date: 29.01.17
 * Time: 18:31
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $fo = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $fo->field($form, 'name') ?>
<?=$fo->field($form, 'email')?>
<?=$fo->field($form, 'file') -> fileInput() ?>
<?=Html::submitButton('Send'); ?>

<?php ActiveForm::end();?>
