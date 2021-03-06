<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Payment;
use app\models\Participant;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <? if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Fill up the balance', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

    <? endif ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'created_at:date',
            [
                'attribute' => 'player_id',
                'value' => function ($data) {
                    /** @var \app\models\Payment $data */
                    return $data->player->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'player_id', Participant::getAllPlayersList(),
                    ['class' => 'form-control', 'prompt' => ''])
            ],
            'sum',
            'status',
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}'
            ],
        ],
    ]); ?>

</div>
