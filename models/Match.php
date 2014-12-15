<?php

namespace app\models;

use app\models\Payment;
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
    const MATCH_STATUS_BLOCKED = 'blocked';

    const MATCH_BANK = 5;

    const MATCH_SCENARIO_PLAY_GAME = 'play_game';

    public $score;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'match';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['winner_id'],
            self::MATCH_SCENARIO_PLAY_GAME => ['winner_id'],
        ];
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
            [['winner_id', 'winner_score'], 'required'],
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
                $this->looser_score = $this->score[$this->pairTwo->id];
            } else {
                $this->winner_score = $this->score[$this->pairTwo->id];
                $this->looser_score = $this->score[$this->pairOne->id];
            }
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->scenario == self::MATCH_SCENARIO_PLAY_GAME) {
            $this->status = self::MATCH_STATUS_PLAYED;
            $this->date = time();
            if ($this->pairOne->id == $this->winner_id) {
                $this->part_winner_id_1 = $this->pairOne->participantOne->id;
                $this->part_winner_id_2 = $this->pairOne->participantTwo->id;
                $this->looser_id = $this->pairTwo->id;
            } else {
                $this->part_winner_id_1 = $this->pairTwo->participantOne->id;
                $this->part_winner_id_2 = $this->pairTwo->participantTwo->id;
                $this->looser_id = $this->pairOne->id;
            }
            if (!$this->looser_score) {
                $this->looser_score = 0;
            }
            $this->takeCredits();
        }
        return parent::beforeSave($insert);
    }

    public function takeCredits()
    {
        $players = $this->getPlayersModels();
        foreach ($players as $player) {
            if (!Payment::findOne(['player_id' => $player->id, 'match_id' => $this->id])) {
                $payment = new Payment();
                $payment->status = Payment::PAYMENT_STATUS_CREDITS;
                $payment->sum = '-' . self::MATCH_BANK;
                $payment->player_id = $player->id;
                $payment->match_id = $this->id;
                $payment->save();
            }
        }
    }

    public function afterFind()
    {
        if ($this->status == self::MATCH_STATUS_PLAYED) {
            if ($this->winner_id == $this->pair_id_1) {
                $this->score[$this->pair_id_1] = $this->winner_score;
                $this->score[$this->pair_id_2] = $this->looser_score;
            } else {
                $this->score[$this->pair_id_2] = $this->winner_score;
                $this->score[$this->pair_id_1] = $this->looser_score;
            }
        }
        parent::afterFind();
    }

    public function checkCredits()
    {
        $players = $this->getPlayersModels();
        $creditable = true;
        foreach ($players as $player) {
            $creditable = $creditable && $player->balance >= self::MATCH_BANK;
        }
        return $creditable;
    }

    public function getUncreditablePlayers()
    {
        $players = $this->getPlayersModels();
        $uncreditable = [];
        foreach ($players as $player) {
            if (!$player->balance >= self::MATCH_BANK) {
                $uncreditable[] = $player->name;
            }
        }
        return $uncreditable;
    }

    public function getPlayersModels()
    {
        $players = [];
        $players[] = $this->pairOne->participantOne;
        $players[] = $this->pairOne->participantTwo;
        $players[] = $this->pairTwo->participantOne;
        $players[] = $this->pairTwo->participantTwo;
        return $players;
    }

    public function getMatchName($glue = ' - ')
    {
        return $this->pairOne->name . $glue . $this->pairTwo->name;
    }

    public function getOpponents($id)
    {
        $opponent = $id == $this->pairOne->id ? $this->pairTwo->name : $this->pairOne->name;
        return $opponent;
    }
}
