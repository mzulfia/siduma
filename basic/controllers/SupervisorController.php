<?php

namespace app\controllers;

use Yii;
use app\models\Supervisor;
use app\models\SupervisorSearch;
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
 
/**
 * SupervisorController implements the CRUD actions for Supervisor model.
 */
class SupervisorController extends Controller
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
                               User::ROLE_SUPERVISOR,
                           ],
                       ],
                       [
                           'actions' => ['index', 'view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_MANAGEMENT,
                               User::ROLE_SUPPORT,
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all Supervisor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupervisorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supervisor model.
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
            if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
                return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);
            } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_MANAGEMENT){
                return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);
            } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPERVISOR) {
                if(User::getSupervisorId(Yii::$app->user->getId()) == $id){
                    return $this->render('view', [
                        'model' => $this->findModel($id),
                    ]);
                } else {
                    return $this->redirect(['view', 'id' => User::getSupervisorId(Yii::$app->user->getId())]);    
                }
            } else {
                return $this->render('view', [
                    'model' => $this->findModel($id),
                ]);
            }
        }
    }

    /**
     * Creates a new Supervisor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Supervisor();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file)){
                $ext =  end((explode(".", $model->file->name)));
                $filename = Yii::$app->security->generateRandomString();
                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                if($model->save()){
                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                    Image::getImagine()->open(Supervisor::getProfilePicture($model->supervisor_id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 
                }   
            } else{
                $model->save();
            }
            
            return $this->redirect(['view', 'id' => $model->supervisor_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Supervisor model.
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
           
                if ($model->load(Yii::$app->request->post())) {
                    $model->file = UploadedFile::getInstance($model, 'file');
                    if(!is_null($model->file)){
                        $ext =  end((explode(".", $model->file->name)));
                        $filename = $model->file->baseName;
                        if(!empty($model->image_path)){
                            $spv = Supervisor::findOne($id);
                            $spv->deleteImage();
                            $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                            if($model->save()){
                                $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                Image::getImagine()->open(Supervisor::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);    
                                
                                return $this->redirect(['view', 'id' => $model->supervisor_id]);
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

                                return $this->render('create', [
                                    'model' => $model,
                                ]);
                            }
                        }
                        else
                        {
                            $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                            if($model->save()){
                                $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                Image::getImagine()->open(Supervisor::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);    
                                
                                return $this->redirect(['view', 'id' => $model->supervisor_id]);
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
                    } else {
                        if($model->save()){
                            Yii::$app->getSession()->setFlash('success', [
                                 'type' => 'success',
                                 'duration' => 3000,
                                 'icon' => 'fa fa-user',
                                 'message' => 'Update Success',
                                 'title' => 'Notification',
                                 'positonY' => 'top',
                                 'positonX' => 'right'
                            ]);    
                                
                            return $this->redirect(['view', 'id' => $model->supervisor_id]);
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
                    
                    return $this->redirect(['view', 'id' => $model->supervisor_id]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }
            else
            {
                if(User::getSupervisorId(Yii::$app->user->getId()) == $id)
                {
                    $model = $this->findModel($id);
           
                    if ($model->load(Yii::$app->request->post())) {
                        $model->file = UploadedFile::getInstance($model, 'file');
                        if(!is_null($model->file)){
                            $ext =  end((explode(".", $model->file->name)));
                            $filename = $model->file->baseName;
                            if(!empty($model->image_path)){
                                $spv = Supervisor::findOne($id);
                                $spv->deleteImage();
                                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                                if($model->save()){
                                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                    Image::getImagine()->open(Supervisor::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'success',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Success',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);    
                                    
                                    return $this->redirect(['view', 'id' => $model->supervisor_id]);
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

                                    return $this->render('create', [
                                        'model' => $model,
                                    ]);
                                }
                            }
                            else
                            {
                                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                                if($model->save()){
                                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                    Image::getImagine()->open(Supervisor::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'success',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Success',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);    
                                    
                                    return $this->redirect(['view', 'id' => $model->supervisor_id]);
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
                        } else {
                            if($model->save()){
                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                ]);    
                                    
                                return $this->redirect(['view', 'id' => $model->supervisor_id]);
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
                        
                        return $this->redirect(['view', 'id' => $model->supervisor_id]);
                    } else {
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
                }
                else
                {
                    return $this->redirect(['update', 'id' => User::getSupervisorId(Yii::$app->user->getId())]);
                }
            }
        } catch(\yii\base\Exception $e){
            $model = $this->findModel($id);
            
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
     * Deletes an existing Supervisor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       $model = $this->findModel($id);
       $model->deleteImage();
        if($model->delete()){
          $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM supervisor')->queryAll();
          $next_id = ((int) $size[0]['total']) + 1;
          Yii::$app->getDb()->createCommand('ALTER TABLE supervisor ALGORITHM=COPY, AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

          Yii::$app->getSession()->setFlash('success', [
               'type' => 'success',
               'duration' => 3000,
               'message' => 'Delete Success',
               'title' => 'Notification',
               'positonY' => 'top',
               'positonX' => 'right'
          ]);    

          return $this->redirect(['index']);
        } else {
            Yii::$app->getSession()->setFlash('danger', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'message' => 'Delete Failed',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'right'
            ]); 

            return $this->redirect(['index']);   
        }
    }

    /**
     * Finds the Supervisor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supervisor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supervisor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
