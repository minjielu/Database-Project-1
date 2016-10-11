<!DOCTYPE html>
<!--
This web page displays item in the Scenary database.
It handles creating, updating, and deleting location items.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="index.php"><button type="button">Return to main page</button></a><br/>
        <?php
        if(isset($_POST['sumit3']))           //Code from here handls deleting a location.
        {
            $con=mysqli_connect("db4free.net","minjielu","database1");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='DELETE FROM Scenary WHERE location=\''.$_POST['oldloca'].'\'';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t delete the location!</font>';
            }
            else
            {
                echo '<font color="red">location '.$_POST['oldloca'].' is deleted.</font>';
            }
        }
        if(isset($_POST['sumit2'])) //Code from here updates existing location.
        {
            $con=mysqli_connect("db4free.net","minjielu","database1");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='UPDATE Scenary SET location=\''.$_POST['location2'].'\',description="'.$_POST['description1'].'" WHERE location=\''.$_POST['oldloca'].'\'';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t update location information</font>';
            }
            else
            {
                echo '<font color="red">location '.$_POST['oldloca'].' is updated.</font>';
            }
        }
        if(isset($_POST['sumit1']))                 //Code from here creates new location.
        {
            $con=mysqli_connect("db4free.net","minjielu","database1");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='INSERT INTO Scenary VALUES (\''.$_POST['location1'].'\',"'.$_POST['description'].'")';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t write into scenary! Probably because the location already exists.</font>';
            }
        }
        $con=mysqli_connect("db4free.net","minjielu","199035Rr");   //Code from here displays all the locations.
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='SELECT location FROM Scenary ORDER BY location';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<br/><font color="red">Can\'t retrieve scenary information!</font>';
            }
            else
            {
                echo '<br/><b><font size="3">Click on the following location to edit it</font></b><br/>';
                while($row=mysqli_fetch_array($result))
                {
                    echo '<a href="editscenary.php?loca='.$row[0].'">'.$row[0].'</a><br/>';
                }
            }
            mysqli_close($con);
        ?>
        <!-- You can create new location here -->
        <br/>
        <div>
            <b><font size="3">Create new location</font></b>
            <form method="POST" enctype="multipart/form-data">
                <font size="2">
                <b>Location:</b>
                <input type="text" name="location1" value="Example:Yellow Stone" /><br/>
                <b>Description:</b>
                <br/>
                <textarea type="text" name="description" rows="6" cols="80"></textarea>
                <br/>
                <input type="submit" value="Submit" name="sumit1" /><br/>
                <font>
            </form>
        </div>
    </body>
</html>
