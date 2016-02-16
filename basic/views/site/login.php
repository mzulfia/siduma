<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin();?>
    <?= $form->field($model, 'username')->textInput() ?>                                  
    <?= $form->field($model, 'password')->passwordInput() ?>
     <div class="form-group">
        <div class="col-sm-12 controls">
            <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
                          

                        
       