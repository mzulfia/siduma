<?php

namespace app\controllers;

use Yii;
use app\models\Support;
use app\models\SupportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use app\models\User;
 


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
            $ext =  end((explode(".", $model->file->name)));
            $filename = Yii::$app->security->generateRandomString();
            $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
            if($model->save()){
                $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                Image::getImagine()->open(Support::getProfilePicture(User::getSupportId(Yii::$app->user->getId())))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 

                return $this->redirect(['view', 'id' => $model->support_id]);
            }
            else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            
            
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!is_null($model->file)){
                $ext =  end((explode(".", $model->file->name)));
                $filename = Yii::$app->security->generateRandomString();
                if(isset($model->image_path)){
                    $support = Support::findOne($id);
                    $support->deleteImage();
                    $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                    if($model->update()){
                        $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                        Image::getImagine()->open(Support::getProfilePicture(User::getSupportId(Yii::$app->user->getId())))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 
                    }
                }
                else
                {
                    $model->image_path =  'uploads/profile_pictures/' . $filename.".{$ext}";
                    if($model->update()){
                        $model->file->saveAs('uploads/profile_pictures/' . $filename .".{$ext}");   
                        Image::getImagine()->open(Support::getProfilePicture(User::getSupportId(Yii::$app->user->getId())))->thumbnail(new Box(400, 400))->save(getcwd() . '/uploads/profile_pictures/' . $filename .".{$ext}", ['quality' => 90]); 
                    }   
                }
            }  
            
            return $this->redirect(['view', 'id' => $model->support_id]);
        } else {
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

        return $this->redirect(['index']);
    }

    public function actionDeleteimage($id) {
        $model = Support::findOne($id);
        if ($model->deleteImage()) {
          Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-file-photo-o',
             'message' => 'Delete Success',
             'title' => 'Notification',
             'positonY' => 'top',
             'positonX' => 'right'
            ]);
        } else {
            Yii::$app->getSession()->setFlash('danger', [
                 'type' => 'warning',
                 'duration' => 3000,
                 'icon' => 'fa fa-file-photo-o',
                 'message' => 'Delete Failed',
                 'title' => 'Notification',
                 'positonY' => 'top',
                 'positonX' => 'center'
            ]);
        }
        // return $this->render('update', ['model'=>$model]);
        return $this->redirect(['update', 'id' => $id]);
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
