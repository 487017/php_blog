<?php
session_start();
require '../database.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['log_in'])) {
    header("Location:login.php");
}

if($_POST){
    $image = 'image/'.$_FILES['file']['name'];
    $imgtype = pathinfo($image,PATHINFO_EXTENSION);

    if($imgtype != 'png' && $imgtype != 'jpg' && $imgtype != 'jfif' ){
        echo "<script>alert('Image must be png,jpg,jftf')</script>";
    }else{
        $title = $_POST['title'];
        $content = $_POST['content'];
        $img = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],$image);

        $qry = "INSERT INTO post (title,content,img,author_id) VALUES (:title,:content,:img,:author_id)";
        $res = $pdo->prepare($qry);
        $row = $res->execute(
            [
                ':title'=>$title,
                ':content'=>$content,
                ':img'=>$img,
                ':author_id'=>$_SESSION['user_id']
            ]
        );
        if($row){
            echo "<script>alert('Image is Successful');window.location.href = 'index.php';</script>";
        }else{
            echo "<script>alert('You fail');window.location.href = 'login.php';</script>";
        }

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
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" require >
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" rows="8" cols="80" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="file" require>
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