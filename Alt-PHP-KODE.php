<?php

$dbServername = 'heidework.com.mysql';
$dbusername = 'heidework_com';
$dbpassword = 'Wx4z2n5h6s1';
$dbname = 'heidework_com';


$conn = mysqli_connect($dbServername, $dbusername, $dbpassword, $dbname);

if(isset($_POST['submitdoc'])) {
  $docname = filter_input(INPUT_POST, 'docs_name', FILTER_SANITIZE_STRING) or die ("Invaild name");
  $docgenre = filter_input(INPUT_POST, 'docs_genre', FILTER_SANITIZE_STRING) or die ("Invaild genre");
  $docoverview = filter_input(INPUT_POST, 'docs_overview') or die ("Invaild overview");
  $docdate = filter_input(INPUT_POST, 'docs_date') or die ("Invaild date");
  $docruntime = filter_input(INPUT_POST, 'docs_runtime') or die ("Invaild runtime");
  $docrating = filter_input(INPUT_POST, 'docs_rating') or die ("Invaild rating");
  $docimg = basename($_FILES['docs_img']['name']);

  $target = "images/".basename($_FILES['docs_img']['name']);


  $sqldoc = ("INSERT INTO dtu_docs(docs_name, docs_genre, docs_overview, docs_date, docs_runtime, docs_rating, docs_img) VALUES(?, ?, ?, ?, ?, ?, ?)");
  $stmt = $conn->prepare($sqldoc);
  $stmt->bind_param('ssssiis', $docname, $docgenre, $docoverview, $docdate, $docruntime, $docrating, $docimg);
  $stmt->execute();

  if($stmt->affected_rows > 0) {
    if(move_uploaded_file($_FILES['docs_img']['tmp_name'], $target)) {
      echo 'success';
exit();
    } else {
      echo 'failure';
exit();
    }
  }
}
?>


<div class="doc-form">
<form class="insert-form" action="http://www.heidework.com/DTU/docs/" method="post" enctype="multipart/form-data">
  <label>Documentary Name:</label><input type="text" name="docs_name" placeholder="Name"><br>
  <label>Documentary Genre:</label><input type="text" name="docs_genre" placeholder="Genre"><br>
  <label>Documentary Date:</label><input type="text" name="docs_date" placeholder="Date"><br>
  <label>Documentary Runtime:</label><input type="number" name="docs_runtime" placeholder="Runtime"><br>
  <label>Documentary Rating:</label><input type="number" min="1" max="10" name="docs_rating" placeholder="Rating"><br>
  <label>Documentary Image:</label><input type="file" name="docs_img" ><br />
<label>Documentary Bio:</label><textarea type="text" name="docs_overview" placeholder="Overview"></textarea><br />
  <input class="el-content uk-button uk-button-default btn-submit" type="submit" name="submitdoc" value="Submit">
</form>
</div>




----------------------
<?php
$dbServername = 'heidework.com.mysql';
$dbusername = 'heidework_com';
$dbpassword = 'Wx4z2n5h6s1';
$dbname = 'heidework_com';
$conn = mysqli_connect($dbServername, $dbusername, $dbpassword, $dbname);

if(isset($_POST['deletedoc'])) {
$id = $_POST['id'];
$sqldelete = ("DELETE FROM dtu_docs WHERE id='$id'");
$deletestmt = $conn->prepare($sqldelete);
$deletestmt->execute();
}
?>

<div class="docs-wrapper">
  <div class="container">
<?php
$sql = ("SELECT * FROM dtu_docs");
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $docs_name, $docs_genre, $docs_overview, $docs_date, $docs_runtime, $docs_rating, $docs_img);
while($stmt->fetch()) { ?>
     <div class="docs-style">
    <div class="doc-img">
      <img src="images/<?= $docs_img ?>" alt="">
    </div>
   <div class="doc-info-wrap">
    <div class="doctitle">
      <h2><?= $docs_name ?></h2>
<p>Genre: <?= $docs_genre ?></p>
    </div>
    <div class="docinfo">

      <table>
     <tr>
       <td>Date: </td>
       <td><?= $docs_date ?></td>

     </tr>
     <tr>
       <td>Runtime:</td>
       <td><?= $docs_runtime ?> min</td>

      </tr>
        <tr>
       <td>Rating: </td>
       <td><?= $docs_rating ?> Stars</td>
      </tr>
   </table>
<span class="meta">From 0 - 10</span>
    </div>
  </div>
    <div class="doc-overview">
    <p><?= $docs_overview ?></p>
    </div>
   <div class="editndel">
    <a href="http://www.heidework.com/DTU/editdocumentary?id=<?= $id ?>">Edit Documentary</a><br>
    <form action="http://www.heidework.com/DTU/docs/" method="post">
  <input type="hidden" name="id" value="<?= $id ?>">
  <input type="submit" name="deletedoc" value="Delete Documentary">
</form>
</div>
  </div>
<?php } ?>
  </div>
