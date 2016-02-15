<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Management */

$this->title = 'Create Management';
$this->params['breadcrumbs'][] = ['label' => 'Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="management-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
