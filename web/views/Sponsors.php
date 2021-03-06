<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Kiawanis Fair - Sponsors</title>

        <link rel="stylesheet" type="text/css" href="/stylesheets/sponsors.css">
    </head>
    <body>
        <header>
                <nav>
                    <ul>
                        <li><a href="/views/main.html" >Home</a></li>
                        <li><a href="/views/Vendors.php">Vendors</a></li>
                        <li><a href="/views/News.php">News</a></li>
                        <li><a href="/views/Applications.php">Applications</a></li>
                        <li><a href="/views/Shows.php">Shows</a></li>
                        <li><a href="/views/Map.php">Map</a></li>
                        <li><a href="/views/Sponsors.php">Sponsors</a></li>
                    </ul>
                </nav>
            </header>

            <div class="tab">
                <button class="tablinks" onclick="opentab(event,'all')">All Sponsors</button>
                <button class="tablinks" onclick="opentab(event,'add')">Add Sponsors</button>
            </div>

                <script>
                function opentab(evt, tabName) {

                  var i, tabcontent, tablinks;
                  tabcontent = document.getElementsByClassName("tabcontent");
                  for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                  }
                  tablinks = document.getElementsByClassName("tablinks");
                  for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                  }
                  document.getElementById(tabName).style.display = "block";
                  evt.currentTarget.className += " active";
                }
            </script>

        <div id="all" class="tabcontent">
            <h1>All Sponsors</h1>
            <form action="" method="POST">
                <label for = "del" id="none"> Delete Row: </label>
                <input type="text" id="del" name="del" placeholder="Enter ID">


                <input type="submit" value="Delete" id="delete" name="delete" class="deletion">
            </form>
            <?php
                    $host = "ogeechee-fair.cyxvjubgt7cw.us-east-1.rds.amazonaws.com";
                    $port = "3306";
                    $user = "fair_admin";
                    $password = "KiwanisClub";
                    $db = "applications";

                    $con = new mysqli($host, $user, $password, $db);
                    $sql = "SELECT * From applications.Sponsors";
                    $results = $con->query($sql);

                    if($results->num_rows>0){
                        echo "<table><tr><th>SponsorID</th><th>Sponsor Name</th><th>Sponsor Title</th><th>Sponsor Logo</th></tr>";
                        while($row = $results->fetch_assoc()){
                            echo "<tr><td>". $row['SponsorID']. "</td><td>". $row['SponsorName']. "</td><td>". $row['SponsorTitle']. "</td><td><img src='data:image/jpeg;base64,".base64_encode($row['SponsorLogo']) ."'></td></tr>";
                        }
                        echo "</table>";
                    }

                    $con->close();
                ?>
        </div>

         <?php
            $host = "ogeechee-fair.cyxvjubgt7cw.us-east-1.rds.amazonaws.com";
            $port = "3306";
            $user = "fair_admin";
            $password = "KiwanisClub";
            $db = "applications";

            if(isset($_POST['delete'])){
                $id = $_POST['del'];

                $con = new mysqli($host, $user, $password, $db);
                $sql = "DELETE FROM applications.Sponsors WHERE (`SponsorID` = $id);";
                $results = $con->query($sql);

                header("Refresh:0");
            }
        ?>


        <div id="add" class="tabcontent">
            <section>
                <form action="" method="POST">
                    <fieldset>
                        <legend>Add Sponsor</legend>

                        <label for="name">Sponsor Name: </label>
                        <input type="text" id="sponsorName" name="sponsorName">

                        <label for="title">Sponsor Level: </label>
                        <input type="text" id="sponsorTitle" name="sponsorTitle">

                        <label for="image">Sponsor Logo: </label>
                        <input type="file" id="sponsorLogo" name="sponsorLogo">
                        <p>Note: Image file sizes larger than 65kb will display improperly.</p>

                        <section id="submitButtons">
                            <input  id="submit" value ="Submit" type="submit" name="submit" class="submission">
                        </section>
                    </fieldset>
                </form>
                <br>
            </section>
        </div>

        <?php
            $host = "ogeechee-fair.cyxvjubgt7cw.us-east-1.rds.amazonaws.com";
            $port = "3306";
            $user = "fair_admin";
            $password = "KiwanisClub";
            $db = "applications";

            if(isset($_POST['submit'])){
                $name = $_POST['sponsorName'];
                $title = $_POST['sponsorTitle'];
                $logo = $_POST['sponsorLogo'];

                $con = new mysqli($host, $user, $password, $db);
                $sql = "INSERT INTO `applications`.`Sponsors` (`sponsorName`, `sponsorTitle`, `sponsorLogo`) VALUES (" ."'". $name ."', '" .$title ."', '" .FILE_READ($logo) ."');";
                $results = $con->query($sql);

                header("Refresh:0");
            }
        ?>

    </body>
</html>