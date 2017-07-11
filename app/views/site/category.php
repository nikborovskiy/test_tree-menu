<?php
use yii\helpers\Html;

/**
 * @var \app\models\Category $model
 */
?>
<h1>Категория "<?= $model->name; ?>"</h1>
<div class="btn-group" role="group" aria-label="...">
    <?= Html::a('Добавить категорию', ['/category/save', 'parent_id' => $model->id], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Редактировать категорию', ['/category/save', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
    <?= Html::a('Удалить категорию', ['/category/delete', 'id' => $model->id], ['class' => 'btn btn-danger']); ?>
</div>
<br/>
<br/>
<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        [
            'label' => $model->getAttributeLabel('parent_id'),
            'value' => $model->parent->name,
        ],
    ]
]); ?>
