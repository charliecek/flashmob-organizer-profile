<?php

class FLORP_CHART {
  private $strVersion = "1.2.0";
  private $strClass = "florp-chart";
  private $strChartLanguage = 'sk';
  private $strChartVersion = 'current';

  public function __construct() {
    // BEGIN SHORTCODES //
    // add_shortcode( 'florp-chart', array( $this, 'shortcode__chart' ));
    // END SHORTCODES //

    // BEGIN FILTERS //
    // END FILTERS //

    // BEGIN ACTIONS //
    add_action( 'wp_enqueue_scripts', array( $this, 'action__wp_enqueue_scripts' ), 9999 );
    add_action( 'wp_ajax_reloadChart', array( $this, 'action__reloadChart_callback' ));
    add_action( 'wp_ajax_nopriv_reloadChart', array( $this, 'action__reloadChart_callback' ));
    // END ACTIONS //
  }

  public function get_chart($aInputAttributes = array(), $aDivAttributes = array(), $aDataTable = array(), $aOptions = array(), $aAdditionalClasses = "", $sContentWhenHidden = "") {
    $aDefaultAttributes = array(
      'type'            => 'BarChart',
      'val-style'       => 'count',
      'hide-on-load'    => 0,
      'focus-on-show'   => 0,
      'scroll-offset'   => 0,
      'show-all-cities' => 0
    );
    $aAttributes = shortcode_atts( $aDefaultAttributes, $aInputAttributes );

    $iTimestamp = date('U');
    $strRandomString = wp_generate_password( 5, false );
    $strID = $iTimestamp . '_' . $strRandomString;

    $aChartOptions = array(
      "dataTable" => $aDataTable,
      "options"   => $aOptions,
      "attrs"     => $aInputAttributes,
    );

    $aAdditionalClasses = trim($aAdditionalClasses);
    if (!empty($aAdditionalClasses)) {
      $aAdditionalClasses = " ".$aAdditionalClasses;
    }

    $strChartOptions = json_encode( $aChartOptions );
    $strChartScript = '<script type="text/javascript">
      if ("undefined" === typeof florp_chart_options_object) {
        var florp_chart_options_object = {};
      }
      florp_chart_options_object["'.$strID.'"] = '.$strChartOptions.';
    </script>';

    $strPlaceholderDivActiveClass = $aAttributes["hide-on-load"] === 1 ? " florp-chart-active" : "";
    $strPlaceholderDiv = empty($sContentWhenHidden) ? "" : ('<div id="'.$strID.'_placeholder" class="'.$this->strClass.'-placeholder'.$strPlaceholderDivActiveClass.'">' . $sContentWhenHidden . '</div>');
    $strChartDivHtml = $strPlaceholderDiv.'<div id="'.$strID.'" class="'.$this->strClass.$aAdditionalClasses.'"';

    if (!empty($aAttributes)) {
      $aDataAttributes = array();
      foreach ($aAttributes as $strAttrKey => $strAttrValue) {
        $aDataAttributes[] = 'data-'.$strAttrKey.'="'.$strAttrValue.'"';
      }
      $strChartDivHtml .= ' '.implode(' ', $aDataAttributes);
    }
    if (!empty($aDivAttributes)) {
      $aDataAttributes = array();
      foreach ($aDivAttributes as $strAttrKey => $strAttrValue) {
        $aDataAttributes[] = $strAttrKey.'="'.$strAttrValue.'"';
      }
      $strChartDivHtml .= ' '.implode(' ', $aDataAttributes);
    }
    $strChartDivHtml .= '></div>';
    return $strChartScript.PHP_EOL.$strChartDivHtml;
  }

  public function action__reloadChart_callback() {
    check_ajax_referer( 'florp-chart-security-string', 'security' );
    // $aChartProperties = array_merge(
    //   $_POST['chartProperties'],
    //   array()
    // );
    $aChartProperties = $_POST['chartProperties'];
    $aChartData = $_POST['chartData'];
    $aChartData['options'] = apply_filters( 'florp_chart_get_options', $aChartData['options'], $aChartProperties, $aChartData['attrs'] );
    $aDataTable = apply_filters( 'florp_chart_get_datatable', array(), $aChartProperties, $aChartData );
    $aRes = array(
      'dataTable'       => $aDataTable,
      'chartProperties' => $aChartProperties,
      'chartOptions'    => $aChartData['options']
    );
    echo json_encode($aRes);
    wp_die();
  }

  public function action__wp_enqueue_scripts() {
    wp_enqueue_script('google_charts_loader', '//www.gstatic.com/charts/loader.js', array(), '', false );

    wp_enqueue_script('florp_chart_js', plugins_url('js/florp-chart.js', __FILE__), array('jquery'), $this->strVersion, false);

    $aJS = array(
      'ajaxurl'             => admin_url( 'admin-ajax.php'),
      'chart_reload_action' => 'reloadChart',
      'security'            => wp_create_nonce( 'florp-chart-security-string' ),
      'containerClass'      => $this->strClass,
      'language'            => $this->strChartLanguage,
      'chart_version'       => $this->strChartVersion,
    );
    wp_localize_script( 'florp_chart_js', 'florp_chart', $aJS );

    wp_enqueue_style( 'florp_chart_css', plugins_url('css/florp-chart.css', __FILE__), false, $this->strVersion, 'all');
  }
}

?>