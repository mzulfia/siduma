<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use app\models\SupportPosition;
use app\models\ServiceFamily;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Management */

$this->title = 'Managements | Update Profile';
$this->params['breadcrumbs'][] = ['label' => 'Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Profile';
?>
<div class="management-update">
	<div class="box box-info">
	    <div class="box-header">
	      <h3 class="box-title">Update Profile</h3>
	    </div>
	    <div class="box-body">

	        <?php $form = ActiveForm::begin([
	            'id' => 'management-form', 
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
	        

	        <?= $form->field($model, 'mgt_name')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	        
	        <div class="form-group">
	            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	        </div>

	        <?php ActiveForm::end(); ?>
	    </div>
	</div>   
</div> 
    