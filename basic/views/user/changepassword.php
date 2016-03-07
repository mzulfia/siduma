<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\password\PasswordInput;
use app\models\Role;

$this->title = 'Users | Change Password';
$this->params['breadcrumbs'][] = 'Change Password';

?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Change Password</h3>
  </div><!-- /.box-header -->
  <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'oldpass')->widget(PasswordInput::classname(), [
                'pluginOptions' => [
                    'showMeter' => false,
                    'toggleMask' => false
                ]
            ]) ?>

            <?= $form->field($model, 'newpass')->widget(PasswordInput::classname(), [
    		    'pluginOptions' => [
    		        'showMeter' => true,
    		        'toggleMask' => false
    		    ]
    		])->hint('Min. 8 Characters') ?>

            <?= $form->field($model, 'repeatnewpass')->widget(PasswordInput::classname(), [
                    'pluginOptions' => [
                        'showMeter' => false,
                        'toggleMask' => false
                    ]
                ])
            ?>

        <div class="form-group">
            <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
  </div>
</div>  

