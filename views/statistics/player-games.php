<?
use app\models\Match;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="statistics-sheet">
    <h4>Games Played by <?= $player->name ?></h4>
    <?= GridView::widget([
        'dataProvider' => $gamesPlayedProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date:date',
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
        ]
    ]) ?>

    <h4>Games Left</h4>
    <?= GridView::widget([
        'dataProvider' => $gamesLeftProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'pair_id_1',
                'label' => 'Pair One',
                'value' => function ($data) {
                    /**
                     * @var Match $data
                     */
                    return $data->pairOne->getFullName();
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'pair_id_2',
                'label' => 'Pair Two',
                'value' => function ($data) {
                    return $data->pairTwo->getFullName();
                },
                'format' => 'raw'
            ],
        ]
    ]) ?>

</div>