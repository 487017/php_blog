<?php
session_start();
require '../database.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['log_in'])) {
  header("Location:login.php");
}

?>
<?php
include 'header.php';
?>

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
          </div>
          <!-- /.card-header -->
          <?php

          if (!empty($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
          } else {
            $pageno = 1;
          }
          $numOfrec = 1;
          $offset = ($pageno - 1) * $numOfrec;



          if (empty($_POST['search'])) {

            $qry = "SELECT * FROM post ORDER BY id DESC";
            $res = $pdo->prepare($qry);
            $res->execute();
            $rowline = $res->fetchAll();
            $total_pg = ceil(count($rowline) / $numOfrec);


            $qry = "SELECT * FROM post ORDER BY id DESC LIMIT $offset,$numOfrec";
            $res = $pdo->prepare($qry);
            $res->execute();
            $row = $res->fetchAll();
          } else {

            // $res = $_POST['search'];
            // $qry = "SELECT * FROM post WHERE title LIKE :title ORDER BY id DESC";
            // $res = $pdo->prepare($qry);
            // $res->execute(['title' => '%' . $res . '%']);
            // $rowline = $res->fetchAll();
            // $total_pg = ceil(count($rowline) / $numOfrec);

            // $qry = "SELECT * FROM post WHERE title LIKE :title ORDER BY id DESC LIMIT $offset,$numOfrec";
            // print_r($qry);
            // $res = $pdo->prepare($qry);
            // $res->execute(['title' => '%' . $res . '%']);
            // $row = $res->fetchAll();


            // Assuming you have a valid PDO instance in $pdo

            // Get the search term from the POST request
            $searchTerm = $_POST['search'];

            // Number of records per page and offset (these should be dynamically set based on the current page)Starting offset for the records

            // Initial query to count total results matching the search term
            $countQry = "SELECT COUNT(*) FROM post WHERE title LIKE :title";
            $countStmt = $pdo->prepare($countQry);
            $countStmt->execute(['title' => '%' . $searchTerm . '%']);
            $totalRecords = $countStmt->fetchColumn();

            $total_pg = ceil($totalRecords / $numOfrec);

            // Pagination query to get results for the current page
            $searchQry = "SELECT * FROM post WHERE title LIKE :title ORDER BY id DESC LIMIT :offset, :numOfrec";
            $searchStmt = $pdo->prepare($searchQry);
            $searchStmt->bindValue(':title', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $searchStmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $searchStmt->bindValue(':numOfrec', (int)$numOfrec, PDO::PARAM_INT);
            $searchStmt->execute();
            $row = $searchStmt->fetchAll(PDO::FETCH_ASSOC);
          }

          ?>
          <div class="card-body">
            <div>
              <a href="add.php" type="button" class="btn btn-success">New Post Create</a>
            </div><br>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Title</th>
                  <th>Content</th>
                  <th style="width: 40px">Actions</th>
                </tr>
              </thead>
              <tbody>

                <?php
                if ($row) {
                  $i = 1;
                  foreach ($row as $value) {
                    $id = $value['id'];
                    $content = $value['content']
                ?>
                    <tr>
                      <td><?php echo $pageno ?></td>
                      <td><?php echo $value['title'] ?></td>
                      <td>
                        <?php echo substr($content, 0, 150) ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <div class="container"><a href="edit.php?pid=<?php echo $id; ?>" type="button" class="btn btn-warning">Edit</a></div>
                          <div class="container">
                            <a href="delete.php?pid=<?php echo $id; ?>" type="button" class="btn btn-danger">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                <?php
                  }
                  $i++;
                }
                ?>
              </tbody>

            </table><br>
            <nav aria-label="Page navigation example" style="float:right">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item <?php if ($pageno <= 1) {
                                        echo 'disabled';
                                      } ?>">
                  <a class="page-link" href="<?php if ($pageno <= 1) {
                                                echo '#';
                                              } else {
                                                echo "?pageno=" . ($pageno - 1);
                                              } ?>">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#"><?php echo $pageno ?></a></li>
                <li class="page-item <?php if ($pageno >= $total_pg) {
                                        echo 'disabled';
                                      } ?>">
                  <a class="page-link" href="<?php if ($pageno >= $total_pg) {
                                                echo '#';
                                              } else {
                                                echo '?pageno=' . ($pageno + 1);
                                              } ?>">Next</a>
                </li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pg ?>">Last</a></li>
              </ul>
            </nav>
          </div>

        </div>
        <!-- /.card -->

      </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->
<?php
include "footer.php";
?>