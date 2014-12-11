<?php

namespace app\controllers;

use app\models\Match;
use app\models\Pair;
use app\models\Participant;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class StatisticsController extends Controller
{

    public function actionIndex()
    {
        $played = Match::find()->where(['status' => Match::MATCH_STATUS_PLAYED])->count();
        $all = Match::find()->count();
        $percent = round($played / ($all / 100), 2);

        $pairsQuery = Pair::find()->select([
            'pair.id',
            'pair.name',
            'COUNT(IF(match.winner_id=pair.id, 1, NULL)) AS wins',
            'SUM(IF(match.winner_id=pair.id,winner_score, 0)) + SUM(IF(match.looser_id=pair.id,looser_score, 0)) as score',
            'COUNT(match.id) AS matches',
            'SUM(IF(match.winner_id=pair.id,looser_score, 0)) + SUM(IF(match.looser_id=pair.id,winner_score, 0)) AS missed_points'
        ])
            ->asArray()
            ->leftJoin('match', 'pair.id=match.pair_id_1 OR pair.id=match.pair_id_2')
            ->where('match.status=:played', [':played' => Match::MATCH_STATUS_PLAYED])
            ->groupBy('pair.id')
            ->orderBy(['wins' => SORT_DESC, 'matches' => SORT_ASC, 'score' => SORT_DESC, 'missed_points' => SORT_ASC])
            ->all();
        $pairsDataProvider = new ArrayDataProvider([
            'models' => $pairsQuery
        ]);

        $percentPairsQuery = Pair::find()
            ->select([
                'pair.id',
                'pair.name',
                'COUNT(match.id) AS matches',
                'COUNT(IF(match.winner_id=pair.id, 1, NULL)) / (COUNT(match.id) / 100) as percent'
            ])
            ->asArray()
            ->leftJoin('match', 'pair.id=match.pair_id_1 OR pair.id=match.pair_id_2')
            ->where('match.status=:played', [':played' => Match::MATCH_STATUS_PLAYED])
            ->groupBy('pair.id')
            ->orderBy(['percent' => SORT_DESC, 'matches' => SORT_DESC])
            ->all();
        $percentPairsDataProvider = new ArrayDataProvider([
            'models' => $percentPairsQuery
        ]);


        $personalQuery = Participant::find()
            ->select([
                'participant.id',
                'participant.name',
                'COUNT(IF(match.winner_id=pair.id, 1, NULL)) AS wins',
                'SUM(IF(match.winner_id=pair.id,winner_score, 0)) + SUM(IF(match.looser_id=pair.id,looser_score, 0)) as score',
                'COUNT(match.id) AS matches',
                'SUM(IF(match.winner_id=pair.id,looser_score, 0)) + SUM(IF(match.looser_id=pair.id,winner_score, 0)) AS missed_points',
                'COUNT(IF(match.winner_id=pair.id, 1, NULL)) / (COUNT(match.id) / 100) as percent'
            ])
            ->asArray()
            ->leftJoin('pair', 'participant.id=pair.participant_id_1 OR participant.id=pair.participant_id_2')
            ->leftJoin('match', 'pair.id=match.pair_id_1 OR pair.id=match.pair_id_2')
            ->where('match.status=:played', [':played' => Match::MATCH_STATUS_PLAYED])
            ->groupBy('participant.id')
            ->orderBy(['wins' => SORT_DESC, 'matches' => SORT_ASC, 'score' => SORT_DESC, 'missed_points' => SORT_ASC])
            ->all();
        $personalDataProvider = new ArrayDataProvider([
            'models' => $personalQuery
        ]);

        $personalPercentQuery = Participant::find()
            ->select([
                'participant.id',
                'participant.name',
                'COUNT(match.id) AS matches',
                'COUNT(IF(match.winner_id=pair.id, 1, NULL)) / (COUNT(match.id) / 100) as percent'
            ])
            ->asArray()
            ->leftJoin('pair', 'participant.id=pair.participant_id_1 OR participant.id=pair.participant_id_2')
            ->leftJoin('match', 'pair.id=match.pair_id_1 OR pair.id=match.pair_id_2')
            ->where('match.status=:played', [':played' => Match::MATCH_STATUS_PLAYED])
            ->groupBy('participant.id')
            ->orderBy(['percent' => SORT_DESC, 'matches' => SORT_DESC])
            ->all();
        $personalPercentDataProvider = new ArrayDataProvider([
            'models' => $personalPercentQuery
        ]);

        return $this->render('index', [
            'percent' => $percent,
            'all' => $all,
            'played' => $played,
            'pairsDataProvider' => $pairsDataProvider,
            'percentPairsDataProvider' => $percentPairsDataProvider,
            'personalDataProvider' => $personalDataProvider,
            'personalPercentDataProvider' => $personalPercentDataProvider
        ]);
    }

}