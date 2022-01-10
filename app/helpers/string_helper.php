<?php
// Simple page redirect
function arrangeFullname(?string $first, ?string $middle, ?string $last): ?string
{
  if (empty($first) || empty($last)) {
    return null;
  }
  
  return !empty($middle)
    ? ucwords($last) . ', ' . ucwords($first) . ' ' . ucwords(substr($middle, 0, 1) . '.')
    : ucwords($last) . ', ' . ucwords($first);
}
