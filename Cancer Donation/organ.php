<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Life</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">


</head>

<body>


    <?php
include('commen/header.php');
?>


    <section class="container donate_container">
        <h1>Donate Hair</h1>
        <h3>Find nearest salon to donate hair</h3>
        <hr>
    </section>

    <section class="container map_container2">

        <div class="map" id="map-canvas" style="width: 100%; height: 600px;">
        </div>
    </section>

    <section class="container">
        <div class="details_table">
            <table>
                <thead>
                    <tr>
                        <td>Salon Names</td>
                        <td>Address</td>
                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `salons`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>

                    </tr>
                </tbody>
                <?php 
                }
                ?>

            </table>
        </div>
    </section>

    <div class="footer_margin">

    </div>








    <?php
include('commen/footer.php');
?>
    <script type="text/javascript">
    var map;
    var latlng;
    var infowindow;

    $(document).ready(function() {

        $.ajax({ //library for JS help front-end to talk back-end, without having to reload the page
            url: "HelpMapper-backend.php",
            async: true,
            dataType: 'json', // is a language
            success: function(data) {
                console.log(data);
                ViewCustInGoogleMap(data);
            }
        });

        ViewCustInGoogleMap(data);
    });

    function ViewCustInGoogleMap(data) {
        var gm = google.maps; //create instance of google map
        //add initial map option
        var mapOptions = {
            center: new google.maps.LatLng(7.0010222, 80.1842111),
            zoom: 10,
            //mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        //bine html tag to show the google map and bind mapoptions
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        //create instance of google information windown
        infowindow = new google.maps.InfoWindow();
        var marker, i;
        // var MarkerImg = "https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle.png";
        // var MarkerImg2 = "https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle_blue.png";

        //loop through all the locations and point the mark in the google map
        for (var i = 0; i < data.length; i++) {
            marker = new gm.Marker({
                position: new gm.LatLng(data[i]['lat'], data[i]['lng']),
                map: map,
                // icon: MarkerImg
            });


            //add info for popup tooltip
            google.maps.event.addListener(
                marker,
                'click',
                (
                    function(marker, i) {
                        return function() {
                            infowindow.setContent(data[i]['name']);
                            infowindow.open(map, marker);
                        };
                    }
                )(marker, i)

            );
        }

    }
    </script>

    <!-- custom js file link  -->
    <script src="commen/script.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgDWBXUaAtdpQJ8wjRHzQLUFrIaE3RYG0&sensor=true"
        type="text/javascript"></script>

</body>

</html>