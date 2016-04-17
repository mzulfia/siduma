<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\form\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\widgets\FileInput;
use app\models\SupportPosition;
use app\models\ServiceFamily;
use app\models\User;

$this->title = 'Supports | Create Support';
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Support';
?>

<div class="support-create">
	<div class="box box-info">
	    <div class="box-header with-border">
	      <h3 class="box-title">Create Support</h3>
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
	       <p>Accepted File: jpg, png; Max File Size: 200KB; Pixel Size: 225x225 px</p>
	        

	        <?= $form->field($model, 'support_name')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'support_position_id')->dropDownList(ArrayHelper::map(SupportPosition::find()->all(), 'support_position_id', 'position_name'), ['prompt'=>'-Select Position-']) ?>

	        <?php 
	        	if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){ 
	        		echo $form->field($model, 'support_area')->checkboxList(ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'), ['inline'=>true]);
	        	}
	        ?>
	        
	        <div class="form-group">
	            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	        </div>

	        <?php ActiveForm::end(); ?>
	    </div>
	</div>  
</div>

