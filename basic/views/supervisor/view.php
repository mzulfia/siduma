<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Supervisor;


$this->title = "Supervisors | View Profile";
$this->params['breadcrumbs'][] = 'View Profile';
?>
<div class="supervisor-view">

    <h1>View Profile</h1>

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
