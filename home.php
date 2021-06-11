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

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body>


<table class="table" id="booktable">
  <thead>
      
<div class="searchbox">
  <div class="search">
   <p><label for="book-search" class="lbl-toggle">Search</label>
      <input type="text" id="search" name="search" class="searchInput"  placeholder="Search By Subject " />
      <input type="submit" id="quicksubmit" name="submit_search" value="Search" onclick="search()"/>
   </p>
  </div>
</div>
<div class="row">
  <div class="search col-md-10" >
   <p><label for="book-search" class="lbl-toggle">Advance Search</label>
       <input type="text" id="authorName" name="authorName" class="searchInput"  placeholder="Author Name" />
       <input type="text" id="searchTitle" name="searchTitle" class="searchInput"  placeholder="Book Title" />
       <input type="text" id="searchSubject" name="searchSubject" class="searchInput"  placeholder="Subject" />
       <select id="searchLanguage" name="searchLanguage" class="searchInput"></select>
       <select id="searchFiletype" name="searchFiletype" class="searchInput"></select>
      <input type="submit" id="quicksubmit" name="submit_search" value="Search" onclick="advanceSearch()"/>
   </p>
  </div>

  <ul class="pagination" style="margin-left:30px">
        <?php 
        
        $sql = "SELECT id FROM books_book";
        $result = mysqli_query($conn, $sql);
        if(false === $result) {
          throw new Exception('Query failed with: ' . mysqli_error());
        } else {
          
          $rec_count = mysqli_num_rows($result);
          // free the result set as you don't need it anymore
          mysqli_free_result($result);
        }
        $rec_limit = 25; //number of records to display
        //$page=0;
        if( isset($_GET['page']) ){ //when user clicks link
            $page = $_GET['page'] + 1; //page count increment by 1
            $offset = $rec_limit * $page;
        }
        else{ //user has not yet clicked any link
            $page = 0;
            $offset = 0;
        }
        // $rec_count is taken from result set
        $left_rec = $rec_count - ($page * $rec_limit); //number of records remaining to display
        if( $page == 0 ){ //user has not yet clicked any link
          echo '<a href="?page='.$page.'"> Next 25 records </a>';
        }
        else if( $page>0 ){ //user has clicked at least once on link
    $last = $page - 2; //here -2 because, in isset block again increment by 1
    echo '<a href=?page='.$last.'> Last 25 records | </a>';
    echo '<a href=?page='.$page.'> Next 25 records </a>';
}
else if( $left_rec < $rec_limit ){ //when only records less than 10 remains
    $last = $page - 2;
    echo '<a href=?page='.$last.'> Last 25 records </a>';
}   

        ?>
         </ul> 
  </div>
     <tr>
      <th scope="col">Title</th>
      <th scope="col">Author name</th>
      <th scope="col">birth_year</th>
      <th scope="col">death_year</th>
      <th scope="col">media_type</th>
      <th scope="col">download_count</th>
      <th scope="col">Language</th>
      <th scope="col">subject</th>
      <th scope="col">bookshelf</th>
      <th scope="col">Mime-type</th>
      <th scope="col">Url</th>
    </tr>
  </thead>
  <tbody class="tbody">
 </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
     $(document).ready(function(){
      const params = new URLSearchParams(window.location.search)
      page=params.get('page')
          $.ajax({
            url:'RetriveBook.php',
            type:'GET',
            dataType: "json",
            data:{page:page},
            success:function(response){
                var data=((response));
                var book_data='';
                $.each(response,function(key,value){
                book_data +='<tr>';
                book_data +='<td>'+value.title+'</td>';
                book_data +='<td>'+value.author_name+'</td>';
                book_data +='<td>'+value.birth_year+'</td>';
                book_data +='<td>'+value.death_year+'</td>';
                book_data +='<td>'+value.media_type+'</td>';
                book_data +='<td>'+value.download_count+'</td>';
                book_data +='<td>'+value.code+'</td>';
                book_data +='<td>'+value.subject+'</td>';
                book_data +='<td>'+value.Bookshelf+'</td>';
                book_data +='<td>'+value.mime_type+'</td>';
                book_data +='<td><a href='+value.url+' target="_blank">'+value.url+'</td>';
                book_data +='</tr>';
         });
        $('#booktable').html(book_data);
            }
        });
        $.ajax({
            url:'RetriveBook.php',
            type:'GET',
            dataType: "json",
            success:function(response){
                var data=((response));
                var book_data='';
                $.each(response,function(key,value){
                book_data +='<tr>';
                book_data +='<td>'+value.title+'</td>';
                book_data +='<td>'+value.author_name+'</td>';
                book_data +='<td>'+value.birth_year+'</td>';
                book_data +='<td>'+value.death_year+'</td>';
                book_data +='<td>'+value.media_type+'</td>';
                book_data +='<td>'+value.download_count+'</td>';
                book_data +='<td>'+value.code+'</td>';
                book_data +='<td>'+value.subject+'</td>';
                book_data +='<td>'+value.Bookshelf+'</td>';
                book_data +='<td>'+value.mime_type+'</td>';
                book_data +='<td><a href='+value.url+' target="_blank">'+value.url+'</td>';
                book_data +='</tr>';
         });
        $('#booktable').html(book_data);
            }
        });
        let dropdown = $('#searchLanguage');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose Language</option>');
        dropdown.prop('selectedIndex', 0);
        const url = 'language.php';
        //Populate dropdown with list of Languages
        $.getJSON(url, function (data) {
          $.each(data, function (key, entry) {
            dropdown.append($('<option></option>').attr('value', entry.abbreviation).text(entry.code));
          })
        });
        let dropdown1 = $('#searchFiletype');
        dropdown1.empty();
        dropdown1.append('<option selected="true" disabled>Choose File Format</option>');
        dropdown1.prop('selectedIndex', 0);
        const url1 = 'fileFormat.php';
        //Populate dropdown with list of Languages
        $.getJSON(url1, function (data1) {
          $.each(data1, function (key, entry) {
              dropdown1.append($('<option></option>').attr('value', entry.abbreviation).text(entry.mime_type));
           })
        });
     });
     function search(){
      const params = new URLSearchParams(window.location.search)
      page=params.get('page')
      var searchtext=document.getElementById("search").value;
          $.ajax({
            url:'RetriveBook.php',
            type:'GET',
            dataType: "json",
            data:{search:searchtext,page:page},
            success:function(response){
                var data=((response));
                var book_data='';
                $.each(response,function(key,value){
                book_data +='<tr>';
                book_data +='<td>'+value.title+'</td>';
                book_data +='<td>'+value.author_name+'</td>';
                book_data +='<td>'+value.birth_year+'</td>';
                book_data +='<td>'+value.death_year+'</td>';
                book_data +='<td>'+value.media_type+'</td>';
                book_data +='<td>'+value.download_count+'</td>';
                book_data +='<td>'+value.code+'</td>';
                book_data +='<td>'+value.subject+'</td>';
                book_data +='<td>'+value.Bookshelf+'</td>';
                book_data +='<td>'+value.mime_type+'</td>';
                book_data +='<td><a href='+value.url+' target="_blank">'+value.url+'</td>';
                book_data +='</tr>';
         });
        $('#booktable').html(book_data);
            }
        });
    }
    function advanceSearch(){
      const params = new URLSearchParams(window.location.search)
      page=params.get('page')
      var authorName=document.getElementById("authorName").value;
      var searchTitle=document.getElementById("searchTitle").value;
      var searchSubject=document.getElementById("searchSubject").value;
      var searchLanguage=document.getElementById("searchLanguage").value;
      var searchFiletype=document.getElementById("searchFiletype").value;
        $.ajax({
          url:'RetriveBook.php',
          type:'GET',
          dataType: "json",
          data:{authorName:authorName,searchTitle:searchTitle,searchSubject:searchSubject,searchLanguage:searchLanguage,searchFiletype:searchFiletype,page:page},
          success:function(response){
                var data=((response));
                var book_data='';
                $.each(response,function(key,value){
                book_data +='<tr>';
                book_data +='<td>'+value.title+'</td>';
                book_data +='<td>'+value.author_name+'</td>';
                book_data +='<td>'+value.birth_year+'</td>';
                book_data +='<td>'+value.death_year+'</td>';
                book_data +='<td>'+value.media_type+'</td>';
                book_data +='<td>'+value.download_count+'</td>';
                book_data +='<td>'+value.code+'</td>';
                book_data +='<td>'+value.subject+'</td>';
                book_data +='<td>'+value.Bookshelf+'</td>';
                book_data +='<td>'+value.mime_type+'</td>';
                book_data +='<td><a href='+value.url+' target="_blank">'+value.url+'</td>';
                book_data +='</tr>';
         });
         $('#booktable').append(book_data);
       }
      });
}
</script>
</body>
</html>
