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
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';
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
    
    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            if ($this->status === self::STATUS_BLOCKED && 
                isset($changedAttributes['status']) && 
                $changedAttributes['status'] === self::STATUS_ACTIVE
            ) {
                Match::blockByParticipant($this->id);
            }
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public static function getAllPlayersList($onlyActive = false)
    {
        $playersQuery = (new Query())->select(['id', 'name'])->from('participant');
        if ($onlyActive) {
            $playersQuery->where(['status' => self::STATUS_ACTIVE]);
        }
        $playersList = [];
        foreach ($playersQuery->all() as $playerRow) {
            $playersList[$playerRow['id']] = $playerRow['name'];
        }
        return $playersList;
    }

    public static function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE  => 'Active',
            self::STATUS_BLOCKED => 'Blocked',
        ];
    }
}
