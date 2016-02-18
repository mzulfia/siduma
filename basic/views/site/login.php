<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin();?>
    <form role="form" action="" method="post" class="login-form">
    <div class="form-group">
        <?= $form->field($model, 'username')->textInput() ?> 
        <?= $form->field($model, 'password')->passwordInput()?>
        <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
                          

                        
       