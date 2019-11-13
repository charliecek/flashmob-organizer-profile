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
                aDataTable = JSON.parse(JSON.stringify(oResponse.dataTable)),
                oOptions = oResponse.chartOptions,
                chartWrapperLoc = florp_charts[inputData.wrapperIndex],
                chartContainerID = inputData.containerID || chartContainerID,
                chartData = chartContainerID && florp_chart_options_object.hasOwnProperty(chartContainerID) ? florp_chart_options_object[chartContainerID] : {}
            // console.log(oResponse);

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
            } else if (aDataTable.length === 1) {
              if (chartContainerID && chartData.hasOwnProperty("attrs") && chartData.attrs.type === "PieChart") {
                // nothing - pie chart handles empty data table well
              } else {
                // Add fake empty row so the chart renders
                var emptyRow = ["", 0]
                for (var i = 0; i < aDataTable[0].length - 2; i++) {
                  emptyRow.push(null)
                }
                aDataTable.push(emptyRow)
              }
            }
            var $chartContainerLoc = jQuery(chartWrapperLoc.getContainer())
            if ("function" !== typeof $chartContainerLoc.data) {
              console.warn("Invalid chart container")
              console.log(oResponse, $chartContainerLoc)
              window["florpChartReloadAjaxRunning"][chartContainerID] = false
              return
            }
            if ($chartContainerLoc.data("hideOnLoad") === "1" || $chartContainerLoc.data("hideOnLoad") === 1 || (chartData.hasOwnProperty("attrs") && chartData.attrs["hide-on-load"] === 1)) {
              $chartContainerLoc.show()
              jQuery("#" + $chartContainerLoc.prop("id") + "_placeholder").removeClass("florp-chart-active")
              if ($chartContainerLoc.data("focusOnShow") === "1" || $chartContainerLoc.data("focusOnShow") === 1 || (chartData.hasOwnProperty("attrs") && chartData.attrs["focus-on-show"] === 1)) {
                var scrollOffset = +$chartContainerLoc.data("scrollOffset") || ((chartData.hasOwnProperty("attrs") && !isNaN(+chartData.attrs["scroll-offset"])) ? +chartData.attrs["scroll-offset"] : 100);
                jQuery('html, body').stop().animate({scrollTop: $chartContainerLoc.first().offset().top - scrollOffset});
              }
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
            florp_chart_options_object[chartContainerID].dataTable = oResponse.dataTable
            chartWrapperLoc.setDataTable(aDataTable)
            florp_chart_options_object[chartContainerID].options = oOptions;
            chartWrapperLoc.setOptions(oOptions)
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
  // console.log($chartDivs)
  $chartDivs.each(function() {
    var $this = jQuery(this)
    var strID = $this.prop('id')
    var $placeholderDiv = jQuery("#" + strID + "_placeholder")
    console.info("Drawing chart "+strID)
    var valStyle = $this.data('valStyle')
    var chartData = JSON.parse(JSON.stringify(florp_chart_options_object[strID]))
    if ("undefined" === typeof chartData) {
      console.warn("undefined chart data for "+strID)
      return
    }
    if (florp.intf_charts_visible_indefinitely_on_submit === "1" && +localStorage.getItem('chartVisible') === +florp.intf_flashmob_year) {
      if ($this.data("hideOnLoad") === "1" || $this.data("hideOnLoad") === 1 || (chartData.hasOwnProperty("attrs") && chartData.attrs["hide-on-load"] === 1)) {
        $this.show()
        $placeholderDiv.removeClass("florp-chart-active")
      }
    }

    var dataTable = chartData.dataTable
    if (dataTable.length === 1 && chartData.attrs.type !== "PieChart") {
      // Add fake empty row so the chart renders
      var emptyRow = ["", 0]
      for (var i = 0; i < dataTable[0].length - 2; i++) {
        emptyRow.push(null)
      }
      dataTable.push(emptyRow)
    }
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

    var left = 20
    var divWidth = $this.width()
    jQuery.each(chartData.attrs.chartAreaLeft, function(maxWidth, leftVal) {
        if (divWidth <= maxWidth) {
            left = Math.max(leftVal, left)
        }
    })
    var width = 95 - left
    chartWrapperLoc.setOption("chartArea", {left: left+"%", width: width+"%"})
    chartWrapperLoc.draw()
    var i = $this.data("index")
    if ("undefined" === typeof i) {
        i = florp_charts.length
        $this.data("index", i)
    }
    florp_charts[i] = chartWrapperLoc
  })
}