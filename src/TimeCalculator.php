<?php 
    function calculateDayAndNightTime($startTime, $endTime) {
        $startTime = date_create_from_format('H:i', $startTime);
        $endTime = date_create_from_format('H:i', $endTime);
        $sixAM = date_create_from_format('H:i', '06:00');
        $tenPM = date_create_from_format('H:i', '22:00');
        $twelvePM = date_create_from_format('H:i', '00:00'); 
        $dayTime = 0;
        $nightTime = 0;

        if (isStartDuringDay($startTime, $sixAM, $tenPM) && isEndDuringDay($endTime, $sixAM, $tenPM)) {
            $dayTime = calculateTimeDiff($endTime, $startTime);

        } elseif (!isStartDuringDay($startTime, $sixAM, $tenPM) && !isEndDuringDay($endTime, $sixAM, $tenPM)) {
            if(($startTime >= $tenPM) && ($sixAM >= $endTime)) {
                // start afther 22:00  end before 06:00

                $aftherMidnight = date_diff($endTime, $twelvePM, true);
                $beforeMidnight = date_diff($startTime, $twelvePM->modify('+1 day'), true);
            
                $nightTime = calculateTimeDiffOverMidnight($aftherMidnight, $beforeMidnight);

            } else {
                // both before 06:00 but afther 00:00
                if ($startTime >= $endTime) {
                    $aftherMidnight = date_diff($startTime, $sixAM, true);
                    $midnightToEndTime = calculateTimeDiff($endTime, $twelvePM);
                    $beforeMidnight = date_diff($tenPM, $twelvePM->modify('+1 day'), true);

                    $nightTime = calculateTimeDiffOverMidnight($aftherMidnight, $beforeMidnight) + $midnightToEndTime;
                    $dayTime = calculateTimeDiff($sixAM, $tenPM);
                } else {
                    $nightTime = calculateTimeDiff($endTime, $startTime);
                }
            }
        } elseif (isStartDuringDay($startTime, $sixAM, $tenPM) && !isEndDuringDay($endTime, $sixAM, $tenPM)) {
            $dayTime = calculateTimeDiff($tenPM, $startTime);
            
            if($endTime >= $tenPM){
                // end after 22:00

                $nightTime = calculateTimeDiff($tenPM, $endTime);

            } else {
                // end before 06:00

                $aftherMidnight = date_diff($endTime, $twelvePM, true);
                $beforeMidnight = date_diff($tenPM, $twelvePM->modify('+1 day'), true);
                
                $nightTime = calculateTimeDiffOverMidnight($aftherMidnight, $beforeMidnight);
            }
        } elseif (!isStartDuringDay($startTime, $sixAM, $tenPM) && isEndDuringDay($endTime, $sixAM, $tenPM)) {
            $dayTime = calculateTimeDiff($sixAM, $endTime);
            
            if($startTime <= $sixAM) {
                // start before 06:00

                $nightTime = calculateTimeDiff($sixAM, $startTime);
                
            } else {
                // start afther 22:00

                $aftherMidnight = date_diff($sixAM, $twelvePM, true);
                $beforeMidnight = date_diff($startTime, $twelvePM->modify('+1 day'), true);

                $nightTime = calculateTimeDiffOverMidnight($aftherMidnight, $beforeMidnight);
            }
        }

        return ['day' => $dayTime, 'night' => $nightTime];
    }

    function isStartDuringDay($startTime, $sixAM, $tenPM) {
        if ($sixAM <= $startTime  && $startTime <= $tenPM){
            return true;
        }

        return false;
    }

    function isEndDuringDay($endTime, $sixAM, $tenPM) {
        if ($sixAM <= $endTime && $endTime <= $tenPM) {
            return true;
        }

        return false;
    }


    function calculateTimeDiffOverMidnight($aftherMidnight, $beforeMidnight) {
        $totalHours = $aftherMidnight->h + $beforeMidnight->h;
        $totalMinutes = $aftherMidnight->i + $beforeMidnight->i;

        if ($totalMinutes >= 60) {
            $totalHours += intdiv($totalMinutes, 60);
            $totalMinutes = $totalMinutes % 60;
        }

        return inToDecimalTime($totalHours, $totalMinutes);
    }

    function calculateTimeDiff($time1,$time2) {
        $diff = date_diff($time1, $time2, true);
        return inToDecimalTime($diff->h, $diff->i);
    }

    function inToDecimalTime($hours, $minutes) {
        $decimalMinutes = $minutes / 60;
        $totalHours = $hours + $decimalMinutes;
        
        return round($totalHours, 2);
    }

    function validateTimeInput($time) {
        if (!preg_match('/^([01][0-9]|2[0-3]|00):(00|15|30|45)$/', $time)) {
            return false;
        }

        return true;
    }
?>