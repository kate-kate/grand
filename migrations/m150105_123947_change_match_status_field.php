<?php

use yii\db\Schema;
use yii\db\Migration;

class m150105_123947_change_match_status_field extends Migration
{
    public function up()
    {
        $this->alterColumn('match', 'status', "enum('blocked','played','block-played','not-played') NOT NULL DEFAULT 'not-played'");
    }

    public function down()
    {
        echo "m150105_123947_change_match_status_field cannot be reverted.\n";

        return false;
    }
}
