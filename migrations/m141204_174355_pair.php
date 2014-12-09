<?php

use yii\db\Schema;
use yii\db\Migration;

class m141204_174355_pair extends Migration
{
    public function up()
    {
        $this->createTable('pair', [
            'id' => 'pk',
            'participant_id_1' => 'integer',
            'participant_id_2' => 'integer',
        ]);

        $this->addForeignKey('FK_pair_participant_1', 'pair', 'participant_id_1', 'participant', 'id');
        $this->addForeignKey('FK_pair_participant_2', 'pair', 'participant_id_2', 'participant', 'id');
    }

    public function down()
    {
        echo "m141204_174355_pair cannot be reverted.\n";
        return false;
    }
}
