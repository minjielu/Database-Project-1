<!DOCTYPE html>
<!--
This web page displays detail of a picture.
If the edit button is pressed, it turns into a form allowing user to modify the image detail.
This page also handles updating of an image detail.
-->
<html>
    <body>
        <font size="3"><h1>Picture Detail</h1></font>
        <?php
        if(isset($_POST['update']))              //Code from here updates an image detail to the database according to the input.
        {
            $con=mysqli_connect("db4free.net","minjielu","database1");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='UPDATE Images SET name=\''.$_POST['name'].'\',class=\''.$_POST['class'].'\',date=\''.$_POST['date'].'\',location=\''.$_POST['location'].'\' WHERE id='.$_GET['picid'];
            $result=  mysqli_query($con, $qry);
            if(!$result)
            {
                echo '<font color="red">Can\'t update the picture detail!</font>';
            }
        }
        if(!isset($_POST['edit']))    //Code from here displays detail of an image. When the edit image button is pressed, it displays a form which allows users to change details. 
        {
            $con=mysqli_connect("db4free.net","minjielu","database1");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='SELECT * FROM Images WHERE id='.$_GET['picid'];
            $result1=  mysqli_query($con, $qry);
            $result=  mysqli_fetch_array($result1);
            if($result)
            {   
                echo '<div>
                      <img height="'.$result[3].'" width="'.$result[4].'" src="data:image;base64,'.$result[7].'"><br/><br/>
                      <font size="4"><form method="POST"><input type="submit" value="Edit detail" name="edit" /></form>
                      <b>Name: </b>'.$result[1].'<br/>
                      <b>Class: </b>'.$result[2].'<br/>
                      <b>Date: </b>'.$result[5].'<br/>
                      <b>Location: </b>'.$result[6].'
                      </div>';
                if($result[6]!=NULL)
                {
                    $qry='SELECT description FROM Scenary WHERE location='.'"'.$result[6].'"';
                    $result2=  mysqli_query($con, $qry);
                    if(!$result2)
                    {
                        echo '<font color="red">Can\'t retrieve location information</font></font>';
                    }
                    else
                    {
                        $inf=  mysqli_fetch_array($result2);
                        echo '<b>Information for '.$result[6].':</b><br/>'
                             .$inf[0].'</font><br/>';
                    }
                }
                }
            else
            {
                echo 'Information for image No.'.$_GET['picid'].' can\'t be retrieved!'; 
            }
            echo '<br/><a href="index.php"><button type="button">Return to main page</button></a>';
        }
        else
        {
            $con=mysqli_connect("db4free.net","minjielu","database1");
            if(!$con)
            {
                echo "<br/>Database connection issue!";
            }
            mysqli_select_db($con,"minjieluproject1");
            $qry='SELECT * FROM Images WHERE id='.$_GET['picid'];
            $result1=  mysqli_query($con, $qry);
            $result=  mysqli_fetch_array($result1);
            if($result)
            {   
                echo '<div>
                      <form method="post" enctype="multipart/form-data">
                      <img height="'.$result[3].'" width="'.$result[4].'" src="data:image;base64,'.$result[7].'"><br/><br/>
                      <br/>
                      <font size="2">
                      <br/><br/>
                      <b>Name of the picture:</b>
                      <input type="text" name="name" value="'.$result[1].'" size="12" />
                      <br/><br/>
                      <b>Type of the picture:</b>
                      <select name="class">
                          <option>Scenary</option>
                          <option>Portrait</option>
                      </select>
                      <br/><br/>
                      <b>Data:<b>
                      <input type="text" name="date" value="'.$result[5].'" size="12" />
                      <br/><br/>
                      <b>Location of the picture:</b>
                      <select name="location">';
                        $con=mysqli_connect("db4free.net","minjielu","database1");
                        if(!$con)
                        {
                            echo "<br/>Database connection issue!";
                        }
                        mysqli_select_db($con,"minjieluproject1");
                        $qry="SELECT location FROM Scenary ORDER BY location";
                        $result3=  mysqli_query($con, $qry);
                        if(!$result)
                        {
                            echo "Can't retrieve location information.";
                        }
                        while($row=  mysqli_fetch_array($result3))
                        {
                            echo '<option>'.$row[0].'</option>';
                        }
                echo  '</select>
                       <br/><br/>
                       <input type="submit" name="update" value="Update" />
                       </font>
                       </form>
                       <a href="detail.php?picid='.$_GET['picid'].'"><button type="button">Return to picture detail</button></a>
                       </div>';            
            }
        }
        mysqli_close($con);
        ?>
    </body>
</html>
