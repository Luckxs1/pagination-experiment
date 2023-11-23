<html>  

<head>  

<title> Pagination in PHP </title>  

</head>  

<body>   

<?php  

    $conn = mysqli_connect('localhost', 'root', '');  

    // root is the default username 

    // ' ' is the default password

    if (! $conn) {  

             die("Connection failed" . mysqli_connect_error());  

    }  

    else {  

             // connect to the database named Pagination

             mysqli_select_db($conn, 'pagination');  

    }  

    // variable to store number of rows per page

    $limit = 10;  

    // query to retrieve all rows from the table Countries

    $getQuery = "select *from country";    

    // get the result

    $result = mysqli_query($conn, $getQuery);  

    $total_rows = mysqli_num_rows($result);    

    // get the required number of pages

    $total_pages = ceil ($total_rows / $limit);    

    // update the active page number

    if (!isset ($_GET['page']) ) {  

        $page_number = 1;  

    } else {  

        $page_number = $_GET['page'];  

    }    

    // get the initial page number

    $initial_page = ($page_number-1) * $limit;   

    // get data of selected rows per page    

    $getQuery = "SELECT * FROM country LIMIT " . $initial_page . ',' . $limit;  

    $result = mysqli_query($conn, $getQuery);       

    //display the retrieved result on the webpage  

    while ($row = mysqli_fetch_array($result)) {  

        echo $row['id'] . ' 
        ' . $row['iso'] . ' -
        ' . $row['nicename'] . ' -
        ' . $row['phonecode'] . '</br>';  

    }    

    // show page number with link   
    echo '<br>';
    for($page_number = 1; $page_number<= $total_pages; $page_number++) {  

        echo '<a href = "index.php?page=' . $page_number . '">' . $page_number . ' </a>';  

    }    

?>  
<br>
<a href="version2.php">Version 2</a>
</body>  

</html> 


<!-- https://www.scaler.com/topics/php-tutorial/crud-operation-in-php/ -->