<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "activities".
 *
 * @property integer $id
 * @property integer $tournament_id
 * @property string $type
 * @property string $data
 * @property string $created_at
 */
class Activity extends ActiveRecord
{
    private $_decorator = null;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activities';
    }
    
    public function afterFind()
    {
        $this->data = Json::decode($this->data);
        parent::afterFind();
    }
    
    public function getDecorator()
    {
        if ($this->_decorator === null) {
            $class = __NAMESPACE__ . '\\decorators\\' . $this->type;
            $this->_decorator = new $class($this->data);
        }
        return $this->_decorator;
    }
    
}