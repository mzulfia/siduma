<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Schedule;
use app\models\User;
use app\models\ServiceFamily;
use app\models\DmReport;

class SiteController extends Controller
{
    // $user = Yii::$app->user->getId();

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
        $this->layout = 'main';

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
            return $this->actionIndex();
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

                return $this->actionIndex();
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
                
                $note = 'Shift: ' . $schedule->shift->shift_name . ', Waktu: ' . $schedule->shift->shift_start . ' s.d. ' . $schedule->shift->shift_end . ', Duty Manager: ' .  $is_dm ;
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

        return $this->goHome();
        // return $this->redirect(['login']);
    }

    public function actionHistoryDmReport(){
        $model = new Schedule();
        $service_name = '';
        $ok_erp = 0.0;
        $bad_erp = 0.0;
        $ok_email = 0.0;
        $bad_email = 0.0;
        $ok_ap2t = 0.0;
        $bad_ap2t = 0.0;
        $ok_p2apst = 0.0;
        $bad_p2apst = 0.0;
        $ok_bbo = 0.0;
        $bad_bbo = 0.0;
        $ok_apkt = 0.0;
        $bad_apkt = 0.0;
        $ok_itsm = 0.0;
        $bad_itsm = 0.0;
        

        $date = date('Y-m-d');
        $ok_erp = (float) number_format((float)DmReport::getOkCondition($date, 1), 2, '.', '');
        $bad_erp = (float) number_format((float)DmReport::getBadCondition($date, 1), 2, '.', '');
        $ok_email = (float) number_format((float)DmReport::getOkCondition($date, 2), 2, '.', '');
        $bad_email = (float) number_format((float)DmReport::getBadCondition($date, 2), 2, '.', '');
        $ok_ap2t = (float) number_format((float)DmReport::getOkCondition($date, 3), 2, '.', '');
        $bad_ap2t = (float) number_format((float)DmReport::getBadCondition($date, 3), 2, '.', '');
        $ok_p2apst = (float) number_format((float)DmReport::getOkCondition($date, 4), 2, '.', '');
        $bad_p2apst = (float) number_format((float)DmReport::getBadCondition($date, 4), 2, '.', '');
        $ok_bbo = (float) number_format((float)DmReport::getOkCondition($date, 5), 2, '.', '');
        $bad_bbo = (float) number_format((float)DmReport::getBadCondition($date, 5), 2, '.', '');
        $ok_apkt = (float) number_format((float)DmReport::getOkCondition($date, 6), 2, '.', '');
        $bad_apkt = (float) number_format((float)DmReport::getBadCondition($date, 6), 2, '.', '');
        $ok_itsm = (float) number_format((float)DmReport::getOkCondition($date, 7), 2, '.', '');
        $bad_itsm = (float) number_format((float)DmReport::getBadCondition($date, 7), 2, '.', '');

        $date = '';
        if(isset($_POST['dashboard-button']) && $_POST['Schedule']['date'] != ''){
            $date = $_POST['Schedule']['date'];
            $ok_erp = (float) number_format((float)DmReport::getOkCondition($date, 1), 2, '.', '');
            $bad_erp = (float) number_format((float)DmReport::getBadCondition($date, 1), 2, '.', '');
            $ok_email = (float) number_format((float)DmReport::getOkCondition($date, 2), 2, '.', '');
            $bad_email = (float) number_format((float)DmReport::getBadCondition($date, 2), 2, '.', '');
            $ok_ap2t = (float) number_format((float)DmReport::getOkCondition($date, 3), 2, '.', '');
            $bad_ap2t = (float) number_format((float)DmReport::getBadCondition($date, 3), 2, '.', '');
            $ok_p2apst = (float) number_format((float)DmReport::getOkCondition($date, 4), 2, '.', '');
            $bad_p2apst = (float) number_format((float)DmReport::getBadCondition($date, 4), 2, '.', '');
            $ok_bbo = (float) number_format((float)DmReport::getOkCondition($date, 5), 2, '.', '');
            $bad_bbo = (float) number_format((float)DmReport::getBadCondition($date, 5), 2, '.', '');
            $ok_apkt = (float) number_format((float)DmReport::getOkCondition($date, 6), 2, '.', '');
            $bad_apkt = (float) number_format((float)DmReport::getBadCondition($date, 6), 2, '.', '');
            $ok_itsm = (float) number_format((float)DmReport::getOkCondition($date, 7), 2, '.', '');
            $bad_itsm = (float) number_format((float)DmReport::getBadCondition($date, 7), 2, '.', '');
        }        

        return $this->render('index', [
            'model' => $model,
            'date' => $date,
            'ok_erp' => $ok_erp,
            'bad_erp' => $bad_erp,
            'ok_email' => $ok_email,
            'bad_email' => $bad_email,
            'ok_ap2t' => $ok_ap2t,
            'bad_ap2t' => $bad_ap2t,
            'ok_p2apst' => $ok_p2apst,
            'bad_p2apst' => $bad_p2apst,
            'ok_bbo' => $ok_bbo,
            'bad_bbo' => $bad_bbo,
            'ok_apkt' => $ok_apkt,
            'bad_apkt' => $bad_apkt,
            'ok_itsm' => $ok_itsm,
            'bad_itsm' => $bad_itsm,
        ]);   

    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
