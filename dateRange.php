<?php

/**
 * Creating date collection between two dates
 *
 * <code>
 * <?php
 * # Example 1
 * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
 *
 * # Example 2. you can use even time
 * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
 * </code>
 *
 * @author Ali OYGUR <alioygur@gmail.com>
 * @param string since any date, time or datetime format
 * @param string until any date, time or datetime format
 * @param string step
 * @param string date of output format
 * @return array
 */
function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d') 
{

  $dates = array();
  $current = strtotime($first);
  $last = strtotime($last);

  while( $current <= $last ) 
  {

    $dates[] = date($output_format, $current);
    $current = strtotime($step, $current);
  }

  return $dates;
}

?>