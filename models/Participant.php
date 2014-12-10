<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "participant".
 *
 * @property integer $id
 * @property integer $balance
 * @property string $name
 * @property string $status
 *
 * @property Match[] $matches
 * @property Pair[] $pairs
 */
class Participant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches()
    {
        return $this->hasMany(Match::className(), ['participant_id_4' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPairs()
    {
        return $this->hasMany(Pair::className(), ['participant_id_1' => 'id']);
    }

    public static function getAllPlayersList()
    {
        $playersQuery = (new Query())->select(['id', 'name'])->from('participant')->all();
        $playersList = [];
        foreach ($playersQuery as $playerRow) {
            $playersList[$playerRow['id']] = $playerRow['name'];
        }
        return $playersList;
    }

    public static function getStatusesList()
    {
        return [
            'active' => 'Active',
            'blocked' => 'Blocked',
        ];
    }
}
