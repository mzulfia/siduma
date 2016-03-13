<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use app\models\SupportPosition;
use app\models\ServiceFamily;
use app\models\User;

if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
	$this->title = 'Supports | Update Support';
	$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
	$this->params['breadcrumbs'][] = 'Update Profile';
} else{
	$this->title = 'Supports | Update Support';
	$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['view', 'id' => $model->support_id]];
	$this->params['breadcrumbs'][] = 'Update Profile';
}
?>

<div class="support-update">
	<div class="box box-info">
	    <div class="box-header">
	      <h3 class="box-title">Update Profile</h3>
	    </div>
	    <div class="box-body">

	        <?php $form = ActiveForm::begin([
	            'id' => 'support-form', 
	            'options' =>[ 
	                'enctype' => 'multipart/form-data',
	            ],
	        ]); ?>

	        <?=
	            $form->field($model, 'file')->widget(FileInput::classname(),[ 
	                     'pluginOptions' => [
	                         'showCaption' => false,
	                         'showRemove' => false,
	                         'showUpload' => false,
	                         'browseClass' => 'btn btn-primary btn-block',
	                         'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
	                         'browseLabel' =>  'Select Photo',
	                         'allowedFileExtensions'=>['jpg','png']
	                     ],
	                     'options' => ['accept' => 'image/*'],
	                 ]);
	            ?>
	        <p>Accepted File: jpg, png; Max Size: 200KB; Pixel Size: 200x200px</p>
	        

	        <?= $form->field($model, 'support_name')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'support_position_id')->dropDownList(ArrayHelper::map(SupportPosition::find()->all(), 'support_position_id', 'position_name'), ['prompt'=>'-Select Position-']) ?>

	        <?= $form->field($model, 'support_area')->checkboxList(ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'), ['inline'=>true]) ?>
	        
	        <div class="form-group">
	            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	        </div>

	        <?php ActiveForm::end(); ?>
	    </div>
	</div>   
</div> 
    