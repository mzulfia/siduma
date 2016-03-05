<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-create">

	<?= $this->render('_formCreate', [
        'model' => $model,
    ]) ?>

</div>
