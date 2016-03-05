<?php
 use miloschuman\highcharts\Highcharts;
 use kartik\form\ActiveForm;
 use kartik\daterange\DateRangePicker;
 use yii\helpers\Html;
 use yii\helpers\Url;
 use yii\helpers\ArrayHelper;
 use yii\widgets\Pjax;
 use app\models\ServiceFamily;
 use app\models\Schedule;
 use app\models\Support;


/* @var $this yii\web\View */
$this->title = 'SIDUMA';
$this->params['breadcrumbs'][] = 'Report History';

$this->registerJs(
   '$("document").ready(function(){ 
        $("#new_chart").on("pjax:end", function() {
            $.pjax.reload({container:"#columnChart"});  //Reload columnChart
        });
    });'
);

// $this->registerJs(
//    '$(window).resize(function() {
//     height = $(window).height()
//     width = $(window).width() / 2
//     $("#columnChart").highcharts().setSize(width, height, doAnimation = true);
// });'
// );

?>
<div class="site-index">
    <div class="col-md-12" style = 'text-align: center; margin-bottom: 20px'> 
        <?php Pjax::begin(['id' => 'new_chart'])?>
            <?php 
                $form = ActiveForm::begin(
                [
                    'id' => 'dashboard-form',
                    'type' => ActiveForm::TYPE_INLINE,
                ],
                ['options' => ['data-pjax' => true ]
                ]
                );
            ?>
                    
            <?= $form->field($model, 'date', [
                        'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                        'options'=>['class'=>'drp-container form-group']
                    ])->widget(DateRangePicker::classname(), [
                    'useWithAddon'=>true,
                ]);
            ?>

            <?= Html::submitButton('Get', ['name' => 'dashboard-button', 'class' => 'btn btn-success']) ?>        
            
             <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                 <!-- BAR CHART -->
                  <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title"><b>Report History</b></h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div>
                    </div>
                    <div class="box-body">
                       <?php Pjax::begin(['id' => 'columnChart'])?>
                            <?= 
                            Highcharts::widget([
                                'options' => [
                                    'chart' => [ 
                                        'type' => 'column' 
                                    ],
                                    'title' => [ 'text' => $date ],
                                    'xAxis' => [
                                        'categories' => ['ERP','Email dan Jaringan Data', 'AP2T', 'P2APST', 'BBO', 'APKT', 'ITSM']
                                    ],
                                    'yAxis' => [
                                        'title' => ['text' => 'Amounts']
                                    ],
                                    'series' => [
                                        [
                                            'name' => 'Normal',
                                            'data' => [$normal_erp, $normal_email, $normal_ap2t, $normal_p2apst, $normal_bbo, $normal_apkt, $normal_itsm]
                                        ],
                                        [
                                            'name' => 'Warning', 
                                            'data' => [$warning_erp, $warning_email, $warning_ap2t, $warning_p2apst, $warning_bbo, $warning_apkt, $warning_itsm]
                                        ],
                                        [
                                            'name' => 'Critical', 
                                            'data' => [$critical_erp, $critical_email, $critical_ap2t, $critical_p2apst, $critical_bbo, $critical_apkt, $critical_itsm]
                                        ],
                                    ],
                                    'plotOptions' => [
                                        'series' => [
                                            'borderWidth' => 0,
                                            'dataLabels' => [
                                                'enabled' => true,
                                                'format' => '{point.y:.1f}%'
                                            ]
                                        ]
                                    ],
                                    'tootip' => [
                                        'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
                                        'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                    ]
                                ]
                                ]); 
                            ?>  
                           
                           <?php Pjax::end()?>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div>
            </div>
        </div>
    </div>
<?php
// $js = <<<JS

// // get the form id and set the event
// $('#dashboard-form').on('beforeSubmit', function(e) { 
//    var form = $(this);
//     if(form.find('.has-error').length) {
//         return false;
//     }
//     $.ajax({
//         url: form.attr('action'),
//         type: 'post',
//         data: form.serialize(),
//         success: function(response) { 
//             var csrf = yii.getCsrfToken();
//             var date = $('#schedule-date').val();
//             var service-family_id = $('#servicefamily-service_family_id').val();
//             var url = form.attr('action')+ '&_csrf='+csrf+'&Schedule[date]='+date+'&ServiceFamily[service_family_id]='+service_family_id;
//             $.pjax.reload({url: url, container:'#pieChart'});
//         }
//     });    
// }).on('submit', function(e){
// e.preventDefault();
// });


// JS;
// $this->registerJs($js);
?>