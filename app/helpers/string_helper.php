<?php
// Simple page redirect
function arrangeFullname($first, $middle, $last): string
{
  if (empty($first) || empty($last)) {
    return '';
  }
  return !empty($middle)
    ? ucwords($last) . ', ' . ucwords($first) . ' ' . ucwords(substr($middle, 0, 1) . '.')
    : ucwords($last) . ', ' . ucwords($first);
}
