<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Payment;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Fill up the balance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'created_at:date',
            [
                'attribute' => 'player_id',
                'value' => function ($data) {
                    /** @var \app\models\Payment $data */
                    return $data->player->name;
                }
            ],
            'sum',
            [
                'attribute' => 'match_id',
                'value' => function ($data) {
                    /** @var \app\models\Payment $data */
                    if ($data->match) {
                        return Html::a($data->match->getMatchName('<br/>'), ['/match/view', 'id' => $data->match_id]);
                    }
                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
