<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<p class="text-center">
    Для начала работы нажмите на любую из категорий слева или кнопку:
    <br/>
    <?= Html::a('Добавить категорию', ['/category/save'], ['class' => 'btn btn-success']) ?>
</p>
