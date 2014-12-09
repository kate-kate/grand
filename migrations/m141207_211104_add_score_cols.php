<?php

use yii\db\Schema;
use yii\db\Migration;

class m141207_211104_add_score_cols extends Migration
{
    public function up()
    {
        $this->addColumn('match', 'winner_score', 'integer');
        $this->addColumn('match', 'looser_score', 'integer');
        $this->addColumn('match', 'looser_id', 'integer');

        $this->addForeignKey('FK_match_pair_4', 'match', 'looser_id', 'pair', 'id');

    }

    public function down()
    {
        echo "m141207_211104_add_name_score_cols cannot be reverted.\n";

        return false;
    }
}
