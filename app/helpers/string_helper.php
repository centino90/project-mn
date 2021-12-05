<?php
  // Simple page redirect
  function arrangeFullname($first, $middle, $last): string {
    if(empty($first) || empty($middle) || empty($last)) {
      return 'Not yet named';
    }
    return ucwords($last) . ', ' . ucwords($first) . ' ' . ucwords(substr($middle, 0, 1) . '.');
  }