</div>


------------
<?php
$dbServername = 'heidework.com.mysql';
$dbusername = 'heidework_com';
$dbpassword = 'Wx4z2n5h6s1';
$dbname = 'heidework_com';

$conn = mysqli_connect($dbServername, $dbusername, $dbpassword, $dbname);
$id = isset($_GET['id']) ? $_GET['id'] : '';
if(isset($_POST['editdoc'])) {
  $id = isset($_GET['id']) ? $_GET['id'] : '';

  $docid = filter_input(INPUT_POST, 'id');
  $docname = filter_input(INPUT_POST, 'docs_name', FILTER_SANITIZE_STRING) or die ("Invaild name");
  $docgenre = filter_input(INPUT_POST, 'docs_genre', FILTER_SANITIZE_STRING) or die ("Invaild genre");
  $docoverview = filter_input(INPUT_POST, 'docs_overview') or die ("Invaild overview");
  $docdate = filter_input(INPUT_POST, 'docs_date') or die ("Invaild date");
  $docruntime = filter_input(INPUT_POST, 'docs_runtime') or die ("Invaild runtime");
  $docrating = filter_input(INPUT_POST, 'docs_rating') or die ("Invaild rating");
  $docimg = basename($_FILES['docs_img']['name']);

  $target = "images/".basename($_FILES['docs_img']['name']);

  $sqlupdate = ("UPDATE dtu_docs SET docs_name=?, docs_genre=?, docs_overview=?, docs_date=?, docs_runtime=?, docs_rating=?, docs_img=? WHERE id='$docid'");
  $updatestmt = $conn->prepare($sqlupdate);
  $updatestmt->bind_param('ssssiis', $docname, $docgenre, $docoverview, $docdate, $docruntime, $docrating, $docimg);
 $updatestmt->execute();
move_uploaded_file($_FILES['docs_img']['tmp_name'], $target);

} ?>
 <?php
 $sql = ("SELECT * FROM dtu_docs WHERE id='$id'");
 $stmt = $conn->prepare($sql);
 $stmt->execute();
 $stmt->bind_result($id, $docs_name, $docs_genre, $docs_overview, $docs_date, $docs_runtime, $docs_rating, $docs_img);
 while($stmt->fetch()) {
?>
 <form class="insert-form" action="http://www.heidework.com/DTU/editdocumentary/" method="post" enctype="multipart/form-data">
   <input type="hidden" name="id" value=<?= $id ?>>
   <label>Documentary Name</label><input type="text" name="docs_name" value="<?= $docs_name ?>"><br>
   <label>Documentary Genre</label><input type="text" name="docs_genre" value="<?= $docs_genre ?>"><br><br>
   <label>Documentary Date</label><input type="text" name="docs_date" value="<?= $docs_date ?>"><br>
   <label>Documentary Runtime</label><input type="number" name="docs_runtime" value="<?= $docs_runtime ?>"><br>
   <label>Documentary Rating</label><input type="number" min="0" max="10" name="docs_rating" value="<?= $docs_rating ?>"><br>
   <label>Documentary Image</label><input type="file" name="docs_img" ><br>
<label>Documentary Overview</label><br><textarea type="text" rows="4" cols="50" name="docs_overview"><?= $docs_overview ?></textarea><br><br>
   <input class="el-content uk-button uk-button-default" type="submit" name="editdoc" value="Edit Documentary">
 </form>

<?php } ?>



----
<?php
$dbServername = 'heidework.com.mysql';
$dbusername = 'heidework_com';
$dbpassword = 'Wx4z2n5h6s1';
$dbname = 'heidework_com';
$conn = mysqli_connect($dbServername, $dbusername, $dbpassword, $dbname); ?>
<div class="docs-wrapper">
  <div class="container">
<?php
$sql = ("SELECT * FROM dtu_docs");
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $docs_name, $docs_genre, $docs_overview, $docs_date, $docs_runtime, $docs_rating, $docs_img);
while($stmt->fetch()) { ?>
     <div class="docs-style">
    <div class="doc-img">
      <img src="images/<?= $docs_img ?>" alt="">
    </div>
   <div class="doc-info-wrap">
    <div class="doctitle">
      <h2><?= $docs_name ?></h2>
<p>Genre: <?= $docs_genre ?></p>
    </div>
    <div class="docinfo">

      <table>
     <tr>
       <td>Date: </td>
       <td><?= $docs_date ?></td>

     </tr>
     <tr>
       <td>Runtime:</td>
       <td><?= $docs_runtime ?> min</td>

      </tr>
        <tr>
       <td>Rating: </td>
       <td><?= $docs_rating ?> Stars</td>
      </tr>
   </table>
<span class="meta">From 0 - 10</span>
    </div>
  </div>
    <div class="doc-overview">
    <p><?= $docs_overview ?></p>
    </div>
  </div>
<?php } ?>
  </div>
</div>
