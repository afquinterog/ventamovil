<?php 

/**
Usage:

*/
class Graphic2DHelper{
	
	/**
	* Usage:
	
	$serie1[] = array(5,10,"X=5  Y=10", "Informacion Adicional");
	$serie1[] = array(12,4,"X=12 - Y=4", "");
	$serie1[] = array(15,10,"X=15 - Y=10", "");
	$serie1[] = array(30,8,"X=30 - Y=8", "");
	$serie1[] = array(32,40,"X=30 - Y=8", "");
	
	$serie2[] = array(2,10,"X=5 - Y=10", "jhernandez");
	$serie2[] = array(12,12,"X=12 - Y=4", "");
	$serie2[] = array(30,10,"X=15 - Y=10", "");
	$serie2[] = array(30,15,"X=30 - Y=8", "");
	$serie2[] = array(42,40,"X=30 - Y=8", "");
	
		<div class="portlet-body">
			<div id="site_statistics_loading">
				<img src="templates/chronos/img/loading.gif" alt="loading" />
			</div>
			<div id="site_statistics_content" class="hide">
				<div id="site_statistics" class="chart"></div>
			</div>
		</div>
	Params: div, div_loading, div_content, serie 1, serie 2, tooltip title, tooltip width
	Graphic2DHelper::showGraphicLines("site_statistics", "site_statistics_loading", "site_statistics_content",  $serie1, $serie2, "Informacion", 120  );
	*/
	static function showGraphicLines($div, $divLoading, $divContent, $serie1, $serie2, $toolTipTitle, $toolTipWidth ){
		//Init function 
		echo "<script type='text/javascript'>";
		echo "jQuery(document).ready(function() {";
		echo "if (!jQuery.plot) { return;}";
		
		//Display serie
		echo "var serie1 = [";
		foreach($serie1 as $data){
			echo "[" . $data[0] .",". $data[1] . ",'" . $data[2] . "','" . $data[3] .  "']," ;
		}
        echo "];";
		
		echo "var serie2 = [";
		foreach($serie2 as $data){
			echo "[" . $data[0] .",". $data[1] . ",'" . $data[2] . "','" . $data[3] . "']," ;
		}
        echo "];";
		
		//Hide loading and display div
		echo "$('#" . $divLoading . "').hide();";
		echo "$('#" . $divContent . "').show();";
		
		//Show graphic
		?>
		
			var plot_statistics = $.plot($('#<?php echo $div;?>'), [
					{
						data: serie1,
						label: "Serie 1"
					}, 
					{
						data: serie2,
						label: "Serie 2"
					}
            ], {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }
                            ]
                        }
                    },
                    points: {
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#eee",
                    borderWidth: 0
                },
                colors: ["#d12610", "#37b7f3", "#52e136"],
                xaxis: {
                    ticks: 11,
                    tickDecimals: 0
                },
                yaxis: {
                    ticks: 11,
                    tickDecimals: 0
                }
            });
			
			var previousPoint = null;
            $("#<?php echo $div;?>").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
				
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;
						
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

						console.debug('evento=',item);
						//alert(item.series.label);
						//dump(event, 'alert', 2 );
						if(item.series.label == 'Serie 1'){
							//alert('serie1');
							showTooltip('<?php echo $toolTipTitle;?>', item.pageX, item.pageY, serie1[item.dataIndex][2], serie1[item.dataIndex][3] );
						}
						else{
							//alert('serie2');
							showTooltip('<?php echo $toolTipTitle;?>', item.pageX, item.pageY, serie2[item.dataIndex][2], serie2[item.dataIndex][3] );
						}
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            }); 
			
			 function showTooltip(title, x, y, contents, additional) {
				var tooltip = '<div id="tooltip" class="chart-tooltip"><div class="date">' +
				               title +  '<\/div><div class="label label-success">' + 
							   contents + '<\/div><div class="label label-important">'+ additional +
							   '<\/div><\/div>';
                $(tooltip).css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 100,
                    width: <?php echo $toolTipWidth;?>,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff',
                }).appendTo("body").fadeIn(200);
            }
		<?php
			
		//end javascript
		echo "});";
		echo "</script>";
	}
	
	/**
	* Usage:
	
	$serie3[] = array(1,10);
	$serie3[] = array(20,30);
	$serie3[] = array(40,50);
	$serie3[] = array(60,10);
	$serie3[] = array(90,39);
	
		<div class="portlet-body">
			<div id="load_statistics_loading">
				<img src="assets/img/loading.gif" alt="loading" />
			</div>
			<div id="load_statistics_content" class="hide">
				<div id="load_statistics" style="height:108px;"></div>
			</div>
		</div>
	Params: div, div_loading, div_content, serie 
	Graphic2DHelper::showGraphicLines2("site_statistics", "site_statistics_loading", "site_statistics_content",  $serie1);
	*/
	static function showGraphicLines2($div, $divLoading, $divContent, $labelSerie1, $serie1){
		//Init function 
		echo "<script type='text/javascript'>";
		echo "jQuery(document).ready(function() {";
		echo "if (!jQuery.plot) { return;}";
		
		//Display serie
		echo "var serie1 = [";
		foreach($serie1 as $data){
			echo "[" . $data[0] .",". $data[1] . "]," ;
		}
        echo "];";
		
		//Hide loading and display div
		echo "$('#" . $divLoading . "').hide();";
		echo "$('#" . $divContent . "').show();";
		
		//Show graphic
		?>
		
		  var plot_statistics = $.plot($("#<?php echo $div;?>"), [
					{
						data: serie1,
						label: "<?php echo $labelSerie1;?>"
					}],
			   {
                series: {
                    shadowSize: 1
                },
                lines: {
                    show: true,
                    lineWidth: 0.2,
                    fill: true,
                    fillColor: {
                        colors: [{
                                opacity: 0.1
                            }, {
                                opacity: 1
                            }
                        ]
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    tickFormatter: function (v) {
                        return v + "%";
                    }
                },
                xaxis: {
                    show: false
                },
                colors: ["#e14e3d"],
                grid: {
                    tickColor: "#a8a3a3",
                    borderWidth: 0
                }
            });

		<?php
			
		//end javascript
		echo "});";
		echo "</script>";
	}
	
	
	
}








