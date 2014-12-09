<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "match".
 *
 * @property integer $id
 * @property integer $pair_id_1
 * @property integer $pair_id_2
 * @property integer $winner_id
 * @property integer $looser_id
 * @property integer $winner_score
 * @property integer $looser_score
 * @property string $status
 * @property integer $date
 * @property integer $part_winner_id_1
 * @property integer $part_winner_id_2
 *
 * @property Participant $partWinnerId2
 * @property Pair $pairOne
 * @property Pair $pairTwo
 * @property Pair $winner
 * @property Participant $partWinnerId1
 */
class Match extends \yii\db\ActiveRecord
{
    const MATCH_STATUS_NOT_PLAYED = 'not-played';
    const MATCH_STATUS_PLAYED = 'played';
    const MATCH_STATUS_BLOCKED = 'not-played';
    const MATCH_STATUS_STARTED = 'started';

    const MATCH_BANK = 5;

    public $score;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'match';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pair_id_1', 'pair_id_2', 'winner_score', 'looser_score'], 'integer'],
            [['status'], 'string'],
            [['winner_id'], 'validateWinner'],
            [['winner_id', 'winner_score', 'looser_score'], 'required'],
        ];
    }

    public function validateWinner($attribute, $params)
    {
        if (isset($this->score[$this->winner_id]) && $this->score[$this->winner_id] != 2) {
            $this->addError($attribute, 'Something gone wrong!');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pair_id_1' => 'Pair Id 1',
            'pair_id_2' => 'Pair Id 2',
            'winner_id' => 'Winner',
            'status' => 'Status',
            'date' => 'Date',
            'part_winner_id_1' => 'Part Winner Id 1',
            'part_winner_id_2' => 'Part Winner Id 2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartWinnerId2()
    {
        return $this->hasOne(Participant::className(), ['id' => 'part_winner_id_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPairOne()
    {
        return $this->hasOne(Pair::className(), ['id' => 'pair_id_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPairTwo()
    {
        return $this->hasOne(Pair::className(), ['id' => 'pair_id_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWinner()
    {
        return $this->hasOne(Pair::className(), ['id' => 'winner_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLooser()
    {
        return $this->hasOne(Pair::className(), ['id' => 'looser_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartWinnerId1()
    {
        return $this->hasOne(Participant::className(), ['id' => 'part_winner_id_1']);
    }

    public function getStatuses()
    {
        return [
            'not-played' => 'not-played',
            'played' => 'played',
            'blocked' => 'blocked'
        ];
    }

    public function getPairsList()
    {
        return [$this->pairOne->id => $this->pairOne->name, $this->pairTwo->id => $this->pairTwo->name];
    }

    public function beforeValidate()
    {
        if ($this->score) {
            if ($this->score[$this->pairOne->id] > $this->score[$this->pairTwo->id]) {
                $this->winner_score = $this->score[$this->pairOne->id];
                $this->looser_id = $this->score[$this->pairTwo->id];
            } else {
                $this->winner_score = $this->score[$this->pairTwo->id];
                $this->looser_id = $this->score[$this->pairOne->id];
            }
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (!$this->date) {
            $this->date = time();
        }
        if ($this->winner_id) {
            if (!$this->looser_id) {
                $this->looser_id = $this->winner_id == $this->pair_id_1 ? $this->pair_id_2 : $this->pair_id_1;
            }
            if ($this->status == self::MATCH_STATUS_NOT_PLAYED || $this->status == self::MATCH_STATUS_STARTED) {
                $this->status = self::MATCH_STATUS_PLAYED;
            }
            if (!$this->part_winner_id_1) {
                if ($this->pairOne->id == $this->winner_id) {
                    $this->part_winner_id_1 = $this->pairOne->participantOne->id;
                    $this->part_winner_id_2 = $this->pairOne->participantTwo->id;
                }
            } else {
                if ($this->pairTwo->id == $this->winner_id) {
                    $this->part_winner_id_1 = $this->pairTwo->participantOne->id;
                    $this->part_winner_id_2 = $this->pairTwo->participantTwo->id;
                }
            }
        }
        return parent::beforeSave($insert);
    }
}
