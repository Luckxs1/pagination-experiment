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


    ?>
    <div class="container">
    <!-- Start Table -->
    <h1 class="my-2">Pagination</h1>
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
        <th style='width:50px;'>ID</th>
        <th style='width:150px;'>Name</th>
        <th style='width:50px;'>Age</th>
        <th style='width:150px;'>Department</th>
        </tr>
        </thead>
    <tbody>
        <?php 
        
            //SQL Query for Fetching limited Records using LIMIT Clause and OFFSET
        
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
        
        ?>
    </tbody>
    </table>

    <!-- Showing Current Page number out of total -->
    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
    </div>

    <!-- Creating Pagination Buttons -->

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
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</html>


<!-- https://www.allphptricks.com/create-simple-pagination-using-php-and-mysqli/ -->