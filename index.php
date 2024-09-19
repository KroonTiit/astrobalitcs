<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

    <title>Astrokell</title>
</head>
<body>
    <h1>Astrokell</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input type="text" id="startTime" name="startTime" placeholder="Algusaeg">
            </div>
            <div class="col-auto">
                <input type="text" id="endTime" name="endTime" placeholder="Lõppaeg">
            </div>
        
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Arvuta</button>
            </div>
        </div>
    </form>

    <div class="form-col align-items-center">
    <div class="col-auto">
        start time: <?php array_key_exists("startTime", $_GET) ?$_GET["startTime"] : null ?>
    </div>
    <div class="col-auto">
        end time: <?php array_key_exists("endtime", $_GET) ?$_GET["endtime"] : null ?>
    </div>
</div>  
</body>
<script>
    var startTime = new TimePicker('startTime', {
        lang: 'en',
        theme: 'dark'
    });
    startTime.on('change', function(evt) {
    
        var value = (evt.hour || '00') + ':' + (evt.minute || '00');
        evt.element.value = value;

    });

    var endTime = new TimePicker('endTime', {
        lang: 'en',
        theme: 'dark'
    });
    endTime.on('change', function(evt) {
    
        var value = (evt.hour || '00') + ':' + (evt.minute || '00');
        evt.element.value = value;

    });
</script>
</html>
