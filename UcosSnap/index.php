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
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
	<?php include 'navbar.php'; ?>

	<div class="insertPhotoForm" style="display: flex; justify-content: center;">
		<form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
      <p>
        <label for="#">Create New Album</label>
				<input type="text" name="newAlbumName" placeholder="Album Name">
        <input type="submit" name="newAlbumBtn" value="Create Album" style="margin-top: 10px;">
      </p>
			<p>
				<label for="#">Description</label>
				<input type="text" name="photoDescription">
			</p>
			<p>
				<label for="#">Photo Upload</label>
				<input type="file" name="image">
			</p>
      <p>
        <label for="#">Select Album</label>
        <br>
        <select name="album" id="">
          <option value="none">None</option>
          <?php $getAlbums = getAlbums($pdo) ?>
          <?php foreach ($getAlbums as $row) { ?>
          <option value="<?php echo $row['album_id']?>"><?php echo $row['album_name']?></option>
          <?php } ?>
        </select>
        <input type="submit" name="insertPhotoBtn" style="margin-top: 10px;">
      </p>
		</form>
	</div>

  <?php if(count($getAlbums) > 0) {?>
  <div class="albums" style="display: flex; justify-content: center; margin-top: 25px">
    <div class="album_container" style="background-color: ghostwhite; border-style: solid; border-color: gray; width: 25%">
      <p style="text-align: center"><label for="">Albums:</label></p>

      <?php $getAlbums = getAlbums($pdo);?>
      <?php foreach ($getAlbums as $row) {?>

      <div class="album_list" style="text-align: center;">
        <a href="viewAlbum.php?album=<?php echo $row['album_id']?>">
          <h2><?php echo $row['album_name']?></h2>
        </a>
      </div>

      <?php } ?>

    </div>
  </div>
  <?php } ?>

	<?php $getAllPhotos = getAllPhotos($pdo); ?>
	<?php foreach ($getAllPhotos as $row) { ?>

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