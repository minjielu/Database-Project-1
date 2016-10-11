<!DOCTYPE html>
<!--
This is the index page of the web site.
It has three parts: upload new image, filter result and image display.
-->
<?php
    ini_set('mysql.connect_timeout',3000);
    ini_set('default_socket_timeout',3000);
?>
<html>
    <head>
    <basefont size="3">
    </head>
    <body>
        <div>
        <form method="post" enctype="multipart/form-data">
            <br/>
                <font size="5"><b>Upload New Image</b><font>
                <font size="2">
                <br/><br/>
                <b>Upload image file:</b>
                <input type="file" name="image"/>
                <br/><br/>
                <b>Name of the picture:</b>
                <input type="text" name="name" value="" size="12" />
                <br/><br/>
                <b>Type of the picture:</b>
                <select name="class">
                    <option>Scenary</option>
                    <option>Portrait</option>
                </select>
                <br/><br/>
                <b>Date:<b>
                <input type="text" name="date" value="YYYY-MM-DD" size="12" />
                <b>Date has to be later than 1980-01-01 and earlier than 2017-12-31. Default date is the current date.</b>
                <br/><br/>
                <b>Choose from existing location:</b>
                <select name="location">                           
                    <option>---choose location---</option>
                    <?php
                    $con=mysqli_connect("db4free.net","minjielu","database1");        //Choices of locations are retrieved from the Scenary database.
                    if(!$con)
                    {
                        echo "<br/>Database connection issue!";
                    }
                    mysqli_select_db($con,"minjieluproject1");
                    $qry="SELECT location FROM Scenary ORDER BY location";
                    $result=  mysqli_query($con, $qry);
                    if(!$result)
                    {
                        echo "Can't retrieve location information.";
                    }
                    while($row=  mysqli_fetch_array($result))
                    {
                        echo '<option>'.$row[0].'</option>';
                    }
                    ?>
                </select>
                <b> Or enter location yourself:</b>
                <input type="text" name="location2" value="Example:Yellow Stone" />
                <a href="scenary.php"><button type="button">Edit location database</button></a>
                <br/><br/>
                <input type="submit" name="sumit" value="Upload" />
                </font>
        </form>
        </div>
        <?php
            if(isset($_POST['sumit']))                             //Code from here will handle saving new image.
            {
                if(getimagesize($_FILES['image']['tmp_name'])==FALSE)
                {
                    echo "Please select an image.";
                }
                else
                {
                    $name=$_POST['name'];
                    $class=$_POST['class'];
                    if($_POST['location']!='---choose location---')
                    {
                        $location=$_POST['location'];
                    }
                    else
                    {
                        $location=$_POST['location2'];
                    }
                    if($_POST['date']=='YYYY-MM-DD')
                    {
                        date_default_timezone_set('UTC');                     //Date is set according to UTC and in the form of "YYYY-MM-DD".
                        $datearray= getdate();
                        $date=$datearray['year'].'-'.$datearray['mon'].'-'.$datearray['mday'];
                    }
                    else 
                    {
                        $date=$_POST['date'];
                    }
                    $sizey= getimagesize($_FILES['image']['tmp_name'])[0];
                    $sizex= getimagesize($_FILES['image']['tmp_name'])[1];
                    $image= addslashes($_FILES['image']['tmp_name']);
                    $image= file_get_contents($image);
                    $image= base64_encode($image);
                    saveimage($name,$class,$sizex,$sizey,$date,$location,$image);
                }
            }
            function saveimage($name,$class,$sizex,$sizey,$date,$location,$image)
            {
                $con=mysqli_connect("db4free.net","minjielu","database1");
                if(!$con)
                {
                    echo "<br/>Database connection issue.";
                }
                mysqli_select_db($con,"minjieluproject1");
                $qry='SELECT id FROM Images WHERE name=\''.$name.'\' and class=\''.$class.'\' and date=\''.$date.'\' and image=\''.$image.'\'';    //This query is used to avoid the image waiting for uploading is a copy of another image which already exists.
                $result=  mysqli_query($con, $qry);
                if(mysqli_num_rows($result)<1)
                {
                    $qry="INSERT INTO Images(name,class,sizex,sizey,date,location,image) VALUES ('$name','$class','$sizex','$sizey','$date','$location','$image')";
                    $result=mysqli_query($con,$qry);
                    if($result)
                    {
                        echo "<br/>Image uploaded.";
                    }
                    else
                    {
                        echo '<br/><font color="red">Image not uploaded! Please check that you have filled in all the necessary blanks.</font>';
                    }
                }
                else
                {
                    echo '<br/><font color="red">Can\'t upload image because it already exists.</font>';
                }
                mysqli_close($con);
            }
        ?>
        <hr>
        <div style="width:600px; display:table-cell;">
        <form method="post" enctype="multipart/form-data">
            <br/>
                <font size="5"><b>Filter Result</b><font>
                <font size="2">
                <br/><br/>
                <b>Type of the picture:</b>
                <select name="class1">
                    <option>---choose type---</option>
                    <option>Scenary</option>
                    <option>Portrait</option>
                </select>
                <br/><br/>
                <b>Date:<b>
                From <input type="text" name="idate" value="YYYY-MM-DD" size="12" />
                To <input type="text" name="edate" value="YYYY-MM-DD" size="12" />
                <br/><br/>
                <b>Location of the picture:</b>
                <select name="location1">
                    <option>---choose location---</option>
                    <?php
                    $con=mysqli_connect("db4free.net","minjielu","database1");
                    if(!$con)
                    {
                        echo "<br/>Database connection issue!";
                    }
                    mysqli_select_db($con,"minjieluproject1");
                    $qry="SELECT location FROM Scenary ORDER BY location";
                    $result=  mysqli_query($con, $qry);
                    if(!$result)
                    {
                        echo "Can't retrieve location information.";
                    }
                    while($row=  mysqli_fetch_array($result))
                    {
                        echo '<option>'.$row[0].'</option>';
                    }
                    ?>
                </select>
                <br/><br/>
                <b><font size="3">And sort by</font></b>
                <br/><br/>
                <select name="orderway">
                    <option>name:a(A)-z(Z)</option>
                    <option>name:z(Z)-a(A)</option>
                    <option>date:most recent first</option>
                    <option>date:oldest first</option>
                    <option>location:a(A)-z(Z)</option>
                    <option>location:z(Z)-a(A)</option>
                </select>
                <br/><br/>
                <input type="submit" name="sumit2" value="Filter" />
                </font>
        </form>
        </div>
        <?php
            echo '<hr>';                            //Code from here handles deleting images.
            if(isset($_POST['delete']))
            {
                $con=mysqli_connect("db4free.net","minjielu","database1");
                if(!$con)
                {
                    echo "<br/>Database connection issue!";
                }
                mysqli_select_db($con,"minjieluproject1");
                $iter=count($_POST['check']);
                $numdelfail=0;
                for($i=0;$i<$iter;$i++)
                {
                    $qry="DELETE FROM Images WHERE id=".$_POST['check'][$i];
                    $result=  mysqli_query($con, $qry);
                    if(!$result)
                    {
                    echo 'Deleting image No.'.$_POST['check'][$i].' fails!';
                    $numdelfail++;
                    }
                }
                echo '<br/>';
                if(($iter-$numdelfail)==1)
                {
                    echo '<font size="3">1 image is deleted.</font><br/>';
                }
                elseif($iter==$numdelfail)
                {
                    echo '<font size="3">No image is deleted.</font><br/>';
                }
                else
                {
                    echo '<font size="3">'.($iter-$numdelfail).' images are deleted.</font><br/>';
                }
                mysqli_close($con);   
            }
            echo "Images<br/><br/>";
            displayimage();
            function displayimage()  //Code from here handles filtering images according to given conditions.
            {
                $con=mysqli_connect("db4free.net","minjielu","database1");
                mysqli_select_db($con, "minjieluproject1");
                $qry="SELECT * FROM Images";
                if(isset($_POST['sumit2']))            //Filter is implemented by constructing a string behind the WHERE key word in MySQL SELECT query.
                {
                    $condition='';
                    if($_POST['class1']!="---choose type---")
                    {
                        $condition='class=\''.$_POST['class1'].'\'';
                    }
                    if($_POST['idate']!="YYYY-MM-DD")
                    {
                        $condition=$condition.' and Date(date)>=Date(\''.$_POST['idate'].'\')';
                    }
                    if($_POST['edate']!="YYYY-MM-DD")
                    {
                        $condition=$condition.' and Date(date)<=Date(\''.$_POST['edate'].'\')';
                    }
                    if($_POST['location1']!="---choose location---")
                    {
                        $condition=$condition.' and location=\''.$_POST['location1'].'\'';
                    }
                    if($condition[0]==' ')
                    {
                        $condition=  substr($condition, 4);
                    }
                    if($condition!='')
                    {
                        $qry=$qry.' WHERE '.$condition;
                    }
                    $orderway='';
                    switch($_POST['orderway'])
                    {
                        case 'name:a(A)-z(Z)':
                            $orderway='name';
                            break;
                        case 'name:z(Z)-a(A)':
                            $orderway='name DESC';
                            break;
                        case 'date:most recent first':
                            $orderway='date DESC';
                            break;
                        case 'date:oldest first':
                            $orderway='date';
                            break;
                        case 'location:a(A)-z(Z)':
                            $orderway='location';
                            break;
                        case 'location:z(Z)-a(A)':
                            $orderway='location DESC';
                            break;
                    }
                    if($orderway!='')
                    {
                        $qry=$qry.' ORDER BY '.$orderway;
                    }
                }
                $result=mysqli_query($con,$qry);
                $rown=0;
                $numrow=100;                            //Initially only 100 pictures are displayed for a clean display window. But user can press show all pictures to display all the images.
                if(isset($_POST['morepic']))
                {
                    $result= mysqli_query($con,$_POST['oldcon']);
                    $numrow=  mysqli_num_rows($result);
                }
                echo '<form method="POST" enctype="multipart/form-data">';
                echo '<input type="submit" name="delete" value="Delete checked images" /><br/>';
                $numofpic=mysqli_num_rows($result);
                echo $numofpic.' pictures found.';
                while(($row=mysqli_fetch_array($result)) && $rown<$numrow)
                {
                    $rown++;
                    echo '<div style="width:100px; display:table-cell;">
                              <input type="checkbox" name="check[]" value="'.$row[0].'" />
                              <br/>
                              <img height="'.($row[3]/4).'" width="'.($row[4]/4).'" src="data:image;base64,'.$row[7].'">   
                              <br/><a href="detail.php?picid='.$row[0].'"><button type="button"><font size="1">Detail for '.$row[1].'</font></button></a>
                          </div>';
                    if($rown%12==0) {              //12 pictures per row.
                        echo "<br/>";
                    }
                }
                echo '</form>';
                if(!isset($_POST['morepic']))
                {
                    echo '<br/><form method="POST"><input name="morepic" value="Show all pictures" type="submit"/><input type="hidden" name="oldcon" value="'.$qry.'"></form>';    //This is a link to the detail of an image. The image id is passed to the next page for the database to search for the image.
                }                                                  //A hidden input is added. In this way, if show all pictures is pressed after a filter operation, all the pictures according to the filter will be shown.
                mysqli_close($con);
            }
        ?>
    </body>
</html>