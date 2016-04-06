<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Management;

$this->title = "Managements | Profile";
$this->params['breadcrumbs'][] = 'Profile';
?>
<div class="management-viewUnauthorized">

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
