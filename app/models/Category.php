<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id #
 * @property string $name Название категории
 * @property int $parent_id Родительская категория
 *
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Название категории',
            'parent_id' => 'Родительская категория',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    public static function getMenuItemsData($models = null)
    {
        $result = [];
        /** @var Category[] $models */
        $models = $models ?: self::find()->andWhere(['parent_id' => null])->all();
        if ($models) {
            foreach ($models as $model) {
                $result[$model->id] = [
                    'label' => $model->name,
                    'url' => ['/site/category', 'id' => $model->id],
                ];
                if ($model->categories) {
                    $result[$model->id]['items'] = self::getMenuItemsData($model->categories);
                }
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if ($this->categories) {
            $this->deleteAll(['id' => ArrayHelper::getColumn($this->categories, 'id')]);
        }
        return parent::beforeDelete();
    }

    /**
     * Удаление категории
     * @param $id
     * @return bool|false|int
     * @throws \Exception
     * @throws \Throwable
     */
    public static function deleteCategory($id)
    {
        $model = self::find()->andWhere(['id' => $id])->one();
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}
