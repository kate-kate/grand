<div class="panel panel-default">
    <div class="panel-body">
        <small class="pull-right">
            <?= Yii::$app->getFormatter()->asDatetime($model->created_at) ?>
        </small>
        <?= $model->getDecorator()->render($this) ?>
    </div>
</div>
