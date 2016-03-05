<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSupport */

$this->params['breadcrumbs'][] = ['label' => 'Report Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Report';
?>
<div class="report-support-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
