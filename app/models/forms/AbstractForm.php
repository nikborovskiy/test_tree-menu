<?php

namespace app\models\forms;

use yii\base\Model;
use yii\base\Exception;
use yii\db\ActiveRecord;
use Yii;

abstract class AbstractForm extends Model
{
    public $id;
    protected $_model;
    protected $_modelClass;

    /**
     * Returns a value indicating whether the current record is new (not saved in the database).
     * @return boolean
     */
    public function getIsNewRecord()
    {
        return !$this->id;
    }
}