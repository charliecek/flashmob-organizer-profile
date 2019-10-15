<?php

/**
 * Class FLORP_COLOR - for RGB <-> HSV conversion and color interpolation.
 * Source: https://gist.github.com/zyphlar/55dea0fae7914ff8eb4a
 */
class FLORP_COLOR {

  public static function interpolateRgb( $aFrom, $aTo, $flAt ) {
    foreach (array( $aFrom, $aTo ) as $aArg) {
      if (count( $aArg ) !== 3) {
        return false;
      }

      foreach (array( "R", "G", "B" ) as $item) {
        if ( !isset( $aArg[$item] )) {
          return false;
        }
      }
    }

    $aFromHsv = self::RGB_TO_HSV( $aFrom["R"], $aFrom["G"], $aFrom["B"] );
    $aToHsv   = self::RGB_TO_HSV( $aTo["R"], $aTo["G"], $aTo["B"] );

    if ($aToHsv["H"] < $aFromHsv["H"]) {
      $aToHsv["H"] += 360;
    }

    $aColorHsv = self::interpolateHsv( $aFromHsv, $aToHsv, $flAt );
    if ( !is_array( $aColorHsv )) {
      return $aColorHsv;
    }

    $aColorHsv["H"] = $aColorHsv["H"] % 360;

    return self::HSV_TO_RGB( $aColorHsv["H"], $aColorHsv["S"], $aColorHsv["V"] );
  }

  public static function interpolateHex( $sFrom, $sTo, $flAt ) {
    $aFromHex = self::HEX_TO_RGB( $sFrom );
    $aToHex   = self::HEX_TO_RGB( $sTo );

    if ($aFromHex === false || $aToHex === false) {
      return false;
    }

    $aColorRgb = self::interpolateRgb( $aFromHex, $aToHex, $flAt );

    if ( !is_array( $aColorRgb )) {
      return $aColorRgb;
    }

    return self::RGB_TO_HEX( $aColorRgb["R"], $aColorRgb["G"], $aColorRgb["B"] );
  }

  public static function interpolateHsv( $aFrom, $aTo, $flAt ) {
    foreach (array( $aFrom, $aTo ) as $aArg) {
      if (count( $aArg ) !== 3) {
        return false;
      }

      foreach (array( "H", "S", "V" ) as $item) {
        if ( !isset( $aArg[$item] )) {
          return var_export( $aArg, true );
        }
      }
    }

    $aColor = array();

    foreach (array( "H", "S", "V" ) as $item) {
      $aColor[$item] = self::interpolateValue( $aFrom[$item], $aTo[$item], $flAt );

      if ($aColor[$item] === false) {
        return false;
      }
    }

    return $aColor;
  }

  private static function interpolateValue( $flFrom, $flTo, $flAt ) {
    if ( !is_numeric( $flAt )) {
      return false;
    }

    return $flFrom * ( 1 - $flAt ) + $flTo * $flAt;
  }

  private static function zeropad2( $num ) {
    $limit = 2;

    return ( strlen( $num ) >= $limit ) ? $num : self::zeropad2( "0" . $num );
  }

  public static function RGB_TO_HSV( $R, $G, $B ) { // RGB Values:Number 0-255, HSV values: 0-360, 0-100, 0-100, src: https://stackoverflow.com/a/13887939
    // Convert the RGB byte-values to percentages
    $R = ( $R / 255 );
    $G = ( $G / 255 );
    $B = ( $B / 255 );

    // Calculate a few basic values, the maximum value of R,G,B, the
    //   minimum value, and the difference of the two (chroma).
    $maxRGB = max( $R, $G, $B );
    $minRGB = min( $R, $G, $B );
    $chroma = $maxRGB - $minRGB;

    // Value (also called Brightness) is the easiest component to calculate,
    //   and is simply the highest value among the R,G,B components.
    // We multiply by 100 to turn the decimal into a readable percent value.
    $computedV = intval( $maxRGB );

    // Special case if hueless (equal parts RGB make black, white, or grays)
    // Note that Hue is technically undefined when chroma is zero, as
    //   attempting to calculate it would cause division by zero (see
    //   below), so most applications simply substitute a Hue of zero.
    // Saturation will always be zero in this case, see below for details.
    if ($chroma == 0) {
      return array( 'H' => 0, 'S' => 0, 'V' => $computedV );
    }

    // Saturation is also simple to compute, and is simply the chroma
    //   over the Value (or Brightness)
    // Again, multiplied by 100 to get a percentage.
    $computedS = intval( $chroma / $maxRGB );

    // Calculate Hue component
    // Hue is calculated on the "chromacity plane", which is represented
    //   as a 2D hexagon, divided into six 60-degree sectors. We calculate
    //   the bisecting angle as a value 0 <= x < 6, that represents which
    //   portion of which sector the line falls on.
    if ($R == $minRGB) {
      $h = 3 - ( ( $G - $B ) / $chroma );
    } elseif ($B == $minRGB) {
      $h = 1 - ( ( $R - $G ) / $chroma );
    } else { // $G == $minRGB
      $h = 5 - ( ( $B - $R ) / $chroma );
    }

    // After we have the sector position, we multiply it by the size of
    //   each sector's arc (60 degrees) to obtain the angle in degrees.
    $computedH = intval( 60 * $h );

    return array( "H" => $computedH, "S" => $computedS, "V" => $computedV );
  }

