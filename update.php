<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Creation Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body class="container" style="background-color: #d3d3d3;">
      <?php 
            include "connection.php";
            
            if($_GET["update"]){
                $id = $_GET["update"];
                $record_id = $connection->prepare("select * from scp_data where id = ?");
                if(!$record_id){
                   echo "<div class=' alert alert-danger p-3 m-2'>Error Preparing Record for Updating</div>";
                   exit;
                }
               $record_id->bind_param("i", $id);
                if($record_id->execute()){
                    echo "<div class=' alert alert-warning p-3 m-2'>Record Ready For Update</div>";
                    $temp = $record_id->get_result();
                    $row = $temp->fetch_assoc();
                }
                else{
                    echo "<div class=' alert alert-danger p-3 m-2'>Error: {$record_id->error}</div>";
                }
            }
            if(isset($_POST["update"])) {
                //Write a Prepared Statement to Insert Data
                $update = $connection->prepare("update scp_data set scp=?, object=?, class=?, image=?, summary=? where id=?");
                $update->bind_param("sssssi", $_POST["scp"], $_POST["object"], $_POST["class"], $_POST['image'], $_POST["summary"], $_POST["id"]);
                
                if($update->execute()){
                    echo "
                    <div class='alert alert-success p-3'>Record Successfully Updated</div>";
                }
                else{
                    echo "
                    <div class='alert alert-danger p-3'>Error: {$update->error}</div>";
                }
            }
      ?>
    <h1>Update Exsisting SCP Entry</h1>
    <p><a href="index.php" class="btn btn-dark">Back to Index Page</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="update.php" class="form-group">
            <input type="hidden" name="id" value="<?php echo $row['id']?>">
            <label>SCP Number:</label>
            <br>
            <input type="text" name="scp" placeholder="SCP-000..." class="form-control" value="<?php echo $row['scp']?>" required>
            <br><br>
            <label>SCP Name:</label>
            <br>
            <input type="text" name="object" placeholder="SCP-Name..." class="form-control" value="<?php echo $row['object']?>">
            <br><br>
            <label>SCP Class:</label>
            <br>
            <input type="text" name="class" placeholder="SCP-Class..." class="form-control" value="<?php echo $row['class']?>">
            <br><br>
            <label>Enter SCP Image URL:</label>
            <br>
            <input type="text" name="image" placeholder="SCP-URL: https://via.placeholder.com" class="form-control" value="<?php echo $row['image']?>">
            <br><br>
            <label>SCP Description:</label>
            <br>
            <textarea name="summary" class="form-control"><?php echo $row['summary']?></textarea>
            <br><br>
            <input type="submit" name="update" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>