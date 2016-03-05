<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use app\models\SupportPosition;
use app\models\ServiceFamily;
/* @var $this yii\web\View */
/* @var $model app\models\Pic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <div class="box-header">
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
        <p>Accepted File: jpg, png; Max Size: 200KB; Pixel Size: 200x200px</p>
        

        <?= $form->field($model, 'support_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'no_hp')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'support_position_id')->dropDownList(ArrayHelper::map(SupportPosition::find()->all(), 'support_position_id', 'position_name'), ['prompt'=>'-Select Position-']) ?>

        <?php //echo $form->field($model2, 'service_family_id')->checkboxList(ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'), ['inline'=>true]) ?>
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>    
        


<script>
// var btnCust = '<button type="button" class="btn btn-default" title="Add picture tags" ' + 
//     'onclick="alert(\'Call your custom code here.\')">' +
//     '<i class="glyphicon glyphicon-tag"></i>' +
//     '</button>'; 
// $("#avatar").fileinput({
//     overwriteInitial: true,
//     maxFileSize: 1500,
//     showClose: false,
//     showCaption: false,
//     browseLabel: '',
//     removeLabel: '',
//     browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
//     removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
//     removeTitle: 'Cancel or reset changes',
//     elErrorContainer: '#kv-avatar-errors',
//     msgErrorClass: 'alert alert-block alert-danger',
//     defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar" style="width:160px">',
//     layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
//     allowedFileExtensions: ["jpg", "png", "gif"]
// });
</script>