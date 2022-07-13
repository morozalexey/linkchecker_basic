<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Linkchecker';

$repeating = [];
for ($i=0; $i <=10 ; $i++) { 
    $repeating[$i] = $i; 
}?>

<?php if (isset($status)) : ?>
   <h2><?php echo $status ?></h2> <br>;
    <a href="/index.php" class="btn btn-success">Проверить ещё одну ссылку</a>  
<?php else : ?>
<?php $form = ActiveForm::begin(['action' => '/index.php?r=site/check']) ?>
<?php echo $form->field($model, 'link') ?>
<?php echo $form->field($model, 'repeating')->dropDownList($repeating);?>
<?php echo $form->field($model, 'period')->dropDownList(
    [
        '1' => '1 min', 
        '5' => '5 min',
        '10' => '10 min'
    ]
);?>
<?php echo Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>

<?php endif ; ?>