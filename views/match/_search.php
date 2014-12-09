<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\MatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="match-search col-lg-6">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'players')->checkboxList($model->getPlayersList()) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div style="clear:both"></div>
<br/>
