<?php

class FLORP_CHART{
  private $strVersion = "1.0.0";
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
    // END ACTIONS //
  }

  public function get_chart($aInputAttributes = array(), $aDivAttributes = array(), $aDataTable = array(), $aOptions = array()) {
    $aDefaultAttributes = array(
      'type'      => 'BarChart',
      'val-style' => 'count',
    );
    $aAttributes = shortcode_atts( $aDefaultAttributes, $aInputAttributes );

    $iTimestamp = date('U');
    $strRandomString = wp_generate_password( 5, false );
    $strID = $strDivID_prefix . $iTimestamp . '_' . $strRandomString;

    $aChartOptions = array(
      "dataTable" => $aDataTable,
      "options"   => $aOptions,
      "attrs"     => $aInputAttributes,
    );

    $strChartOptions = json_encode( $aChartOptions );
    $strChartScript = '<script type="text/javascript">
      if ("undefined" === typeof florp_map_options_object) {
        var florp_chart_options_object = {};
      }
      florp_chart_options_object["'.$strID.'"] = '.$strChartOptions.';
    </script>';
    $strChartDivHtml = '<div id="'.$strID.'" class="'.$this->strClass.'"';

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

  public function action__wp_enqueue_scripts() {
    wp_enqueue_script('google_charts_loader', '//www.gstatic.com/charts/loader.js', array(), '', false );

    wp_enqueue_script('florp_chart_js', plugins_url('js/florp-chart.js', __FILE__), array('jquery'), $this->strVersion, false);

    $aJS = array(
      'containerClass'  => $this->strClass,
      'language'        => $this->strChartLanguage,
      'chart_version'   => $this->strChartVersion,
    );
    wp_localize_script( 'florp_chart_js', 'florp_chart', $aJS );
  }
}

?>