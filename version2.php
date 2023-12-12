<html>  

<head>  

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagination Version 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>  

<body>   

<?php  
 $con = mysqli_connect('localhost', 'root', '');  
 // root is the default username 
 // ' ' is the default password
 if (! $con) {  
          die("Connection failed" . mysqli_connect_error());  
 } else {  
          // connect to the database named Pagination
          mysqli_select_db($con, 'pagination');  
 }

        // Get the Current Page Number
 if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
        }

        // SET Total Records Per Page Value

    $total_records_per_page = 5;

        //Calculate OFFSET VALUE and SET Other Variables
    
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

        //Get the total Number of Pages for Pagination

    $result_count = mysqli_query(
    $con,
    "SELECT COUNT(*) As total_records FROM `country`"
    );
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total pages minus 1

    // this code
    if(isset($_POST["submit"]))  
 {  
      if(!empty($_POST["search"]))  
      {  
           $query = str_replace(" ", "+", $_POST["search"]);  
           header("location:version2.php?search=" . $query);  
      }  
 }  
 //end code
    ?>
    <div class="container">
    <!-- Start Table -->
    <h1 class="my-2">Pagination</h1>
    <!-- This form -->
        <div>
        <form method="post">  
        <div class="input-group mb-3">
            <input type="submit" name="submit" class="btn btn-primary input-group-btn" id="inputGroup-sizing-default" value="Search"></a>
            <input type="text" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_GET["search"])) echo $_GET["search"]; ?>">
        </div>
        </form>  
        </div>
        <!-- End form -->
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
        <th style='width:50px;'>ID</th>
        <th style='width:150px;'>Country</th>
        <th style='width:50px;'>ISO</th>
        <th style='width:150px;'>Phone</th>
        </tr>
        </thead>
    <tbody>
        <?php 
        
            //SQL Query for Fetching limited Records using LIMIT Clause and OFFSET
            if(isset($_GET["search"]))  
            {  
                 $condition = '';  
                 $query = explode(" ", $_GET["search"]);  
                 foreach($query as $text)  
                 {  
                      $condition .= "nicename LIKE '%".mysqli_real_escape_string($con, $text)."%' OR ";  
                 }  
                 $condition = substr($condition, 0, -4);  
                 $sql_query = "SELECT * FROM country WHERE " . $condition;  
                 $result = mysqli_query($con, $sql_query);  
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
            }  else{
                $result = mysqli_query(
                    $con,
                    "SELECT * FROM `country` LIMIT $offset, $total_records_per_page"
                    );
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['nicename']."</td>
                    <td>".$row['iso']."</td>
                    <td>".$row['phonecode']."</td>
                    </tr>";
                        }
                mysqli_close($con);
            }
            
        
        ?>
    </tbody>
    </table>



    <!-- Creating Pagination Buttons -->

 <div class="row">
    <div class="col-auto me-auto">
    <ul class="pagination">
<?php if($page_no > 1){
echo "<li class='page-item'><a class='page-link' href='?page_no=1'>First Page</a></li>";
} ?>
    
<li class="page-item" <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a class="page-link" <?php if($page_no > 1){
echo "href='?page_no=$previous_page'";
} ?>>Previous</a>
</li>
    
<li class="page-item" <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a class="page-link" <?php if($page_no < $total_no_of_pages) {
echo "href='?page_no=$next_page'";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li class='page-item' ><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>
    </div>
    <div class="col-auto">
    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
    </div>
 </div>
    <!-- Showing Current Page number out of total -->
    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
    
    </div>
 
<a href="searching.php" class="my-2">Go Search Module</a>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</html>


<!-- https://www.allphptricks.com/create-simple-pagination-using-php-and-mysqli/ -->

<!-- Crud Class OOP -->
<!-- https://webscodex.medium.com/php-crud-add-edit-delete-view-application-using-oop-object-oriented-programming-and-mysql-d245b2a8c3b3 -->