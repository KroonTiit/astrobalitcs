<?php 
        require_once 'src/TimeCalculator.php';

        if (isset($_POST['endTime']) && isset($_POST['startTime'])) {
            if (validateTimeInput($_POST['startTime']) || validateTimeInput($_POST['endTime'])){
                $startTime = $_POST['startTime'];
                $endTime = $_POST['endTime'];
                $calculatedTime = calculateDayAndNightTime($_POST['startTime'], $_POST['endTime']);
                
            } else {
                echo "Sisestage aeg 15 minutiliste intervallidena HH:MM formaadis.";
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        <?php if ( isset($_POST["scrollPosition"] ) ): ?>
        window.scrollTo( 0, <?php echo intval( $_POST["scrollPosition"] ); ?> );
    <?php endif; ?>

    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Astrokell</title>
</head>
<body  style="width: 100%">
    <section>
        <img src="src/sky.png" id="sky">
        <img src="src/green_hills.png" id="green">
        <h2 id="roket">&#128640;</h2>
        <a href="#sec" id="btn" class="cta_button">Arvuta päeva ja öö aega</a>
        <img src="src/red_hills.png" id="red">
        <img src="src/ground.png" id="ground">
        
    </section>
    <div class="below_fold">
        <div class="container-sm">
            <div class="d-flex justify-content-center col-height">
                <div id="sec" class="col-6 text-center">
                    <h1>Astrokell</h1>
                    <form method="post">
                        <div class="form-col align-items-center">
                            <div class="row-auto mb-3">
                                <input class="form-control" type="text" id="startTime" name="startTime" placeholder="Algusaeg">
                            </div>
                            <div class="row-auto mb-3">
                                <input class="form-control" type="text" id="endTime" name="endTime" placeholder="Lõppaeg">
                            </div>
                                <input type="hidden" name="scrollPosition" class="scrollPosition" />
                            <div class="row-auto mb-3">
                                <button type="submit" class="btn btn-primary mb-2">Arvuta</button>
                            </div>
                        </div>
                    </form>

                    <div class="result-panel container-sm">
                        <p><?php echo isset($_POST['startTime']) ? 'Algusaeg: '.$_POST['startTime'] : '' ?> <?php echo isset($_POST['startTime']) ? 'Lõppaeg: '.$_POST['endTime'] : '' ?></p>
                        <h3>Päevane aeg: <?php echo isset($calculatedTime['day']) ? $calculatedTime['day']. ' tundi' : '' ?></h3>
                        <h3>Öine aeg: <?php echo isset($calculatedTime['night']) ? $calculatedTime['night']. ' tundi' : '' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    let sky = document.getElementById('sky');
    let green = document.getElementById('green');
    let red = document.getElementById('red');
    let ground = document.getElementById('ground');
    let roket = document.getElementById('roket');
    let btn = document.getElementById('btn');

    window.addEventListener('scroll', function(){
    let value = window.scrollY;
    sky.style.top = value * 0.85 + 'px';
    green.style.top = value * 0.6 + 'px';
    red.style.top = value * 0.35 + 'px';
    ground.style.top = value * 0.1 + 'px';
    roket.style.marginBottom = value * 1.1 + 'px';
    roket.style.marginLeft = value * 1.1 + 'px';
    });

    jQuery( ".journal-entry-form").submit( function() {
        jQuery(this).find( ".scrollPosition" ).val( window.scrollY );
    });
    <?php if ( isset($_POST["scrollPosition"] ) ): ?>
        // JUMP BACK TO SCROLL LOCATION WHEN FORM WAS SUBMITTED
        window.scrollTo( 0, <?php echo intval( $_POST["scrollPosition"] ); ?> );
    <?php endif; ?>
</script>
</html>
