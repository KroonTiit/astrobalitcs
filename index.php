<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


    <title>Astrokell</title>
</head>
<body>
    <h1>Astrokell</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="GET">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input class="timepicker" type="text" id="startTime" name="startTime" placeholder="Algusaeg">
            </div>
            <div class="col-auto">
                <input class="timepicker" type="text" id="endTime" name="endTime" placeholder="Lõppaeg">
            </div>
        
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Arvuta</button>
            </div>
        </div>
    </form>

    <div class="form-col align-items-center">
        <?php 
        $dayTime = null;
        $nightTime = null;

        if (isset($_GET['endTime']) && isset($_GET['startTime'])) {
            $startTime = date_create_from_format('H:i', $_GET['startTime']);
            $endTime = date_create_from_format('H:i', $_GET['endTime']);
            $sixAM = date_create_from_format('H:i', '06:00');
            $tenPM = date_create_from_format('H:i', '22:00');
            $twelvePM = date_create_from_format('H:i', '00:00');

            if ( ($sixAM <= $startTime  && $startTime <= $tenPM) && ($sixAM <= $endTime && $endTime <= $tenPM) ) {
            //  mõlemad päeva aja sees
                $diff = date_diff($endTime, $startTime, true);
                $dayTime = $diff->format("%h tundi %i minutit");
                $nightTime = 0;
            } elseif(($sixAM >= $startTime || $startTime >= $tenPM) && ($sixAM >= $endTime || $endTime >= $tenPM)) {
                // mõlemad öö aja sees
                $dayTime = 0;
               
                if(($startTime >= $tenPM) && ($sixAM >= $endTime)) {
                    // algus pärast 22 lõpp enne 06:00
                    $aftherMidnight = date_diff($endTime, $twelvePM, true);
                    $beforeMidnight = date_diff($startTime, $twelvePM->modify('+1 day'), true);
                 
                    $totalHours = $aftherMidnight->h + $beforeMidnight->h;
                    $totalMinutes = $aftherMidnight->i + $beforeMidnight->i;

                    if ($totalMinutes >= 60) {
                        $totalHours += intdiv($totalMinutes, 60);  
                        $totalMinutes = $totalMinutes % 60;        
                    }
                    $nightTime = $totalHours. " hours ". $totalMinutes." minutes";
                } else {
                    // algus ja lõpp enne 06:00
                    $diff = date_diff($endTime, $startTime, true);
                    $nightTime = $diff->format("%h tundi %i minutit");
                }

            } elseif(($sixAM <= $startTime  && $startTime <= $tenPM) && ($sixAM >= $endTime || $endTime >= $tenPM)) {
                // algus päeval lõpp öösel
                $diff = date_diff($tenPM, $startTime, true);
                $dayTime = $diff->format("%h hours %i minutes");
                
                if($endTime >= $tenPM){
                    // lõpp pärast 22:00
                    $diff = date_diff($tenPM, $endTime, true);
                    $nightTime = $diff->format("%h hours %i minutes");
                } else {
                    // lõpp enne 06:00
                    $aftherMidnight = date_diff($endTime, $twelvePM, true);
                    $beforeMidnight = date_diff($tenPM, $twelvePM->modify('+1 day'), true);

                    $totalHours = $aftherMidnight->h + $beforeMidnight->h;
                    $totalMinutes = $aftherMidnight->i + $beforeMidnight->i;

                    if ($totalMinutes >= 60) {
                        $totalHours += intdiv($totalMinutes, 60);  
                        $totalMinutes = $totalMinutes % 60;        
                    }
                    
                    $nightTime = $totalHours. " hours ". $totalMinutes." minutes";
                }
                
            } elseif(($sixAM >= $startTime || $startTime >= $tenPM) && ($sixAM <= $endTime && $endTime <= $tenPM)) {
                // algus öösel lõpp päeval

                $diff = date_diff($sixAM, $endTime, true);
                $dayTime = $diff->format("%h hours %i minutes");
                
                if($startTime <= $sixAM) {
                    // algus enne 06:00
                    $diff = date_diff($sixAM, $startTime, true);
                    $nightTime = $diff->format("%h hours %i minutes");
                } else {
                    // algus pärast 22:00
                    $aftherMidnight = date_diff($sixAM, $twelvePM, true);
                    $beforeMidnight = date_diff($startTime, $twelvePM->modify('+1 day'), true);

                    $totalHours = $aftherMidnight->h + $beforeMidnight->h;
                    $totalMinutes = $aftherMidnight->i + $beforeMidnight->i;

                    if ($totalMinutes >= 60) {
                        $totalHours += intdiv($totalMinutes, 60);  
                        $totalMinutes = $totalMinutes % 60;        
                    }
                    $nightTime = $totalHours. " hours ". $totalMinutes." minutes";
                }
            } 
            else {
                $dayTime = 0;
                $nightTime = 0;
                echo "error in logic";
            }
        } else {
            echo "Vali nii algus kui ka lõpp aeg";
        } 
        ?>

        <div class="col-auto">
            day time: <?php echo $dayTime ?>
        </div>
        <div class="col-auto">
            night time: <?php echo $nightTime ?>
        </div>
    </div>
</body>
<script>
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    
</script>
</html>
