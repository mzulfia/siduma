<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Supervisor;

$this->title = "Supervisors | View Profile";
$this->params['breadcrumbs'][] = "View Profile";
?>
<div class="supervisor-viewUnauthorized">

    <div class="profile-picture">
        <?= Html::img(Yii::$app->homeUrl . Supervisor::getProfilePicture($model->management_id), ['class' => 'img-circle', 'alt' => 'Supervisor Image']);?>
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
