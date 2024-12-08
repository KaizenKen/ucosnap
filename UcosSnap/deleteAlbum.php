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
	<?php include 'navbar.php'?>
  <?php $getAlbumById = getAlbumById($pdo, $_GET['album_id'])?>
  <div class="deleteAlbumForm" style="display: flex; justify-content: center;">
		<div class="deleteForm" style="border-style: solid; border-color: red; background-color: #ffcbd1; padding: 10px; width: 50%;">
			<form action="core/handleForms.php" method="POST">
				<p>
					<label for=""><h2>Are you sure you want to delete this album below?</h2></label>
					<input type="hidden" name="album_id" value="<?php echo $_GET['album_id']; ?>">
					<input type="submit" name="deleteAlbumBtn" style="margin-top: 10px;" value="Delete">
				</p>
			</form>
		</div>
	</div>

  <h1 style="text-align: center"><?php echo $getAlbumById['album_name']; ?></h2>

  <?php $getPhotosByAlbum = getPhotosByAlbum($pdo, $_GET['album_id']); ?>
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