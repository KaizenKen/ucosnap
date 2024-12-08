<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php  
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles/styles.css?<?php echo time()?>">
</head>
<body>
	<?php include 'navbar.php'; ?>

  <div class="editAlbum" style="display: flex; justify-content: center;">
    <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
      <p>
        <label for="#">Album Name</label>
        <?php $getAlbumById = getAlbumById($pdo, $_GET['album'])?>
				<input type="text" name="newAlbumName" placeholder="<?php echo $getAlbumById['album_name']?>">
				<input type="hidden" name="album_id" value="<?php echo $_GET['album']; ?>">
				<a href="deleteAlbum.php?album_id=<?php echo $_GET['album']; ?>" style="float: right;">Delete</a>
        <input type="submit" name="renameAlbumBtn" value="Rename Album" style="margin-top: 10px;">
      </p>
		</form>
  </div>
  
  <?php $getPhotosByAlbum = getPhotosByAlbum($pdo, $_GET['album']); ?>
  <?php foreach($getPhotosByAlbum as $row) {?>
  <div class="images" style="display: flex; justify-content: center; margin-top: 25px;">
		<div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">

			<img src="images/<?php echo $row['photo_name']; ?>" alt="" style="width: 100%;">

			<div class="photoDescription" style="padding:25px;">
				<a href="profile.php?username=<?php echo $row['username']; ?>"><h2><?php echo $row['username']; ?></h2></a>
        <?php if(isset($row['album_id'])) { ?>
          <?php $getAlbumById = getAlbumById($pdo, $row['album_id'])?>
          <a href="viewAlbum.php?album=<?php echo $row['album_id']?>"><h3><?php echo $getAlbumById['album_name'] ?></h3></a>
        <?php } ?>
				<p><i><?php echo $row['date_added']; ?></i></p>
				<h4><?php echo $row['description']; ?></h4>

				<?php if ($_SESSION['username'] == $row['username']) { ?>
					<a href="editphoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Edit </a>
					<br>
					<br>
					<a href="deletephoto.php?photo_id=<?php echo $row['photo_id']; ?>" style="float: right;"> Delete</a>
				<?php } ?>
			</div>
		</div>
	</div>
  <?php } ?>
</body>
</html>