<?php

use yii\helpers\Html;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Pic */

if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
	$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
	$this->params['breadcrumbs'][] = 'Update Profile';
} else{
	$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['view', 'id' => $model->support_id]];
	$this->params['breadcrumbs'][] = 'Update Profile';
}

?>
<div class="support-update">
	<?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
