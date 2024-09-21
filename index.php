<?php 
        require_once 'TimeCalculator.php';

        if (isset($_POST['endTime']) && isset($_POST['startTime'])) {
            if (validateTimeInput($_POST['startTime']) || validateTimeInput($_POST['endTime'])){
                $startTime = date_create_from_format('H:i', $_POST['startTime']);
                $endTime = date_create_from_format('H:i', $_POST['endTime']);
                $calculatedTime = calculateDayAndNightTime($_POST['startTime'], $_POST['endTime']);

            } else {
                echo "Sisestage aeg 15 minutiliste intervallidena HH:MM formaadis.";
            }
        }
        ?>
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
    <form method="post">
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
        <div class="col-auto">
            päevane aeg: <?php echo isset($calculatedTime['day']) ? $calculatedTime['day']. ' tundi' : '' ?>
        </div>
        <div class="col-auto">
            öine aeg: <?php echo isset($calculatedTime['night']) ? $calculatedTime['night']. ' tundi' : '' ?>
        </div>
    </div>
</body>
</html>
