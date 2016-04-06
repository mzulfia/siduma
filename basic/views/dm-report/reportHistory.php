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
$this->title = 'SIDUMA | Report History';
$this->params['breadcrumbs'][] = 'Report History';

$this->registerJs(
   '$("document").ready(function(){ 
        $("#new_chart").on("pjax:end", function() {
            $.pjax.reload({container:"#columnChart"});  //Reload columnChart
        });
    });'
);

?>
<style>
    .legend { list-style: none; }
    .legend li { float: left; margin-right: 10px; }
    .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 4px; }
    /* your colors */
    .legend .normal { background-color: #00a65a; }
    .legend .warning { background-color: #f39c12; }
    .legend .critical { background-color: #dd4b39; }
</style>

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

                $model->date = date('Y-m-d'). ' - ' . date('Y-m-d');
            ?>
            
            <?= $form->field($model, 'date', [
                        'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                        'options'=>['class'=>'drp-container form-group'] 
                    ])->widget(DateRangePicker::classname(), [
                        'name' => 'date_1',
                        'value' => 'date',
                        'convertFormat'=>true,
                        
                        'pluginOptions'=>[
                            'locale'=>['format' => 'Y-m-d'],
                        ],
                        'presetDropdown'=>true,
                    ]);
            ?>

            <?= Html::submitButton('Get', ['name' => 'report-button', 'class' => 'btn btn-success']) ?>        
            
             <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                 <!-- BAR CHART -->
                  <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title">Report History on <?php echo '<b>' . $date . '</b>'; ?></h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <?php Pjax::begin(['id' => 'columnChart'])?>
                           <div class="chart">
                            <canvas id="barChart" style="height: 400px; width: 100%" chart-options="options" chart-data="data" auto-legend></canvas>
                          </div>
                        <?php Pjax::end()?>    
                        <br>
                        <div class="row" style ="text-align: center">
                          <ul class="legend">
                              <li><span class="normal"></span> Normal </li>
                              <li><span class="warning"></span> Warning </li>
                              <li><span class="critical"></span> Critical </li>
                          </ul>
                        </div>  
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
            </div>
        </div>
    </div>
</div>

<!-- jQuery 2.1.4 -->
<script src="<?php echo \Yii::$app->homeUrl;?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo \Yii::$app->homeUrl;?>js/bootstrap/bootstrap.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo \Yii::$app->homeUrl;?>plugins/chartjs/Chart.min.js"></script>

<script>
      $(function () {
        var areaChartCanvas = $("#barChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);

        var areaChartData = {
          labels: [
            <?php 
                $services = ServiceFamily::find()->all();
                foreach($services as $service){
                    echo "'" . $service->service_name . "', ";
                }
            ?>
          ],
          datasets: [
            {
              label: "Normal",
              fillColor: "#00a65a",
              data: [
                    <?php 
                        foreach($service_family as $service){
                            echo $service[0] . ", ";
                        }
                    ?>
                ]
            },
            {
              label: "Warning",
              fillColor: "#f39c12",
              data: [
                    <?php 
                        foreach($service_family as $service){
                            echo $service[1] . ", ";
                        }
                    ?>
                ]
            },
            {
              label: "Critical",
              fillColor: "#dd4b39",
              data: [
                    <?php 
                        foreach($service_family as $service){
                            echo $service[2] . ", ";
                        }
                    ?>
                ]
            }
          ]
        };

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,

          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          tooltipTemplate: "<%if (label){%><%=label %>: <%}%><%= value + ' %' %>",
          multiTooltipTemplate: "<%= value + ' %' %>",
          
          animation: true,
          responsive: true,
          maintainAspectRatio: false,
          

        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
        barChart.generateLegend();
    });
    </script>