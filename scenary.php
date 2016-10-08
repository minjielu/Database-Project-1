<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="index.php"><button type="button">Return to main page</button></a><br/>
        <?php
        if(isset($_POST['sumit3']))
        {
            $con=mysqli_connect("database-new.cs.tamu.edu","minjielu","199035Rr");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"project1");
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
        if(isset($_POST['sumit2']))
        {
            $con=mysqli_connect("database-new.cs.tamu.edu","minjelu","199035Rr");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"project1");
            $qry='UPDATE Scenary SET location=\''.$_POST['location2'].'\',description="'.$_POST['description1'].'" WHERE location=\''.$_POST['oldloca'].'\'';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t write into scenary! Probably because the new location name already exists.</font>';
            }
            else
            {
                echo '<font color="red">location '.$_POST['oldloca'].' is updated.</font>';
            }
        }
        if(isset($_POST['sumit1']))
        {
            $con=mysqli_connect("database-new.cs.tamu.edu","minjielu","199035Rr");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"project1");
            $qry='INSERT INTO Scenary VALUES (\''.$_POST['location1'].'\',"'.$_POST['description'].'")';
            $result=mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t write into scenary! Probably because the location already exists.</font>';
            }
        }
        $con=mysqli_connect("database-new.cs.tamu.edu","minjielu","199035Rr");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"project1");
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
        ?>
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
