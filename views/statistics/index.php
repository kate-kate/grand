<div class="statistics-sheet">
    <h1>Statistics</h1>

    <div>
        <h3>Games played (<?= $played ?> of <?= $all ?>)</h3>

        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percent ?>" aria-valuemin="0"
                 aria-valuemax="100"
                 style="width: <?= $percent ?>%;">
                <?= $percent ?>%
            </div>
        </div>
    </div>

    <div>
        <h3>Pairs Statistics</h3>
        <hr/>
        <h4>1. Common tournament statistics</h4>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $pairsDataProvider,
            'layout' => "{items}\n{pager}",
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($key < 3) {
                    return ['class' => 'leaders'];
                } elseif ($key < 5) {
                    return ['class' => 'great-five'];
                } elseif ($key < 10) {
                    return ['class' => 'good-ten'];
                }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'wins',
                'matches',
                'score',
                'missed_points'
            ]
        ]) ?>

        <h4>2. Percentage statistics (percent of games won)</h4>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $percentPairsDataProvider,
            'layout' => "{items}\n{pager}",
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($key < 3) {
                    return ['class' => 'leaders'];
                } elseif ($key < 5) {
                    return ['class' => 'great-five'];
                } elseif ($key < 10) {
                    return ['class' => 'good-ten'];
                }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'percent',
                'matches'
            ]
        ]) ?>
    </div>

    <div>
        <h3>Personal statistics</h3>
        <hr/>
        <h4>1. Common</h4>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $personalDataProvider,
            'layout' => "{items}\n{pager}",
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($key < 3) {
                    return ['class' => 'leaders'];
                } elseif ($key < 5) {
                    return ['class' => 'great-five'];
                } elseif ($key < 10) {
                    return ['class' => 'good-ten'];
                }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'wins',
                'matches',
                'score',
                'missed_points',
            ]
        ]) ?>

        <h4>2. Percentage</h4>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $personalPercentDataProvider,
            'layout' => "{items}\n{pager}",
            'rowOptions' => function ($model, $key, $index, $grid) {
                if ($key < 3) {
                    return ['class' => 'leaders'];
                } elseif ($key < 5) {
                    return ['class' => 'great-five'];
                } elseif ($key < 10) {
                    return ['class' => 'good-ten'];
                }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'percent',
                'matches'
            ]
        ]) ?>
    </div>

</div>