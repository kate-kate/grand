<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Match;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="match-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date:datetime',
            [
                'attribute' => 'pair_id_1',
                'label' => 'Pair One',
                'value' => function ($data) {
                    /**
                     * @var Match $data
                     */
                    $content = $data->pairOne->getFullName();
                    if ($data->status == Match::MATCH_STATUS_PLAYED) {
                        $content = Html::tag('span', $content,
                            ['class' => $data->pairOne->id == $data->winner->id ? 'winner' : 'looser']);
                    }
                    return $content;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'pair_id_2',
                'label' => 'Pair Two',
                'value' => function ($data) {
                    /**
                     * @var Match $data
                     */
                    $content = $data->pairTwo->getFullName();
                    if ($data->status == Match::MATCH_STATUS_PLAYED) {
                        $content = Html::tag('span', $content,
                            ['class' => $data->pairTwo->id == $data->winner->id ? 'winner' : 'looser']);
                    }
                    return $content;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'score',
                'value' => function ($data) {
                    /**
                     * @var Match $data
                     */
                    if ($data->status == Match::MATCH_STATUS_PLAYED) {
                        if ($data->winner_id == $data->pair_id_1) {
                            $content = $data->winner_score . ' : ' . $data->looser_score;
                        } else {
                            $content = $data->looser_score . ' : ' . $data->winner_score;
                        }
                        return $content;
                    }
                }
            ],
            'status',
            // 'date',
            // 'part_winner_id_1',
            // 'part_winner_id_2',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->isGuest ? '{view}' : '{update} {view}'
            ],
        ],
    ]); ?>

</div>
