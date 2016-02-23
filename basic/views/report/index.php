<?php

// use yii\helpers\ArrayHelper;
use yii\helpers\Html;
// use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\export\ExportMenu;
// use kartik\date\DatePicker;


// use app\models\ServiceFamily;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'service_family_id',
            'status',
            'information',
            'created_at',
            'support_id',
            ['class' => 'yii\grid\ActionColumn'],
        ];


        echo '<ul>' . ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'fontAwesome' => true,
            // 'asDropdown' => false
        ]) . '</ul>';

        // echo ExportMenu::widget([
        //     'dataProvider' => $dataProvider,
        //     'columns' => $gridColumns,
        //     'fontAwesome' => true,
        //     // 'columnSelectorOptions'=>[
        //     //     'label' => 'Columns',
        //     //     'class' => 'btn btn-danger'
        //     // ],
        //     // 'dropdownOptions' => [
        //     //     'label' => 'Export All',
        //     //     'class' => 'btn btn-success'
        //     // ],
        // ]);

    ?>


    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'bordered'=>true,
    ]); ?>
   
 
</div>
