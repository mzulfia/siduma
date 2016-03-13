<?php

namespace app\controllers;

use Yii;
use app\models\PlnPic;
use app\models\PlnPicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use app\models\User;
use app\models\PicArea;
use app\components\AccessRules;
use yii\filters\AccessControl;

 
/**
 * PlnPicController implements the CRUD actions for PlnPic model.
 */
class PlnPicController extends Controller
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
                    ],
                ],
        ];
    }

    /**
     * Lists all PlnPic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlnPicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlnPic model.
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
     * Creates a new PlnPic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlnPic();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file)){
                $ext =  end((explode(".", $model->file->name)));
                $filename = Yii::$app->security->generateRandomString();
                $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                if($model->save()){
                    $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                    Image::getImagine()->open(PlnPic::getProfilePicture($model->pln_pic_id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                    Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 3000,
                         'icon' => 'fa fa-user',
                         'message' => 'Create Success',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                    ]);  

                    return $this->redirect(['view', 'id' => $model->pln_pic_id]);
                } else {
                    Yii::$app->getSession()->setFlash('danger', [
                         'type' => 'danger',
                         'duration' => 3000,
                         'icon' => 'fa fa-user',
                         'message' => 'Create Failed',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                    ]);  

                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }  

            } else{
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', [
                         'type' => 'success',
                         'duration' => 3000,
                         'icon' => 'fa fa-user',
                         'message' => 'Create Success',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                    ]);  

                    return $this->redirect(['view', 'id' => $model->pln_pic_id]);
                } else {
                    Yii::$app->getSession()->setFlash('danger', [
                         'type' => 'danger',
                         'duration' => 3000,
                         'icon' => 'fa fa-user',
                         'message' => 'Create Failed',
                         'title' => 'Notification',
                         'positonY' => 'top',
                         'positonX' => 'right'
                    ]);  

                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
            
            return $this->redirect(['view', 'id' => $model->pln_pic_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PlnPic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->pic_area = \yii\helpers\ArrayHelper::getColumn(
            $model->getPicAreas()->asArray()->all(), 'service_family_id'
        );

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file)){
                $ext =  end((explode(".", $model->file->name)));
                $filename = Yii::$app->security->generateRandomString();
                if(!empty($model->image_path)){
                    $plnpic = PlnPic::findOne($id);
                    $plnpic->deleteImage();
                    $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                    if($model->update()){
                        $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                        Image::getImagine()->open(PlnPic::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                        Yii::$app->getSession()->setFlash('success', [
                             'type' => 'success',
                             'duration' => 3000,
                             'icon' => 'fa fa-user',
                             'message' => 'Update Success',
                             'title' => 'Notification',
                             'positonY' => 'top',
                             'positonX' => 'right'
                        ]);  

                        return $this->redirect(['view', 'id' => $model->pln_pic_id]);
                    } else {
                         Yii::$app->getSession()->setFlash('danger', [
                             'type' => 'danger',
                             'duration' => 3000,
                             'icon' => 'fa fa-user',
                             'message' => 'Create Failed',
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
                    if($model->update()){
                        $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                        Image::getImagine()->open(PlnPic::getProfilePicture($id))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                        Yii::$app->getSession()->setFlash('success', [
                             'type' => 'success',
                             'duration' => 3000,
                             'icon' => 'fa fa-user',
                             'message' => 'Update Success',
                             'title' => 'Notification',
                             'positonY' => 'top',
                             'positonX' => 'right'
                        ]);  

                        return $this->redirect(['view', 'id' => $model->pln_pic_id]);
                    } else {
                        Yii::$app->getSession()->setFlash('danger', [
                             'type' => 'danger',
                             'duration' => 3000,
                             'icon' => 'fa fa-user',
                             'message' => 'Create Failed',
                             'title' => 'Notification',
                             'positonY' => 'top',
                             'positonX' => 'right'
                        ]);  
                        return $this->render('create', [
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

                    return $this->redirect(['view', 'id' => $model->pln_pic_id]);
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
            
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PlnPic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       $model = $this->findModel($id);
        if($model->deleteImage()){
          $model->delete();
          
          $size = Yii::$app->getDb()->createCommand('SELECT COUNT(*) AS total FROM pln_pic')->queryAll();
          $next_id = ((int) $size[0]['total']) + 1;
          Yii::$app->getDb()->createCommand('ALTER TABLE pln_pic AUTO_INCREMENT = :id', [':id' => $next_id])->execute();

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
     * Finds the PlnPic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlnPic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlnPic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
