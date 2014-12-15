<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Match */

$this->title = $model->getMatchName();
$this->params['breadcrumbs'][] = ['label' => 'Matches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="match-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date:datetime',
            'status',
            [
                'attribute' => 'winner_id',
                'value' => $model->winner ? $model->winner->name : null
            ],
            [
                'attribute' => 'score',
                'value' => $model->winner ? $model->winner_score . ' : ' . $model->looser_score : null
            ]
        ],
    ]) ?>

</div>
