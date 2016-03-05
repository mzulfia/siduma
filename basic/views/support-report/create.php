<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReportSupport */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Support Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-support-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
