<?php

namespace app\controllers;

use Yii;
use app\models\SupportArea;
use app\models\SupportAreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\components\AccessRules;
use yii\filters\AccessControl;


/**
 * SupportAreaController implements the CRUD actions for SupportArea model.
 */
class SupportAreaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
               'class' => AccessControl::className(),
               'ruleConfig' => [
                   'class' => AccessRules::className(),
               ],
               'only' => ['index'],
               'rules' => [
                       [
                           'actions' => ['index'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR,
                               User::ROLE_SUPERVISOR, 
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all SupportArea models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupportAreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
