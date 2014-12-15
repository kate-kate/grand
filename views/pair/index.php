<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Pair;
use app\models\Participant;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PairSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pairs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pair-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'participant_id_1',
                'value' => function ($data) {
                    /** @var Pair $data */
                    return $data->participantOne->name;
                }
            ],
            [
                'attribute' => 'participant_id_2',
                'value' => function ($data) {
                    /** @var Pair $data */
                    return $data->participantTwo->name;
                }
            ],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'visible' => !Yii::$app->user->isGuest
            ],
        ],
    ]); ?>

</div>
