<?php

namespace app\controllers;

use Yii;
use app\models\Support;
use app\models\SupportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\components\AccessRules;
use yii\filters\AccessControl;



use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use app\models\User;
use app\models\SupportArea;
 


/**
 * SupportController implements the CRUD actions for Support model.
 */
class SupportController extends Controller
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
               'only' => ['index','create', 'update', 'delete', 'view'],
               'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMINISTRATOR, 
                           ],
                       ],
                       [
                           'actions' => ['update', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPPORT,
                           ],
                       ],
                       [
                           'actions' => ['index', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_MANAGEMENT,
                               User::ROLE_SUPERVISOR,
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all Support models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Support model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('viewUnauthorized', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Support model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Support();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file)){
                $ext =  end((explode(".", $model->file->name)));
                $filename = Yii::$app->security->generateRandomString();
                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                if($model->save()){
                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                    Image::getImagine()->open(Support::getProfilePicture($model->support_id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 
                }   
            } else{
                $model->save();
            }
            
            return $this->redirect(['view', 'id' => $model->support_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Support model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        try
        {
            if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR)
            {
                $model = $this->findModel($id);
                $model->support_area = \yii\helpers\ArrayHelper::getColumn(
                    $model->getService()->asArray()->all(), 'service_family_id'
                );

                if ($model->load(Yii::$app->request->post())) {
                    $model->file = UploadedFile::getInstance($model, 'file');
                    if(!is_null($model->file)){
                        $ext =  end((explode(".", $model->file->name)));
                        $filename = Yii::$app->security->generateRandomString();
                        if(!empty($model->image_path)){
                            $mgt = Support::findOne($id);
                            $mgt->deleteImage();
                            $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                            if($model->update()){
                                $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                Image::getImagine()->open(Support::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);    
                                    
                                return $this->redirect(['view', 'id' => $model->support_id]);

                            } else {
                                Yii::$app->getSession()->setFlash('danger', [
                                     'type' => 'danger',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Failed',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);    

                                return $this->render('update', [
                                    'model' => $model,
                                ]);
                            }
                        }
                        else
                        {
                            $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                            if($model->update()){
                                $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                Image::getImagine()->open(Support::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);  

                                return $this->redirect(['view', 'id' => $model->support_id]);  
                            } else {
                                Yii::$app->getSession()->setFlash('danger', [
                                     'type' => 'danger',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Failed',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);  

                                return $this->render('update', [
                                    'model' => $model,
                                ]);
                            }   
                        }
                    } else{
                        if($model->update()){
                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);  

                                return $this->redirect(['view', 'id' => $model->support_id]);  
                            } else {
                                Yii::$app->getSession()->setFlash('danger', [
                                     'type' => 'danger',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Failed',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);  

                                return $this->render('update', [
                                    'model' => $model,
                                ]);
                            }
                    }
                    
                    return $this->redirect(['view', 'id' => $model->support_id]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }
            else
            {
                if(User::getSupportId(Yii::$app->user->getId()) == $id)
                {
                    $model = $this->findModel($id);
                    $model->support_area = \yii\helpers\ArrayHelper::getColumn(
                        $model->getService()->asArray()->all(), 'service_family_id'
                    );

                    if ($model->load(Yii::$app->request->post())) {
                        $model->file = UploadedFile::getInstance($model, 'file');
                        if(!is_null($model->file)){
                            $ext =  end((explode(".", $model->file->name)));
                            $filename = Yii::$app->security->generateRandomString();
                            if(!empty($model->image_path)){
                                $mgt = Support::findOne($id);
                                $mgt->deleteImage();
                                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                                if($model->update()){
                                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                    Image::getImagine()->open(Support::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'success',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Success',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);    
                                        
                                    return $this->redirect(['view', 'id' => $model->support_id]);

                                } else {
                                    Yii::$app->getSession()->setFlash('danger', [
                                         'type' => 'danger',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Failed',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);    

                                    return $this->render('update', [
                                        'model' => $model,
                                    ]);
                                }
                            }
                            else
                            {
                                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                                if($model->update()){
                                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                    Image::getImagine()->open(Support::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'success',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Success',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);  

                                    return $this->redirect(['view', 'id' => $model->support_id]);  
                                } else {
                                    Yii::$app->getSession()->setFlash('danger', [
                                         'type' => 'danger',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Failed',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);  

                                    return $this->render('update', [
                                        'model' => $model,
                                    ]);
                                }   
                            }
                        } else{
                            if($model->update()){
                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'success',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Success',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);  

                                    return $this->redirect(['view', 'id' => $model->support_id]);  
                                } else {
                                    Yii::$app->getSession()->setFlash('danger', [
                                         'type' => 'danger',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Failed',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);  

                                    return $this->render('update', [
                                        'model' => $model,
                                    ]);
                                }
                        }
                        
                        return $this->redirect(['view', 'id' => $model->support_id]);
                    } else {
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
                }
                else
                {
                    return $this->redirect(['update', 'id' => User::getSupportId(Yii::$app->user->getId())]);
                }
            }
        } catch(\yii\base\Exception $e){
            Yii::$app->getSession()->setFlash('danger', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'icon' => 'fa fa-user',
                 'message' => 'Update Failed',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'right'
             ]);    
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Support model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteImage();
        $this->findModel($id)->delete();

        $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM support')->queryAll();
        $next_id = ((int) $size[0]['total']) + 1;
        Yii::$app->getDb()->createCommand('ALTER TABLE support AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Support model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Support the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Support::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
