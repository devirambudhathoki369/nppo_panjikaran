<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
  use HasFactory;

  protected $table = 'dates';

  static function nepToEng($nepDate)
  {
    $dateData = Date::select('engdate')
      ->where('nepdate', sanitize($nepDate))
      ->first();

    if ($dateData)
      return $dateData['engdate'];

    return null;
  }

  static function engToNep($engDate)
  {
    $engDate = sanitize($engDate);

    $dateData = Date::select('nepdate')
      ->where('engdate', $engDate)
      ->first();

    if ($dateData)
      return $dateData['nepdate'];

    return null;
  }

  static function todayNepDate()
  {
    $engDate = date('Y-m-d');

    $dateData = Date::select('nepdate')
      ->where('engdate', $engDate)
      ->first();

    if ($dateData)
      return $dateData['nepdate'];

    return null;
  }
}
