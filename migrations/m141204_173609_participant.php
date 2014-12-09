<?php

use yii\db\Schema;
use yii\db\Migration;

class m141204_173609_participant extends Migration
{
    public function up()
    {
        $this->createTable('participant', [
            'id' => 'pk',
            'name' => 'string(255)',
            'status' => 'ENUM("blocked", "active") NOT NULL DEFAULT "active"'
        ]);
    }

    public function down()
    {
       return false;
    }
}
