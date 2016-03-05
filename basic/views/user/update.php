<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
	$this->title = 'Update User';
	$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
	$this->params['breadcrumbs'][] = 'Update';
} else{
	$this->title = 'Update User';
	$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['view', 'id' => $model->user_id]];
	$this->params['breadcrumbs'][] = 'Update';
}
	
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
