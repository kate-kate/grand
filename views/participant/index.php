<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Participant;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participants';
?>
<div class="participant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    Participant::getStatusesList(), ['class' => 'form-control'])
            ],
            'balance',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'visible' => !Yii::$app->user->isGuest
            ],
        ],
    ]); ?>

</div>
