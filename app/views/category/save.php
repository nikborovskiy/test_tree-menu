<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var \app\models\forms\CategoryForm $model
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'parent_id')->dropDownList(
    $model->getCategoryListData(),
    ['prompt' => 'Выберите родительскую категорию']
) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