  function HSV_TO_RGB( $H, $S, $V ) { // HSV Values:Number 0-1, RGB Results:Number 0-255
    $R = 0;
    $G = 0;
    $B = 0;

    if ($S == 0) {
      $R = $V;
      $G = $V;
      $B = $V;
    } else {
      if ($H == 360) {
        $H = 0;
      } else {
        $H = $H / 60;
      }

      $i = (int) floor( $H );
      $f = $H - $i;

      $p = $V * ( 1.0 - $S );
      $q = $V * ( 1.0 - ( $S * $f ) );
      $t = $V * ( 1.0 - ( $S * ( 1.0 - $f ) ) );

      switch ($i) {
        case 0:
          $R = $V;
          $G = $t;
          $B = $p;
          break;

        case 1:
          $R = $q;
          $G = $V;
          $B = $p;
          break;

        case 2:
          $R = $p;
          $G = $V;
          $B = $t;
          break;

        case 3:
          $R = $p;
          $G = $q;
          $B = $V;
          break;

        case 4:
          $R = $t;
          $G = $p;
          $B = $V;
          break;

        default:
          $R = $V;
          $G = $p;
          $B = $q;
          break;
      }

    }

    return array( 'R' => intval( $R * 255 ), 'G' => intval( $G * 255 ), 'B' => intval( $B * 255 ) );
  }

  public static function RGB_TO_HEX( $R, $G, $B ) {
    return sprintf( "#%02x%02x%02x", $R, $G, $B );
  }

  public static function HEX_TO_RGB( $sHex ) {
    if (substr( $sHex, 0, 1 ) === "#") {
      if ( !self::isHex( $sHex )) {
        return false;
      }

      $sHex = substr( $sHex, 1 );
    } elseif ( !self::isHex( "#" . $sHex )) {
      return false;
    }

    if (strlen( $sHex ) === 3) {
      $R = str_repeat( substr( $sHex, 0, 1 ), 2 );
      $G = str_repeat( substr( $sHex, 1, 1 ), 2 );
      $B = str_repeat( substr( $sHex, 2, 1 ), 2 );
    } else {
      $R = substr( $sHex, 0, 2 );
      $G = substr( $sHex, 2, 2 );
      $B = substr( $sHex, 4, 2 );
    }

    $R = hexdec( $R );
    $G = hexdec( $G );
    $B = hexdec( $B );

    return array( 'R' => $R, 'G' => $G, 'B' => $B );
  }

  public static function isHex( $sHex ) {
    if ( !is_string( $sHex ) || !substr( $sHex, 0, 1 ) == "#") {
      return false;
    }

    $sHex = substr( $sHex, 1 );

    return ( strlen( $sHex ) === 3 || strlen( $sHex ) === 6 ) && trim( $sHex, '0..9A..Fa..f' ) == '';
  }

  public static function isHexRange( $sHexRange ) {
    $aParts = explode( "-", $sHexRange );

    return count( $aParts ) === 2 && self::isHex( $aParts[0] ) && self::isHex( $aParts[1] );
  }

  public static function isHexRangeWithCount( $sHexRange ) {
    $aParts = explode( "-", $sHexRange );

    $iCount = intval( $aParts[2] );

    return count( $aParts ) === 3 && self::isHex( $aParts[0] ) && self::isHex( $aParts[1] ) && $iCount > 0;
  }

  public static function getRangeHex( $sHexFrom, $sHexTo, $iCount, $bIncludeBorders = true ) {
    if ( !is_int( $iCount ) || $iCount <= 0) {
      return array();
    }

    $aColors = array();

    if ($bIncludeBorders) {
      $aColors[] = $sHexFrom;
    }

    if ($iCount >= 3 || !$bIncludeBorders) {
      $iIntervalCount = $bIncludeBorders ? ( $iCount - 1 ) : ( $iCount + 1 );
      $flStep         = 1 / $iIntervalCount;
      for ($i = 1; $i < $iIntervalCount; $i++) {
        $aColors[] = self::interpolateHex( $sHexFrom, $sHexTo, $i * $flStep );
      }
    }

    if ($bIncludeBorders && $iCount >= 2) {
      $aColors[] = $sHexTo;
    }

    return $aColors;
  }

}