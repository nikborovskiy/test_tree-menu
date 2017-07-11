<?php
namespace app\models\forms;

use app\models\Category;
use yii\base\Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Class CategoryForm
 * @package app\models\forms
 */
class CategoryForm extends AbstractForm
{
    public $name;
    public $parent_id;

    /**
     * @inheritdoc
     */
    public function data()
    {
        return Yii::createObject(Category::className());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = $this->data()->attributeLabels();
        return $labels;
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
            [['parent_id'], 'checkParent'],
        ];
    }

    /**
     * Валидация parent_id
     * Родительская категория не может быть собою
     */
    public function checkParent()
    {
        if ($this->id == $this->parent_id) {
            return $this->addError('parent_id', 'Родительская категория не может быть текущей категорией.');
        }
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        /** @var Category $model */
        $model = $this->getModel();
        if (!$model->isNewRecord) {
            $this->setAttributes($model->getAttributes(), false);
        }
        if (parent::load($data, $formName)) {
            return true;
        }
        return false;
    }

    /**
     * Save form
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            /** @var Category $model */
            $model = $this->getModel();
            if ($this->id) {
                if ($model->isNewRecord) {
                    return false;
                }
            }
            $model->setAttributes($this->getAttributes($this->safeAttributes()), false);
            if ($model->save()) {
                $this->id = $model->id;
                return true;
            }
        }
        return false;
    }

    /**
     * Find model for form
     *
     * @param string|ActiveRecord $object
     * @return static
     */
    public function setModel($object)
    {
        $this->_model = $object;
        return $this;
    }

    /**
     * Find model for form
     *
     * @return Category
     * @throws CategoryFormException
     * @throws \yii\base\InvalidConfigException
     */
    public function getModel()
    {
        if ($this->_model === null) {
            if ($this->id) {
                $this->_model = Category::find()->andWhere(['id' => $this->id])->one();
                if (null == $this->_model) {
                    throw new CategoryFormException(
                        'Model "Category" not found ' . VarDumper::dumpAsString($this->id),
                        CategoryFormException::EXCEPTION_MODEL_NOT_FOUND
                    );
                }
            } else {
                $this->_model = Yii::createObject(Category::className());
            }
        }
        return $this->_model;
    }

    /**
     * Получение списка категорий для dropDownList.
     * При редактировании текущая категория исключается.
     * @return array
     */
    public function getCategoryListData()
    {
        $data = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        if ($this->id) {
            unset($data[$this->id]);
        }
        return $data;
    }
}

class CategoryFormException extends Exception
{
    const EXCEPTION_MODEL_NOT_FOUND = 1;
}
