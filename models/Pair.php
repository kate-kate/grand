<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pair".
 *
 * @property integer $id
 * @property string $name
 * @property integer $participant_id_1
 * @property integer $participant_id_2
 *
 * @property Match[] $matches
 * @property Participant $participantOne
 * @property Participant $participantTwo
 */
class Pair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pair';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['participant_id_1', 'participant_id_2'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'participant_id_1' => 'Participant Id 1',
            'participant_id_2' => 'Participant Id 2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches()
    {
        return $this->hasMany(Match::className(), ['pair_id_2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantTwo()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantOne()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id_1']);
    }
}
