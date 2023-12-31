<?php  
 $connect = mysqli_connect("localhost", "root", "", "pagination");  
 if(isset($_POST["submit"]))  
 {  
      if(!empty($_POST["search"]))  
      {  
           $query = str_replace(" ", "+", $_POST["search"]);  
           header("location:searching.php?search=" . $query);  
      }  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Search multiple words at a time in Mysql php</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="center">Search multiple words at a time in Mysql php</h3><br />  
                <form method="post">  
                     <label>Enter Search Text</label>  
                     <input type="text" name="search" class="form-control" value="<?php if(isset($_GET["search"])) echo $_GET["search"]; ?>" />  
                     <br />  
                     <input type="submit" name="submit" class="btn btn-info" value="Search" />  
                </form>  
                <br /><br />  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                     <?php  
                     if(isset($_GET["search"]))  
                     {  
                          $condition = '';  
                          $query = explode(" ", $_GET["search"]);  
                          foreach($query as $text)  
                          {  
                               $condition .= "nicename LIKE '%".mysqli_real_escape_string($connect, $text)."%' OR ";  
                          }  
                          $condition = substr($condition, 0, -4);  
                          $sql_query = "SELECT * FROM country WHERE " . $condition;  
                          $result = mysqli_query($connect, $sql_query);  
                          if(mysqli_num_rows($result) > 0)  
                          {  
                               while($row = mysqli_fetch_array($result))  
                               {  
                                    // echo '<tr><td>'.$row["nicename"].'</td></tr>';  
                                    echo "<tr>
                                    <td>".$row['id']."</td>
                                    <td>".$row['nicename']."</td>
                                    <td>".$row['iso']."</td>
                                    <td>".$row['phonecode']."</td>
                                    </tr>";
                               }  
                          }  
                          else  
                          {  
                               echo '<label>Data not Found</label>';  
                          }  
                     }  
                     ?>  
                     </table>  
                     <a href="version2.php" class="my-3">Database</a>
                </div>  
           </div>  
      </body>  
 </html>  

                           