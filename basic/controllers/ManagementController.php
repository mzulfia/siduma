<?php

namespace app\controllers;

use Yii;
use app\models\Management;
use app\models\ManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use app\models\User;
use app\components\AccessRules;
use yii\filters\AccessControl;

 

/**
 * ManagementController implements the CRUD actions for Management model.
 */
class ManagementController extends Controller
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
                                User::ROLE_MANAGEMENT,
                           ],
                       ],
                       [
                           'actions' => ['view'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_SUPERVISOR,
                               User::ROLE_SUPPORT,
                           ],
                       ],
                    ],
                ],
        ];
    }

    /**
     * Lists all Management models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Management model.
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
     * Creates a new Management model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Management();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file)){
                $ext =  end((explode(".", $model->file->name)));
                $filename = Yii::$app->security->generateRandomString();
                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                if($model->save()){
                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                    Image::getImagine()->open(Management::getProfilePicture($model->management_id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 
                }   
            } else{
                $model->save();
            }
            
            return $this->redirect(['view', 'id' => $model->management_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Management model.
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
                        $filename = Yii::$app->security->generateRandomString();
                        if(!empty($model->image_path)){
                            $mgt = Management::findOne($id);
                            $mgt->deleteImage();
                            $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                            if($model->update()){
                                $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                Image::getImagine()->open(Management::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                 ]);    
                                return $this->redirect(['view', 'id' => $model->management_id]);
                                

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
                                Image::getImagine()->open(Management::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                 ]);  

                                return $this->redirect(['view', 'id' => $model->management_id]);
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

                            return $this->redirect(['view', 'id' => $model->management_id]);
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
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }    
            }
            else
            {
                if(User::getManagementId(Yii::$app->user->getId()) == $id)
                {
                    $model = $this->findModel($id);
           
                    if ($model->load(Yii::$app->request->post())) {
                        $model->file = UploadedFile::getInstance($model, 'file');
                        if(!is_null($model->file)){
                            $ext =  end((explode(".", $model->file->name)));
                            $filename = $model->file->baseName;
                            if(!empty($model->image_path)){
                                $mgt = Management::findOne($id);
                                $mgt->deleteImage();
                                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                                if($model->update()){
                                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                                    Image::getImagine()->open(Management::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                    Yii::$app->getSession()->setFlash('success', [
                                     'type' => 'success',
                                     'duration' => 3000,
                                     'icon' => 'fa fa-user',
                                     'message' => 'Update Success',
                                     'title' => 'Notification',
                                     'positonY' => 'top',
                                     'positonX' => 'right'
                                 ]);  

                                return $this->redirect(['view', 'id' => $model->management_id]);
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
                                    Image::getImagine()->open(Management::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                                    Yii::$app->getSession()->setFlash('success', [
                                         'type' => 'success',
                                         'duration' => 3000,
                                         'icon' => 'fa fa-user',
                                         'message' => 'Update Success',
                                         'title' => 'Notification',
                                         'positonY' => 'top',
                                         'positonX' => 'right'
                                    ]);  
                                    return $this->redirect(['view', 'id' => $model->management_id]);
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
                            $model->update();
                        }
                        
                        return $this->redirect(['view', 'id' => $model->management_id]);
                    } else {
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

                            return $this->redirect(['view', 'id' => $model->management_id]);
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
                }
                else
                {
                    return $this->redirect(['update', 'id' => User::getManagementId(Yii::$app->user->getId())]);
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
     * Deletes an existing Management model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteImage();
        $this->findModel($id)->delete();

        $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM management')->queryAll();
        $next_id = ((int) $size[0]['total']) + 1;
        Yii::$app->getDb()->createCommand('ALTER TABLE management AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Management model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Management the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Management::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
