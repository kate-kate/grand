<?php
namespace app\commands;

use app\models\Match;
use app\models\Pair;
use app\models\Participant;
use yii\console\Controller;

class GrandController extends Controller
{

    public function actionGeneratePairs ()
    {
        Match::deleteAll();
        Pair::deleteAll();
        $participantsFirstArray = $participantsSecondArray = Participant::find()->indexBy('id')->all();
        foreach ($participantsFirstArray as $i1 => $p1) {
            foreach ($participantsSecondArray as $i2 => $p2) {
                if ($i2 !== $i1) {
                    $pair = new Pair();
                    $pair->participant_id_1 = $i1;
                    $pair->participant_id_2 = $i2;
                    if ($pair->save(false)) {
                        echo $p1->name . " - " . $p2->name . "\n";
                    }
                }
            }
            unset($participantsSecondArray[$i1]);
        }
    }

    public function actionGenerateMatches()
    {
        Match::deleteAll();
        $pairsFirstArray = $pairsSecondArray = Pair::find()->indexBy('id')->all();
        $matchesArray = array();
        foreach ($pairsFirstArray as $i1 => $pair1) {
            foreach ($pairsSecondArray as $i2 => $pair2) {
                if ($pair1->participant_id_1 !== $pair2->participant_id_1
                    && $pair1->participant_id_1 !== $pair2->participant_id_2
                    && $pair1->participant_id_2 !== $pair2->participant_id_1
                    && $pair1->participant_id_2 !== $pair2->participant_id_2
                ) {
                    $matchesArray[] = ['pair1' => $pair1->id, 'pair2' => $pair2->id];
                }
            }
            unset($pairsSecondArray[$i1]);
        }
        shuffle($matchesArray);
        shuffle($matchesArray);
        shuffle($matchesArray);
        foreach ($matchesArray as $pairs) {
            $match = new Match();
            $match->pair_id_1 = $pairs['pair1'];
            $match->pair_id_2 = $pairs['pair2'];
            $match->save(false);
        }
        echo count($matchesArray)."\n";
    }
}
