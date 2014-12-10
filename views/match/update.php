<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Match */

$this->title = $model->getMatchName();
$this->params['breadcrumbs'][] = ['label' => 'Matches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="match-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <? if ($model->checkCredits()): ?>
        <h4 class="text-success">All credits are available and would be automatically taken from balance after saving results</h4>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    <? else: ?>
        <h4 class="text-danger">Credits are not available from:</h4>
        <ol>
            <? foreach ($model->getUncreditablePlayers() as $name): ?>
                <li><?= $name ?></li>
            <? endforeach ?>
        </ol>
    <?endif ?>

</div>
