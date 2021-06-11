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
   $Information = "No Books found";
   if(isset($_GET['search']))
   {
      $row_per_page=25;
      $startIndex=0;
     if(!isset($_GET['page']) || isset($_GET['page'])==0 || isset($_GET['page'])==""){
        $startIndex=1;
      }else{
        $startIndex=(int)($_GET['page']);
        $begin=(($startIndex)*25)+1;
      } 
    $search=$_GET['search'];
    $stmt1=mysqli_query($conn,"select books_book.title,books_book.download_count,books_book.media_type,books_author.name as author_name,books_author.birth_year,books_author.death_year,books_language.code,books_subject.name as subject,books_bookshelf.name as Bookshelf,books_format.url,books_format.mime_type from  books_book,books_author,books_book_authors,books_language,books_book_languages,books_subject,books_book_subjects,books_bookshelf,books_book_bookshelves,books_format where books_author.id=books_book_authors.author_id and books_book.id=books_book_authors.book_id and books_language.id=books_book_languages.language_id and books_book.id=books_book_languages.book_id and books_subject.id=books_book_subjects.subject_id and books_book_subjects.book_id=books_book.id and books_bookshelf.id=books_book_bookshelves.bookshelf_id and books_book.id=books_book_bookshelves.book_id and books_format.book_id=books_book.id and books_subject.name LIKE '%$search%' or books_bookshelf.name LIKE '%$search%'  GROUP BY books_book.id ORDER BY books_book.download_count DESC LIMIT {$startIndex},{$row_per_page}");
    $result=mysqli_fetch_all($stmt1,MYSQLI_ASSOC);
    if($result==null){
       $Information="No Book Found";
    }else{
       $Information=$result;
    }
   }
   else if(isset($_GET['authorName'])&&isset($_GET['searchTitle'])&&isset($_GET['searchSubject'])&&isset($_GET['searchLanguage'])&&isset($_GET['searchFiletype']))
   {
      $row_per_page=25;
      $startIndex=0;
     if(!isset($_GET['page']) || isset($_GET['page'])==0 || isset($_GET['page'])==""){
        $startIndex=1;
      }else{
        $startIndex=(int)($_GET['page']);
        $begin=(($startIndex)*25)+1;
      } 
      $authorName=$_GET['authorName'];
      $searchTitle=$_GET['searchTitle'];
      $searchSubject=$_GET['searchSubject'];
      $searchLanguage=$_GET['searchLanguage'];
      $searchFiletype=$_GET['searchFiletype'];
      $stmt1=mysqli_query($conn,"select books_book.title,books_book.download_count,books_book.media_type,books_author.name as author_name,books_author.birth_year,books_author.death_year,books_language.code,books_subject.name as subject,books_bookshelf.name as Bookshelf,books_format.url,books_format.mime_type from  books_book,books_author,books_book_authors,books_language,books_book_languages,books_subject,books_book_subjects,books_bookshelf,books_book_bookshelves,books_format where books_author.id=books_book_authors.author_id and books_book.id=books_book_authors.book_id and books_language.id=books_book_languages.language_id and books_book.id=books_book_languages.book_id and books_subject.id=books_book_subjects.subject_id and books_book_subjects.book_id=books_book.id and books_bookshelf.id=books_book_bookshelves.bookshelf_id and books_book.id=books_book_bookshelves.book_id and books_format.book_id=books_book.id and books_book.title LIKE '%$searchTitle%' OR books_subject.name LIKE '%$searchSubject%' OR books_language.code LIKE '%$searchLanguage%' OR books_format.mime_type LIKE '%$searchFiletype%' GROUP BY books_book.id ORDER BY books_book.download_count DESC
      LIMIT {$startIndex},{$row_per_page}");
      $result=mysqli_fetch_all($stmt1,MYSQLI_ASSOC);
      $Information=$result;
   }
   else{
      $row_per_page=25;
      $startIndex=0;
     if(!isset($_GET['page']) || isset($_GET['page'])==0 || isset($_GET['page'])==""){
        $startIndex=1;
      }else{
        $startIndex=int($_GET['page']);
        $begin=(($startIndex)*25)+1;
      } 
        $stmt=mysqli_query($conn,"select books_book.title,books_book.download_count,books_book.media_type,books_author.name as author_name,books_author.birth_year,books_author.death_year,books_language.code,books_subject.name as subject,books_bookshelf.name as Bookshelf,books_format.url,books_format.mime_type from  books_book,books_author,books_book_authors,books_language,books_book_languages,books_subject,books_book_subjects,books_bookshelf,books_book_bookshelves,books_format where books_author.id=books_book_authors.author_id and books_book.id=books_book_authors.book_id and books_language.id=books_book_languages.language_id and books_book.id=books_book_languages.book_id and books_subject.id=books_book_subjects.subject_id and books_book_subjects.book_id=books_book.id and books_bookshelf.id=books_book_bookshelves.bookshelf_id and books_book.id=books_book_bookshelves.book_id and books_format.book_id=books_book.id GROUP BY books_book.id ORDER BY books_book.download_count DESC
      LIMIT {$startIndex},{$row_per_page}");
    $result=mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    $Information=$result;
   }  
$post_data= json_encode($Information);
 echo $post_data;
?>

  