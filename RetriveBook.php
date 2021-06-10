<?php
   $servername = "localhost";
   $username   = "root";
   $password   = "";
   $dbName     ="gutendex";
   // Create connection
   $conn = new mysqli($servername, $username, $password,$dbName);
   if($conn->connect_error){
       trigger_error('Database connection has failed'.$conn->$connect_error,E_USER_ERROR);
   }

?>
<?php
  
   $msg ="No Books found";
   $Information = "No Books found";
   
   if(isset($_GET['pageno']) && isset($_GET['row_per_page'])){

    $page=$_GET['pageno'];
    $row_per_page=$_GET['row_per_page'];
    $begin=($pageno * $row_per_page)- $row_per_page; //for start of records
    $stmt=mysqli_query($conn,"select books_author.name,books_author.birth_year,books_author.death_year from books_book,books_book_authors INNER JOIN books_author on books_book_authors.author_id=books_author.id order by books_book.download_count DESC
      LIMIT {$begin},{$row_per_page}");
    $result=mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    $Information=(json_encode($result));
   }
   else if(isset($_GET['search']))
   {
    //$search=$_GET['search'];
    $gutenberg_id=$_GET['search'];
    $stmt1=mysqli_query($conn,"SELECT * FROM `books_book` where gutenberg_id=$gutenberg_id ORDER BY books_book.id");
    $result=mysqli_fetch_all($stmt1,MYSQLI_ASSOC);
    $Information=$result;
   }
   else if(isset($_GET['authorName'])&&isset($_GET['searchTitle'])&&isset($_GET['searchSubject'])&&isset($_GET['searchLanguage'])&&isset($_GET['searchFiletype']))
   {
      $authorName=$_GET['authorName'];
      $searchTitle=$_GET['searchTitle'];
      $searchSubject=$_GET['searchSubject'];
      $searchLanguage=$_GET['searchLanguage'];
      $searchFiletype=$_GET['searchFiletype'];
      $stmt1=mysqli_query($conn,"SELECT * FROM `books_book` where gutenberg_id=$gutenberg_id ORDER BY books_book.id");
      $result=mysqli_fetch_all($stmt1,MYSQLI_ASSOC);
      $Information=($result);
   }
   else{
    $stmt1=mysqli_query($conn,"SELECT books_book.* FROM `books_book` ORDER by books_book.download_count DESC LIMIT 25");
    $result=mysqli_fetch_all($stmt1,MYSQLI_ASSOC);
    $Information = $result;
   }
   
$post_data= json_encode($Information);
 echo $post_data;
?>

  