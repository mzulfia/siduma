<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Management;


if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
    $this->title = 'Managements | Profile';
    $this->params['breadcrumbs'][] = ['label' => 'Managements', 'url' => ['index']];
    $this->params['breadcrumbs'][] = 'Profile';
} else{
   $this->title = "Managements | Profile";
    $this->params['breadcrumbs'][] = 'Profile';
}
?>
<div class="management-view">

    <h1>Profile</h1>

    <p>
        <?php if(User::getRoleId(Yii::$app->user->id) == User::ROLE_ADMINISTRATOR): ?>
            <?= Html::a('Update', ['update', 'id' => $model->management_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->management_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <div class="profile-picture">
        <?= Html::img(Yii::$app->homeUrl . Management::getProfilePicture($model->management_id), ['class' => 'img-circle', 'alt' => 'Management Image']);?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mgt_name',
            'no_hp',
            'email',
            'position'
        ],
    ]) ?>

</div>
