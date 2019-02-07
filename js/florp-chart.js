// jQuery(document).ready(function() {
  google.charts.load(florp_chart.chart_version, {
    language: florp_chart.language,
    callback: drawFlorpChart
  });
// })

function drawFlorpChart() {
  console.info("Drawing charts");
  var $chartDivs = jQuery("."+florp_chart.containerClass)
  console.log($chartDivs)
  $chartDivs.each(function() {
    var $this = jQuery(this)
    var strID = $this.prop('id')
    console.info("Drawing chart "+strID);
    var valStyle = $this.data('valStyle')
    var chartData = florp_chart_options_object[strID]
    if ("undefined" === typeof chartData) {
      console.warn("undefined chart data for "+strID)
      return
    }
    var dataTable = chartData.dataTable
    if (valStyle === 'percentage') {
      dataTable = google.visualization.arrayToDataTable(dataTable);
      var formatter = new google.visualization.NumberFormat({
          fractionDigits: 2,
          suffix: ' %'
      });
      formatter.format(dataTable, 1);
    }
    var wrapper = new google.visualization.ChartWrapper({
      chartType: $this.data("type"),
      dataTable: dataTable, // [['Germany', 'USA', 'Brazil', 'Canada', 'France', 'RU'], [700, 300, 400, 500, 600, 800]],
      options: chartData.options, // {'title': 'Countries'},
      containerId: strID,
    })

    wrapper.draw()
  })
}