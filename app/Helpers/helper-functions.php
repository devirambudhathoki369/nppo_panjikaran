<?php
if (!function_exists('checklistType')) {
  function checklistType($type)
  {
    switch ($type) {
      case 0:
        return "पैठारीकर्ता";
      case 1:
        return "उत्पादक / संश्लेषण / प्याकेजिङ्ग";
      default:
        return "दुवै";
    }
  }
}

if (!function_exists('DocumentStatus')) {
  function DocumentStatus($type)
  {
    switch ($type) {
      case 0:
        return "छ";
      case 1:
        return "छैन";
      default:
        return "";
    }
  }
}

if (!function_exists('SourceOfDocument')) {
  function SourceOfDocument($type)
  {
    switch ($type) {
      case 1:
        return "हार्डकपी";
      case 2:
        return "NNSW";
      case 3:
        return "कार्यालयको अभिलेख";
      default:
        return "N/A";
    }
  }
}

if (!function_exists('checklistStatus')) {
  function checklistStatus($type)
  {
    switch ($type) {
      case 0:
        return '<span class="badge bg-warning">दर्ता भएको</span>';
      case 1:
        return '<span class="badge bg-info">सिफारीस भएको</span>';
      case 2:
        return '<span class="badge bg-success">स्वीकृत</span>';
      default:
        return '<span class="badge bg-danger">N/A</span>';
    }
  }
}


if (!function_exists('sanitize')) {
  function sanitize($string)
  {
    // $string = entity_convert($string);
    return UTF8toEng($string);
  }
}

if (!function_exists('UTF8toEng')) {
  function UTF8toEng($string)
  {
    $patterns[0] = '0';
    $patterns[1] = '1';
    $patterns[2] = '2';
    $patterns[3] = '3';
    $patterns[4] = '4';
    $patterns[5] = '5';
    $patterns[6] = '6';
    $patterns[7] = '7';
    $patterns[8] = '8';
    $patterns[9] = '9';
    $replacements[0] = '/०/';
    $replacements[1] = '/१/';
    $replacements[2] = '/२/';
    $replacements[3] = '/३/';
    $replacements[4] = '/४/';
    $replacements[5] = '/५/';
    $replacements[6] = '/६/';
    $replacements[7] = '/७/';
    $replacements[8] = '/८/';
    $replacements[9] = '/९/';
    return preg_replace($replacements, $patterns, $string);
  }
}

if (!function_exists('EngToUTF8')) {
  function EngToUTF8($string)
  {
    $num = array(
      "-" => "-",
      "0" => "०",
      "1" => "१",
      "2" => "२",
      "3" => "३",
      "4" => "४",
      "5" => "५",
      "6" => "६",
      "7" => "७",
      "8" => "८",
      "9" => "९"
    );
    return strtr($string, $num); //corrected 
  }
}

if (!function_exists('checklistStatus')) {
  function checklistStatus($status, $checklistId = null)
  {
    $statusText = '';
    $badgeClass = '';

    switch ($status) {
      case 0:
        $statusText = 'प्रारम्भिक दर्ता';
        $badgeClass = 'bg-secondary';
        break;
      case 1:
        $statusText = 'सिफारीस भएको';
        $badgeClass = 'bg-primary';
        break;
      case 2:
        $statusText = 'स्वीकृत भएको';
        $badgeClass = 'bg-success';
        break;
      default:
        $statusText = 'अज्ञात';
        $badgeClass = 'bg-danger';
        break;
    }

    $badge = "<span class='badge {$badgeClass}'>{$statusText}</span>";

    // Add notification comment if exists for current user
    if ($checklistId && auth()->check()) {
      $notification = \App\Models\Notification::where('checklist_id', $checklistId)
        ->where('to_user_id', auth()->id())
        ->where('action_type', 'send_back')
        ->latest()
        ->first();

      if ($notification) {
        $badge .= "<br><small class='text-danger'><i class='fas fa-comment'></i> {$notification->comment}</small>";
      }
    }

    return $badge;
  }
}


if (!function_exists('checklistStatus')) {
  function checklistStatus($status, $checklistId = null, $showComment = false)
  {
    $statusText = '';
    $badgeClass = '';
    $icon = '';

    switch ($status) {
      case 0:
        // Check the latest notification status
        if ($checklistId) {
          $latestSendBack = \App\Models\Notification::where('checklist_id', $checklistId)
            ->where('action_type', 'send_back')
            ->latest()
            ->first();

          $latestSendToVerify = \App\Models\Notification::where('checklist_id', $checklistId)
            ->where('action_type', 'send_to_verify')
            ->latest()
            ->first();

          if ($latestSendToVerify && (!$latestSendBack || $latestSendToVerify->created_at > $latestSendBack->created_at)) {
            $statusText = 'सिफारीसको प्रतीक्षामा';
            $badgeClass = 'bg-warning text-dark';
            $icon = 'fas fa-clock';
          } elseif ($latestSendBack && (!$latestSendToVerify || $latestSendBack->created_at > $latestSendToVerify->created_at)) {
            $statusText = 'सुधार आवश्यक';
            $badgeClass = 'bg-danger text-white';
            $icon = 'fas fa-exclamation-triangle';
          } else {
            $statusText = 'प्रारम्भिक दर्ता';
            $badgeClass = 'bg-secondary';
            $icon = 'fas fa-edit';
          }
        } else {
          $statusText = 'प्रारम्भिक दर्ता';
          $badgeClass = 'bg-secondary';
          $icon = 'fas fa-edit';
        }
        break;
      case 1:
        $statusText = 'सिफारीस भएको';
        $badgeClass = 'bg-primary';
        $icon = 'fas fa-check-circle';
        break;
      case 2:
        $statusText = 'स्वीकृत भएको';
        $badgeClass = 'bg-success';
        $icon = 'fas fa-medal';
        break;
      default:
        $statusText = 'अज्ञात';
        $badgeClass = 'bg-danger';
        $icon = 'fas fa-question';
        break;
    }

    return "<span class='badge {$badgeClass}'><i class='{$icon}'></i> {$statusText}</span>";
  }
}
