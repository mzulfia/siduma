<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = "Profile";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?php if(User::getRoleId(Yii::$app->user->id) == User::ROLE_ADMINISTRATOR): ?>
            <?= Html::a('Update', ['update', 'id' => $model->support_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->support_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'support_name',
            'company',
            'no_hp',
            'email',
            [
                'label' => 'Position',
                'value' => $model->pos->position_name
            ],
            // 'support_position_id',
        ],
    ]) ?>

</div>
