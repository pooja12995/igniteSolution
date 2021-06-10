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
      <input type="text" id="search" name="search" class="searchInput"  placeholder="Enter the GutenId " />
      <input type="submit" id="quicksubmit" name="submit_search" value="Search" onclick="search()"/>
   </p>
  </div>
</div>
<div class="searchbox">
  <div class="search">
   <p><label for="book-search" class="lbl-toggle">Advance Search</label>
       <input type="text" id="authorName" name="authorName" class="searchInput"  placeholder="Author Name" />
       <input type="text" id="searchTitle" name="searchTitle" class="searchInput"  placeholder="Book Title" />
       <input type="text" id="searchSubject" name="searchSubject" class="searchInput"  placeholder="Subject" />
       <input type="text" id="searchLanguage" name="searchLanguage" class="searchInput"  placeholder="Language" />
       <input type="text" id="searchFiletype" name="searchFiletype" class="searchInput"  placeholder="fileType" />
      <input type="submit" id="quicksubmit" name="submit_search" value="Search" onclick="advanceSearch()"/>
   </p>
  </div>
</div>

  <ul class="pagination">
        <?php $offset1=1;?>
          <li><a href="RetriveBook.php?pageno=1?row_per_page=<?php echo $no_of_records_per_page?>" style="margin-right:5px;">Displaying results <?php echo $offset1."-".$no_of_records_per_page;?><label id="first" hidden> First| </label></a></li>
          <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
              <a href="?<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>?row_per_page=<?php echo $no_of_records_per_page?>" class="prev" hidden> Prev| </a>
          </li>
          <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
              <a href="?<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>?row_per_page=<?php echo ($no_of_records_per_page);?>">  >> Next</a>
          </li>
          <li><a href="?pageno=<?php echo $total_pages; ?>?row_per_page=<?php echo $no_of_records_per_page?>" class="last" hidden> |Last</a></li>
     </ul>
     <tr>
      <th scope="col">Title</th>
      <th scope="col">Author name</th>
      <th scope="col">birth_year</th>
      <th scope="col">death_year</th>
      <th scope="col">language</th>
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
      $.getJSON("RetriveBook.php",function(data){
        var book_data='';
        $.each(data,function(key,value){
          book_data +='<tr>';
          book_data +='<td>'+value.id+'</td>';
          book_data +='<td>'+value.download_count+'</td>';
          book_data +='<td>'+value.gutenberg_id+'</td>';
          book_data +='<td>'+value.media_type+'</td>';
          book_data +='<td>'+value.title+'</td>';
          book_data +='</tr>';
        });
        $('#booktable').append(book_data);
      });
     });
     function search(){
      var searchtext=document.getElementById("search").value;
          $.ajax({
            url:'RetriveBook.php',
            type:'GET',
            dataType: "json",
            data:{search:searchtext},
            success:function(response){
                var data=((response));
                var book_data='';
                $.each(response,function(key,value){
                book_data +='<tr>';
                book_data +='<td>'+value.download_count+'</td>';
                book_data +='<td>'+value.gutenberg_id+'</td>';
                book_data +='<td>'+value.media_type+'</td>';
                book_data +='<td>'+value.title+'</td>';
                book_data +='</tr>';
         });
        $('#booktable').append(book_data);
            }
        });
    }
    function advanceSearch(){
      var authorName=document.getElementById("authorName").value;
      var searchTitle=document.getElementById("searchTitle").value;
      var searchSubject=document.getElementById("searchSubject").value;
      var searchLanguage=document.getElementById("searchLanguage").value;
      var searchFiletype=document.getElementById("searchFiletype").value;
        $.ajax({
          url:'RetriveBook.php',
          type:'GET',
          dataType: "json",
          data:{authorName:authorName,searchTitle:searchTitle,searchSubject:searchSubject,searchLanguage:searchLanguage,searchFiletype:searchFiletype},
          success:function(response){
              var data=JSON.parse(JSON.stringify(response));
              $('#booktable').html(data)
          }
      });
}
</script>
<!-- <script src="main.js" ></script> -->
</body>
</html>
