<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */


if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR || User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_SUPERVISOR){
	$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
	$this->params['breadcrumbs'][] = 'Update Schedule';
} else{
	$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['viewschedule']];
	$this->params['breadcrumbs'][] = 'Update Schedule';
}
?>
<div class="schedule-update">

    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
