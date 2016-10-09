<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $con=mysqli_connect("db4free.net","minjielu","199035Rr");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='SELECT * FROM Scenary WHERE location=\''.$_GET['loca'].'\'';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t retrieve the location information.</font>';
            }
            else
            {
            $row=  mysqli_fetch_array($result);   
            echo   '<div>
                        <b><font size="3">Edit existing location</font></b>
                        <form action="scenary.php" method="POST" enctype="multipart/form-data">
                            <font size="2">
                            <b>Location:</b>
                            <input type="text" name="location2" value="'.$row[0].'" /><br/>
                            <b>Description:</b>
                            <br/>
                            <textarea type="text" name="description1" rows="6" cols="80">'.$row[1].'</textarea>
                            <br/>
                            <input type="hidden" name="oldloca" value="'.$row[0].'"/>
                            <input type="submit" value="Update" name="sumit2" />
                            <input type="submit" value="Delete this location" name="sumit3" />
                            <font>
                        </form>
                    </div>';
            }
        ?>
    </body>
</html>
