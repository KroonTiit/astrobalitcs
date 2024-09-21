<?php 
    function calculateDayAndNightTime($startTime, $endTime) {
        $startTime = date_create_from_format('H:i', $startTime);
        $endTime = date_create_from_format('H:i', $endTime);
        $sixAM = date_create_from_format('H:i', '06:00');
        $tenPM = date_create_from_format('H:i', '22:00');
        $twelvePM = date_create_from_format('H:i', '00:00'); 
        $dayTime = 0;
        $nightTime = 0;

        if (isStartDuringDay($startTime) && isEndDuringDay($endTime)) {
            $dayTime = calculateTimeDiff($endTime, $startTime);

        } elseif (isStartAtNight($startTime) && isEndAtNight($endTime)) {
            if(($startTime >= $tenPM) && ($sixAM >= $endTime)) {
                // algus pärast 22 lõpp enne 06:00

                $aftherMidnight = date_diff($endTime, $twelvePM, true);
                $beforeMidnight = date_diff($startTime, $twelvePM->modify('+1 day'), true);
            
                $nightTime = calculateTimeOverMidnight($aftherMidnight, $beforeMidnight);

            } else {
                // algus ja lõpp enne 06:00

                $nightTime = calculateTimeDiff($endTime, $startTime);
            }
        } elseif (isStartDuringDay($startTime) && isEndAtNight($endTime)) {
            $dayTime = calculateTimeDiff($tenPM, $startTime);
            
            if($endTime >= $tenPM){
                // lõpp pärast 22:00

                $nightTime = calculateTimeDiff($tenPM, $endTime);

            } else {
                // lõpp enne 06:00

                $aftherMidnight = date_diff($endTime, $twelvePM, true);
                $beforeMidnight = date_diff($tenPM, $twelvePM->modify('+1 day'), true);
                
                $nightTime = calculateTimeOverMidnight($aftherMidnight, $beforeMidnight);
            }
        } elseif (isStartAtNight($startTime) && isEndDuringDay($endTime)) {
            $dayTime = calculateTimeDiff($sixAM, $endTime);
            
            if($startTime <= $sixAM) {
                // algus enne 06:00

                $nightTime = calculateTimeDiff($sixAM, $startTime);
                
            } else {
                // algus pärast 22:00

                $aftherMidnight = date_diff($sixAM, $twelvePM, true);
                $beforeMidnight = date_diff($startTime, $twelvePM->modify('+1 day'), true);

                $nightTime = calculateTimeOverMidnight($aftherMidnight, $beforeMidnight);
            }
        }

        return ['day' => $dayTime, 'night' => $nightTime];
    }
    
    function isStartDuringDay() {
        if ($sixAM <= $startTime  && $startTime <= $tenPM){
            return true;
        }

        return false;
    }

    function isEndDuringDay() {
        if ($sixAM <= $endTime && $endTime <= $tenPM) {
            return true;
        }

        return false;
    }

    function isStartAtNight() {
        if ($sixAM >= $startTime || $startTime >= $tenPM) {
            return true;
        }

        return false;
    }

    function isEndAtNight() {
        if ($sixAM >= $endTime || $endTime >= $tenPM) {
            return true;
        }

        return false;
    }

    function calculateTimeOverMidnight($aftherMidnight, $beforeMidnight) {
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
        
        return number_format($totalHours, 1);
    }

    function validateTimeInput($time) {
        if (!preg_match('/^([01][0-9]|2[0-3]|00):(00|15|30|45)$/', $time)) {
            return false;
        }

        return true;
    }
?>