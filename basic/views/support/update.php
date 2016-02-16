<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = 'Update Pic: ' . ' ' . $model->support_id;
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->support_id, 'url' => ['view', 'id' => $model->support_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="support-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
