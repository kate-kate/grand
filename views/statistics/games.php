<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1.0', {'packages': ['corechart']});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            ['Mushrooms', 3],
            ['Onions', 1],
            ['Olives', 1],
            ['Zucchini', 1],
            ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {
            title: 'Company Performance',
            legend: {position: 'bottom'}
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>
<div id="chart_div"></div>