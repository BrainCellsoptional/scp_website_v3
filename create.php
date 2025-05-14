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
            if(isset($_POST["submit"])) {
                //Write a Prepared Statement to Insert Data
                $insert = $connection->prepare("insert into scp_data(scp, object, class, image, summary) values(?,?,?,?,?)");
                $insert->bind_param("sssss", $_POST['scp'], $_POST['object'], $_POST['class'],$_POST['image'], $_POST['summary']);
                
                if($insert->execute()){
                    echo "
                    <div class='alert alert-success p-3'>Record Successfully Created</div>";
                }
                else{
                    echo "
                    <div class='alert alert-danger p-3'>Error: {$insert->error}</div>";
                }
            }
      ?>
    <h1>Create a New SCP Entry</h1>
    <p><a href="index.php" class="btn btn-dark">Back to Index Page</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="create.php" class="form-group">
            <label>Enter SCP Number:</label>
            <br>
            <input type="text" name="scp" placeholder="SCP-000..." class="form-control" required>
            <br><br>
            <label>Enter SCP Name:</label>
            <br>
            <input type="text" name="object" placeholder="SCP-Name..." class="form-control">
            <br><br>
            <label>Enter SCP Class:</label>
            <br>
            <input type="text" name="class" placeholder="SCP-Class..." class="form-control">
            <br><br>
            <label>Enter SCP Image URL:</label>
            <br>
            <input type="text" name="image" placeholder="SCP-URL: https://via.placeholder.com" class="form-control">
            <br><br>
            <label>Enter SCP Description:</label>
            <br>
            <textarea name="summary" class="form-control" placeholder="Enter SCP Description:"></textarea>
            <br><br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>