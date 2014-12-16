<?php
$this->title = 'Public activities';

?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_view',
    'layout' => "{items}\n{pager}",
])?>
