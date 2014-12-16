<?php
$this->title = 'Public activities';

?>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_view'
])?>
