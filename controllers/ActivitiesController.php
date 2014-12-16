<?php

namespace app\controllers;

use app\models\Activity;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ActivitiesController extends Controller
{
    
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Activity::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 30],
        ]);
        return $this->render('index', ['provider' => $provider]);
    }
}
