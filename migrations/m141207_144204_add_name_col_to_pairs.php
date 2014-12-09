<?php

use yii\db\Schema;
use yii\db\Migration;

class m141207_144204_add_name_col_to_pairs extends Migration
{
    public function up()
    {
        $this->addColumn('pair', 'name', 'string');
        $pairs = \app\models\Pair::find()->all();
        foreach ($pairs as $pair) {
            /**
             * @var \app\models\Pair $pair
             */
            $pair->name = $pair->participantOne->name . ' & ' . $pair->participantTwo->name;
            $pair->save(false);
        }
    }

    public function down()
    {
        echo "m141207_144204_add_name_col_to_pairs cannot be reverted.\n";

        return false;
    }
}
