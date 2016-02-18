<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Management */

$this->title = 'Edit Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['view', 'id' => $model->management_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="management-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
