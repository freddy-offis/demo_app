<?php
    session_start();
    date_default_timezone_set('Australia/Sydney');
    //shell_exec('php get_twitter_token.php');
    //$str = file_get_contents('twitter_token.json');
    //$arr = json_decode($str, true);
    //$token = $arr['access_token'];
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Hello World</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="favicon.png" rel="icon" />
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="assets/css/main.css" />
        <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </head>
    <body class="loading">
        <div id="wrapper">
            <div id="bg"></div>
            <div id="overlay"></div>
            <div id="main">
                <!-- Header -->
                <header id="header">
                    <h1>Hello World! (PROD!!!)</h1>
                    <div style="padding: 30px; margin: 0 auto;">
                        <h2>Let's take a look at the cities in our database</h2>
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "root";
                            $dbname = "demo_app";
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
                            $sql = "SELECT * FROM city LIMIT 20";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                echo '<table style="width:600px; margin:0 auto;" cellspacing="3" cellpadding="3" border="1">';
                                echo '<tbody>';
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["ID"] . "</td>";
                                    echo "<td>" . $row["Name"] . "</td>";
                                    echo "<td>" . $row["District"] . "</td>";
                                    echo "<td>" . $row["Population"] . "</td>";
                                    echo "</tr>";
                                }
                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo "The database is empty!";
                            }
                            $conn->close();
                        ?>
                    </div>
                </header>
                <!-- Footer -->
                <footer id="footer">
                    <span class="copyright">
                        <p>&copy; Offis Multi-Cloud</p>
                    </span>
                </footer>
            </div>
        </div>
        <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
        <script>
            window.onload = function() {
                document.body.className = '';
            }
            window.ontouchmove = function() {
                return false;
            }
            window.onorientationchange = function() {
                document.body.scrollTop = 0;
            }
            twttr.widgets.createTimeline(
                {
                  sourceType: "profile",
                  screenName: "virtualoffis"
                },
                document.getElementById("container1"),
                {
                    height: 500,
                    chrome: "nofooter",
                    linkColor: "#820bbb",
                    borderColor: "#a80000"
                }
            );
        </script>
    </body>
</html>