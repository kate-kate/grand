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
            [
                'attribute' => 'pair_id_1',
                'label' => 'Pair One',
                'value' => function ($data) {
                    /**
                     * @var Match $data
                     */
                    return $data->pairOne->name;
                }
            ],
            [
                'attribute' => 'pair_id_2',
                'label' => 'Pair Two',
                'value' => function ($data) {
                    /**
                     * @var Match $data
                     */
                    return $data->pairTwo->name;
                }
            ],
            [
                'attribute' => 'winner_id',
                'label' => 'Winner',
                'value' => function ($data) {
                    if ($data->winner) {
                        return $data->winner->name;
                    }
                }
            ],
            'status',
            // 'date',
            // 'part_winner_id_1',
            // 'part_winner_id_2',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view}'
            ],
        ],
    ]); ?>

</div>
