<?php

namespace app\controllers;

use app\models\Category;
use app\models\forms\CategoryForm;
use Yii;
use yii\web\Controller;

class CategoryController extends Controller
{
    /**
     * Создание | редактирование категории
     * @param null $id
     * @param null $parent_id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSave($id = null, $parent_id = null)
    {
        $model = Yii::createObject(CategoryForm::className());
        $model->setAttributes([
            'id' => $id,
            'parent_id' => $parent_id
        ], false);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/site/category', 'id' => $model->id]);
        } else {
            return $this->render('save', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаление категории и всех дочерних категорий
     * @param $id
     * @return string
     */
    public function actionDelete($id)
    {
        Category::deleteCategory($id);
        return $this->render('/site/index');
    }
}
