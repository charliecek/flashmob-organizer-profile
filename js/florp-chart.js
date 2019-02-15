// jQuery(document).ready(function() {
  google.charts.load(florp_chart.chart_version, {
    language: florp_chart.language,
    callback: florpChartDrawAll
  })
// })

var florp_charts = []
window["florpChartReloadAjaxRunning"] = {}

function florpChartReload(chartClass) {
  // console.log(arguments)
  jQuery.each(florp_charts, function(i, chartWrapper) {
    // console.log(chartWrapper)
    var chartContainer = chartWrapper.getContainer(),
        $chartContainer = jQuery(chartContainer),
        chartContainerID = chartWrapper.getContainerId(),
        chartWrapperIndex = i
    if ("undefined" !== typeof window["florpChartReloadAjaxRunning"][chartContainerID] && true === window["florpChartReloadAjaxRunning"][chartContainerID]) {
      console.info("Another reloading is still running for "+chartContainerID)
      // TODO: (maybe later) setTimeout()
      return true
    }
    window["florpChartReloadAjaxRunning"] = true
    if ("object" === typeof $chartContainer && "function" === typeof $chartContainer.hasClass && $chartContainer.hasClass(chartClass)) {
      // ajax to reload object //
      console.debug("Starting ajax call to reload the matching chart")
      var data = {
        action: florp_chart.chart_reload_action,
        security : florp_chart.security,
        chartProperties : {
          wrapperIndex : chartWrapperIndex,
          containerID : chartContainerID,
          containerClasses: $chartContainer.prop("class").split(/\s+/),
        },
        chartData : florp_chart_options_object[chartContainerID],
      };
      jQuery.ajax({
        type: "POST",
        url: florp_chart.ajaxurl,
        data: data,
        success: function(response) {
          // console.log(response)
          try {
            var oResponse = JSON.parse(response),
                inputData = oResponse.chartProperties,
                aDataTable = oResponse.dataTable,
                // aOptions = oResponse.options,
                chartWrapperLoc = florp_charts[inputData.wrapperIndex]

            if ("object" !== typeof chartWrapperLoc || "function" !== typeof chartWrapperLoc.setDataTable || "function" !== typeof chartWrapperLoc.draw) {
              console.warn("Invalid or empty chart wrapper")
              console.log(oResponse, chartWrapperLoc)
              window["florpChartReloadAjaxRunning"][chartContainerID] = false
              return
            }
            if ("object" !== typeof aDataTable || !aDataTable.hasOwnProperty("length")) {
              console.warn("Invalid dataTable")
              console.log(oResponse, aDataTable)
              window["florpChartReloadAjaxRunning"][chartContainerID] = false
              return
            } else if (aDataTable.length === 0) {
              console.debug("Empty dataTable")
              console.debug(oResponse)
              window["florpChartReloadAjaxRunning"][chartContainerID] = false
              return
            }
            var $chartContainerLoc = jQuery(chartWrapperLoc.getContainer())
            if ("function" !== typeof $chartContainerLoc.data) {
              console.warn("Invalid chart container")
              console.log(oResponse, $chartContainerLoc)
              window["florpChartReloadAjaxRunning"][chartContainerID] = false
              return
            }
            var valStyle = $chartContainerLoc.data('valStyle')
            if (valStyle === 'percentage') {
              aDataTable = google.visualization.arrayToDataTable(aDataTable)
              var formatter = new google.visualization.NumberFormat({
                  fractionDigits: 2,
                  suffix: ' %'
              })
              formatter.format(aDataTable, 1)
            }
            chartWrapperLoc.setDataTable(aDataTable)
            chartWrapperLoc.draw()
            window["florpChartReloadAjaxRunning"][chartContainerID] = false
          } catch(e) {
            console.warn(e)
            window["florpChartReloadAjaxRunning"][chartContainerID] = false
          }
        },
        error: function(errorThrown){
          console.warn(errorThrown)
          console.log(response)
          window["florpChartReloadAjaxRunning"][chartContainerID] = false
        }
      })
    } else {
      console.debug(chartClass, $chartContainer, "function" === typeof $chartContainer.hasClass, $chartContainer.hasClass(chartClass))
    }
  })
}

jQuery(window).resize(function() {
  florpChartDrawAll();
});

function florpChartDrawAll() {
  console.info("Drawing charts")
  var $chartDivs = jQuery("."+florp_chart.containerClass)
  console.log($chartDivs)
  $chartDivs.each(function() {
    var $this = jQuery(this)
    var strID = $this.prop('id')
    console.info("Drawing chart "+strID)
    var valStyle = $this.data('valStyle')
    var chartData = florp_chart_options_object[strID]
    if ("undefined" === typeof chartData) {
      console.warn("undefined chart data for "+strID)
      return
    }
    var dataTable = chartData.dataTable
    if (valStyle === 'percentage') {
      dataTable = google.visualization.arrayToDataTable(dataTable)
      var formatter = new google.visualization.NumberFormat({
          fractionDigits: 2,
          suffix: ' %'
      })
      formatter.format(dataTable, 1)
    }
    var chartWrapperLoc = new google.visualization.ChartWrapper({
      chartType: $this.data("type"),
      dataTable: dataTable, // [['Germany', 'USA', 'Brazil', 'Canada', 'France', 'RU'], [700, 300, 400, 500, 600, 800]],
      options: chartData.options, // {'title': 'Countries'},
      containerId: strID,
    })

    chartWrapperLoc.draw()
    florp_charts.push(chartWrapperLoc)
  })
}