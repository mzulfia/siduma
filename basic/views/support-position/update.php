<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportPosition */

$this->title = 'Update Support Position: ' . ' ' . $model->support_position_id;
$this->params['breadcrumbs'][] = ['label' => 'Support Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->support_position_id, 'url' => ['view', 'id' => $model->support_position_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="support-position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
