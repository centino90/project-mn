<?php

function generateYearsBetween($startYear = 1980, $endYear = null)
{
  $endYear = $endYear ?? idate('Y') + 1;
  $years = [];
  for ($i = $startYear; $i <= $endYear; $i++) {
    array_push($years, $startYear);
    $startYear++;
  }

  return array_reverse($years);
}
