<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $player_id
 * @property integer $match_id
 * @property integer $sum
 * @property string $status
 *
 * @property Match $match
 * @property Participant $player
 */
class Payment extends \yii\db\ActiveRecord
{
    const PAYMENT_STATUS_BALANCE_FILL = "balance filling";
    const PAYMENT_STATUS_BET = "bet";
    const PAYMENT_SCENARIO_BALANCE_FILLING = "b_filling";
    const PAYMENT_SCENARIO_BALANCE_EDIT = "b_edit";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['player_id', 'sum'], 'required'],
            [['sum'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'player_id' => 'Player',
            'match_id' => 'Match ID',
            'sum' => 'Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatch()
    {
        return $this->hasOne(Match::className(), ['id' => 'match_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Participant::className(), ['id' => 'player_id']);
    }

    public function beforeSave($insert)
    {
        if ($this->scenario == self::PAYMENT_SCENARIO_BALANCE_FILLING) {
            $this->status = self::PAYMENT_STATUS_BALANCE_FILL;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->scenario == self::PAYMENT_SCENARIO_BALANCE_EDIT) {
            if ($this->player_id != $this->oldAttributes['player_id']) {
                $oldPlayer = Participant::findOne($this->oldAttributes['player_id']);
                $oldPlayer->balance -= $this->sum;
                $oldPlayer->save(false);
                $newPlayer = Participant::findOne($this->player_id);
                $newPlayer->balance += $this->sum;
                $newPlayer->save(false);
            } elseif ($this->sum != $this->_oldAttributes['sum']) {
                $this->player->balance = $this->player->balance - $this->_oldAttributes['sum'] + $this->sum;
                $this->player->save(false);
            }
        } else {
            $player = Participant::findOne($this->player_id);
            $player->balance += $this->sum;
            $player->save(false);
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
