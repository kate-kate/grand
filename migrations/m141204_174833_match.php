<?php

use yii\db\Schema;
use yii\db\Migration;

class m141204_174833_match extends Migration
{
    public function up()
    {
        $this->createTable('match', [
            'id' => 'pk',
            'pair_id_1' => 'integer',
            'pair_id_2' => 'integer',
            'winner_id' => 'integer',
            'status' => 'ENUM("blocked", "played", "not-played") NOT NULL DEFAULT "not-played"',
            'date' => 'integer',
            'part_winner_id_1' => 'integer',
            'part_winner_id_2' => 'integer',
        ]);

        $this->addForeignKey('FK_match_pair_1', 'match', 'pair_id_1', 'pair', 'id');
        $this->addForeignKey('FK_match_pair_2', 'match', 'pair_id_2', 'pair', 'id');
        $this->addForeignKey('FK_match_pair_3', 'match', 'winner_id', 'pair', 'id');

        $this->addForeignKey('FK_match_participant_1', 'match', 'part_winner_id_1', 'participant', 'id');
        $this->addForeignKey('FK_match_participant_2', 'match', 'part_winner_id_2', 'participant', 'id');
    }

    public function down()
    {
        return false;
    }
}
