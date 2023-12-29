<?php
function hitungjamterlambat($jadwal_jam_masuk, $jam_presensi)
{
  $j1 = strtotime($jadwal_jam_masuk);
  $j2 = strtotime($jam_presensi);

  $differterlambat = $j2 - $j1;

  $jamterlambat = floor($differterlambat / (60 * 60));
  $menitterlambat = floor(($differterlambat - ($jamterlambat * (60 * 60))) / 60);

  $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
  $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

  $terlambat = $jterlambat . ":" . $mterlambat;
  return $terlambat;
}