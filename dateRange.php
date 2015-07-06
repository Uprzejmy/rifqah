<?php

function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d') 
{

  $dates = array();
  $current = strtotime($first);
  $last = strtotime($last);

  while( $current <= $last ) 
  {
    $date = date($output_format, $current);
    //we need indexed form in print_avalable_surgeries.php
    $dates[$date] = $date;
    $current = strtotime($step, $current);
  }

  return $dates;
}

?>