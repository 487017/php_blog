<?php
session_start();
require '../database.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['log_in'])) {
    header("Location:login.php");
}
if($_POST){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if($_FILES['file']['name'] != null){
        $image = 'image/'.$_FILES['file']['name'];
        $imgtype = pathinfo($image,PATHINFO_EXTENSION);

        if($imgtype != 'png' && $imgtype != 'jpg' && $imgtype != 'jftf' ){
        echo "<script>alert('Image must be png,jpg,jftf')</script>";
        }else{
        $title = $_POST['title'];
        $content = $_POST['content'];
        $img = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],$image);

        $qry = "UPDATE post SET title = '$title' , content = '$content', img = '$img' where id = $id";
        $res = $pdo->prepare($qry);
        $res->execute();
        if($res){
            echo "<script>alert('Blog Update Successful');window.location.href = 'index.php'</script>";
        }
        }
   }else{
        $qry = "UPDATE post SET title = '$title' , content = '$content' where id = $id";
        $res = $pdo->prepare($qry);
        $res->execute();
        if($res){
            echo "<script>alert('Blog Update Successful');window.location.href = 'index.php'</script>";
        }
      }

    }




if($_GET['pid']){
    $id = $_GET['pid'];
    $qry = "SELECT * FROM post WHERE id = $id";
    $res = $pdo->prepare($qry);
    $res->execute();
    foreach($res as $value){
        $title = $value['title'];
        $content = $value['content'];
        $img = $value['img'];
        $id = $value['id'];
    }
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
                   <div class="card-body">
                   <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" require value="<?php echo $title;?>">
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" rows="8" cols="80" class="form-control"><?php echo $content;?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Image</label><br>
                            <img src="image/<?php echo $img?>" alt="" width="150" height="150"><br><br>
                            <input type="file" name="file" >
                        </div>
                        <div class="form-group">
                           <input type="submit" value="SUBMIT" class="btn btn-warning">
                           <a href="index.php" class="btn btn-success">BACK</a>
                        </div>
                    </form>
                   </div>
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