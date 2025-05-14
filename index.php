<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Website</title>
    <style>
    .nav-link:hover {
      color: red !important;
      background-color: black; 
      border-radius: 15px; 
    }
  </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body style="background-color: #d3d3d3;">
      <?php include "connection.php"; ?>
      <div>
          <h1 class="bg-secondary text-center text-light m-0">SCP CRUD Website</h1>
          <ul class="nav navbar-dark bg-dark shadow-lg navbar-expand-lg  mb-4">
              <?php foreach($result as $link): ?>
              <li class="nav-item active btn border-0 btn-dark rounded-0 bg-dark">
                  <a href="index.php?link=<?php echo $link["scp"]; ?>" class="nav-link text-light "><?php echo $link["scp"]; ?></a>
                  </li>
                  
              <?php endforeach; ?>
              <li class="nav-item active btn border-0 btn-dark rounded-0 bg-dark position-absolute end-0">
                  <a href="create.php" class="nav-link text-light mx-5">Create A New SCP Entery</a>
                </li>
          </ul>
      </div>
    <div class="container">
        <?php 
        if(isset($_GET["link"])){
            $scp = $_GET["link"];
            //Prepared Statement
            $statement = $connection->prepare("select * from scp_data where scp = ?");
            if(!$statement){
                echo "<p>Error in Prepeareing SQL Statment</p>";
                exit;
            }
            $statement->bind_param("s", $scp);
            if($statement->execute()){
                $result = $statement->get_result();
                //Check if Reccord Has Been Retrived
                if($result->num_rows > 0) {
                    $array = array_map('htmlspecialchars', $result->fetch_assoc());
                    $update = "update.php?update=" . $array["id"];
                    $delete = "index.php?delete=" . $array["id"];
                    
                    if($array["class"]==="Euclid"){
                        $color = "danger";
                    }
                    elseif($array["class"]==="Safe"){
                        $color = "info";
                    }
                    else{
                        $color = "warning";
                    }
                    
                    echo "
                    <div class='shadow mb-5 bg-light rounded d-flex'>
                    <div class='flex-grow-1 m-4'>
                    <h2> SCP: {$array['scp']}</h2>
                    <h3> Object: {$array['object']}</h3>
                    <h3 class='text-dark'> Class: </h3><h4 class='text-{$color}'>{$array['class']}</h4>
                    <p><h2> Description:</h2><br>{$array['summary']}</p>
                    <p>
                        <a href='index.php' class='btn btn-secondary m-2'>Return To Home Page</a>
                        <a href='{$update}' class='btn btn-dark m-2'>Update SCP</a>
                        <a href='{$delete}' class='btn bg-black text-light m-2'>Delete SCP</a>
                        
                    </p>
                    </div>
                    <div class='col-md-6 m-5'><img class='img-fluid float-left rounded' style='min-width: 85px !important;' src='{$array['image']}' alt='{$array['scp']}'></div>
                    </div>
                    ";
                }
                else{
                    echo "<p>No Record Found For SCP: {$array['scp']}</p>";
                }
            }
            else{
                echo "<p>Error Executing the Statment</p>";
            }
        }
     
 else {
    echo "
        <p>Welcome to The New and Improved SCP Data Website</p>
        <div class='container bg-light card mb-4'>
            <img src='images/nav.png' alt='SCP Foundation Header Img' class='img-fluid'>
        </div>
    ";
    ?>
    
    <div class="container bg-light rounded-2 p-3">
    <div class="row">
        <?php foreach ($result as $link): ?>
            <div class="col-md-3 d-flex flex-column">
                <a href="index.php?link=<?= $link['scp'] ?>" class="d-flex flex-column nav-item active btn border-0 btn-dark rounded-2 bg-dark mb-3">
                    <p class="mb-0"><?= $link["scp"]; ?></p>
                    <img src="<?= $link['image'] ?>" alt="<?= htmlspecialchars($link['scp']) ?>" class="img-fluid rounded-5 mb-3 shadow" style="max-height: 150px; width: auto;">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>>

    <?php
}
        //Delete Record
        if(isset($_GET['delete'])){
            $del_id = $_GET['delete'];
            $delete = $connection->prepare("delete from scp_data where id=?");
            $delete->bind_param("i", $del_id);
            
            if($delete->execute()){
                echo "<div class='alert alert-warning '>Record Deleted...</div>";
            }
            else{
                echo "<div class='alert alert-danger '>Error Deleting Record {$delete->error}</div>";
            }
        }
        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>