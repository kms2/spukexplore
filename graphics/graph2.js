google.charts.load('current', {'packages': ['geochart']});
     google.charts.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['City',   'Population', 'Area'],
        ['Sao Paulo',      2761477,    1285.31]
      ]);

      var options = {
        region: 'BR',
        displayMode: 'markers',
        colorAxis: {colors: ['green', 'blue']}
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };