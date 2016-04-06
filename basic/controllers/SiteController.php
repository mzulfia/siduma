<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Schedule;
use app\models\User;
use app\models\ServiceFamily;
use app\models\DmReport;
use app\models\Management;
use app\models\PlnPic;
use app\components\AccessRules;


class SiteController extends Controller
{
    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'access' => [
               'class' => AccessControl::className(),
               'ruleConfig' => [
                   'class' => AccessRules::className(),
               ],
               'only' => ['index','login', 'logout', 'contact'],
               'rules' => [
                   [
                       'actions' => ['index','login', 'logout', 'contact'],
                       'allow' => true,
                       'roles' => ['@']
                   ],
                   [
                       'actions' => ['login'],
                       'allow' => true,
                       'roles' => ['?']
                   ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id=='error')
                 $this->layout ='errorLayout';
            return true;
        } else {
            return false;
        }
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'dashboard';
        
        $schedule = new Schedule();
        $DmReport = new DmReport();

        return $this->render('index');
     }

     public function actionIndexSupport()
    {
        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionLogin()
    {
        $this->layout = 'signin';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        } else {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {

                Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 3000,
                         'icon' => 'fa fa-sign-in',
                         'message' => 'Login Success',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                        ]);

                return $this->redirect(['index']);
            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);    
            }
        }
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->getId();
        
        Yii::$app->user->logout(); 

        $note = '';
        if(User::getRoleId($user) == User::ROLE_SUPPORT){
            $schedule = Schedule::getNextSchedule(User::getSupportId($user));
            $is_dm = 'Tidak';
            $note = '';
            if(isset($schedule)){
                if($schedule->is_dm == 1)
                    $is_dm = 'Ya';    
                
                $note = 'Shift: ' . $schedule->shift->shift_name . ', Time: ' . $schedule->shift->shift_start . ' s.d. ' . $schedule->shift->shift_end . ', Duty Manager: ' .  $is_dm ;
            } else {
                $note = 'Besok Anda Libur';
            }
            
            Yii::$app->getSession()->setFlash('warning', [
                 'type' => 'warning',
                 'duration' => 10000,
                 'icon' => 'fa fa-sticky-note',
                 'message' => $note,
                 'title' => 'Reminder for Tomorrow',
                 'positonY' => 'top',
                 'positonX' => 'center'
            ]);
        } else {
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-sign-out',
             'message' => 'Logout Success',
             'title' => 'Notification',
             'positonY' => 'top',
             'positonX' => 'right'
            ]);
        }
        
        return $this->redirect(['site/login']);
    }

    public function actionContact()
    {
        $management = Management::find()->all();
        $plnpic = PlnPic::find()->all();
        return $this->render('contact', [
            'management' => $management,
            'plnpic' => $plnpic
        ]);
    }
}
