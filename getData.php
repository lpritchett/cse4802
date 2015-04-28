<html>
  <head>
<?php
   $sdate = $_POST["st"];
   $edate = $_POST["et"];
   $option = $_POST["option"];
   $param = $_POST["param"];

   $myFile = "wiki.2005";
   $handle = @fopen($myFile, "r");
   $numItems = 0;
   $lineno = 0;
   $freq = array();

   set_time_limit(120);

   $dataTable = array(
      'cols' => array(
         array('type' => 'string', 'label' => 'article'),
         array('type' => 'number', 'label' => 'count')
       )
   );

   if ($handle) {
       	while (!feof($handle)) {
   		$buffer = fgets($handle, 4096);
		if (($option == "Sampling") and ((rand(0,10000)/10000) > $param)) continue;
		++$lineno;
		$values = explode(" ", $buffer);
		$tmp = array_shift($values);
		$tmp = array_shift($values);
		$revid = array_shift($values);
		$article = array_shift($values);
		$cdate = substr(array_shift($values),0,10);
		if (($cdate >= $sdate) && ($cdate <= $edate)) {

			if (array_key_exists($article, $freq)) {
				$freq[$article] = $freq[$article] + 1;
			}
			elseif (($option != "Misra-Gries") or ($numItems < $param)) {
				$freq[$article] = 1;
				$numItems = $numItems + 1;
			}
			else {
				foreach ($freq as $key=>$value) {
					$freq[$key] = $value - 1;
					if ($freq[$key] < 1) {
						unset($freq[$key]);
						$numItems = $numItems - 1;
					}
				} 
			}
		}
    	}
    	fclose($handle);
	arsort($freq);
	$count = 0;

	foreach ($freq as $key => $value) {
	    if (++$count > 20) {
		break;
	    }
	    $dataTable['rows'][] = array(
        		'c' => array (
             			array('v' => $key),
             			array('v' => $value)
         		)
    	    );
	}
	$json = json_encode($dataTable);
   }
   else {
	echo "Error: file not found<br>";
   }

?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart', 'table']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
	var data = new google.visualization.DataTable(<?php echo $json; ?>);

        // Set chart options
        var options = {'title':'Most Frequently Edited Wikipedia Articles',
                       'width':800,
                       'height':600};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>
