<div class="statistics-sheet">
    <h4>Games Played by <?= $player->alias ?> (<?= $player->name ?>)</h4>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $gamesPlayedProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date:date',
            [
                'attribute' => 'opponents',
                'value' => function ($data) use ($player) {
                    return $data->getOpponents($player->id);
                }
            ],
            [
                'attribute' => 'winner',
                'value' => function ($data) {
                    return $data->winner->name;
                }
            ]
        ]
    ]) ?>

    <h4>Games Left</h4>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $gamesLeftProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'opponents',
                'value' => function ($data) use ($player) {
                    return $data->getOpponents($player->id);
                }
            ],
        ]
    ]) ?>
</div>