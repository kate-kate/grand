<?php

use yii\db\Schema;
use yii\db\Migration;

class m141216_134418_activity_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('activities', [
            'id' => Schema::TYPE_PK,
            'tournament_id' => Schema::TYPE_INTEGER,
            'type' => Schema::TYPE_STRING . ' NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_DATETIME
        ], $tableOptions);
        $this->createIndex('tournament_id_idx', 'activities', 'tournament_id');
    }

    public function down()
    {
        $this->dropTable('activities');
    }
}
