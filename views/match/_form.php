<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Match */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="match-form col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model) ?>

    <h3>
        Pair One: <b><?= $model->pairOne->name ?></b>
    </h3>
    <?= $form->field($model, "score[{$model->pairOne->id}]") ?>

    <h3>
        Pair Two: <b><?= $model->pairTwo->name ?></b>
    </h3>
    <?= $form->field($model, "score[{$model->pairTwo->id}]") ?>

    <br/>

    <?= $form->field($model, 'winner_id')->dropDownList($model->getPairsList(), ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
