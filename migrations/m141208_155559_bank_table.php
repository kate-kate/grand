<?php

use yii\db\Schema;
use yii\db\Migration;

class m141208_155559_bank_table extends Migration
{
    public function up()
    {
        $this->createTable('payment', [
            'id' => 'pk',
            'created_at' => 'integer',
            'updated_at' => 'integer',
            'player_id' => 'integer',
            'match_id' => 'integer',
            'sum' => 'integer',
            'status' => 'ENUM("balance filling", "bet")',
        ]);
        $this->addColumn('participant', 'balance', 'integer');

        $this->addForeignKey('FK_payment_participant', 'payment', 'player_id', 'participant', 'id');
        $this->addForeignKey('FK_payment_match', 'payment', 'match_id', 'match', 'id');

    }

    public function down()
    {
//        $this->dropTable('payment');
//        $this->dropColumn('participant', 'balance');
        return false;
    }
}
