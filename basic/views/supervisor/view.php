<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Supervisor;

if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
    $this->title = 'Supervisors | Profile';
    $this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
    $this->params['breadcrumbs'][] = 'Profile';
} else{
   $this->title = "Supervisors | Profile";
    $this->params['breadcrumbs'][] = 'Profile';
}
?>
<div class="supervisor-view">

    <h1>Profile</h1>

    <p>
        <?php if(User::getRoleId(Yii::$app->user->id) == User::ROLE_ADMINISTRATOR): ?>
            <?= Html::a('Update', ['update', 'id' => $model->supervisor_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->supervisor_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <div class="profile-picture">
        <?= Html::img(Yii::$app->homeUrl . Supervisor::getProfilePicture($model->supervisor_id), ['class' => 'img-circle', 'alt' => 'Management Image']);?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'spv_name',
            'no_hp',
            'email',
            'position'
        ],
    ]) ?>

</div>
