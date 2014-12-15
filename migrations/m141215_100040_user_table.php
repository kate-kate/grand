<?php

use yii\db\Migration;

class m141215_100040_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => 'pk',
            'name' => 'string',
            'email' => 'string',
            'password_hash' => 'string',
            'auth_key' =>'string',
            'status' => 'ENUM("blocked", "active") NOT NULL DEFAULT "blocked"'
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
