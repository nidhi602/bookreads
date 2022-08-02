<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("location: index.php");
        exit();
    }
    require 'includes\db_conn.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Explore | Bookreads</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/explore.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>

<body>
<div class="page">
    <?php include_once 'header.html'; ?>
    <main>
        <?php        
            $sql = "SELECT book_id, cover, title, author, genre FROM book ORDER BY title;";        
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0)
            {
                while($book = mysqli_fetch_assoc($result))
                {
                    $avg_rating_sql = "CALL get_avg_rating(?);";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $avg_rating_sql))
                        echo "SQL Error!!";
                    mysqli_stmt_bind_param($stmt, 's', $book['book_id']);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);
                    $avg_rating = mysqli_fetch_assoc($res)['avg(rating)'];
                    if(is_null($avg_rating))
                        $avg_rating = 0;
                    $avg_rating = number_format((float)$avg_rating, 2);
        ?>   
        <div class="book">
            <div class="cover_photo">
                <div class="photo-container">
                    <div class="photo-main">
                        <img src="img/book_covers/<?php echo $book['cover'];?>" alt="book cover">
                    </div>
                </div>
            </div>
            <div class="book_info">
                <div class="title">
                    <h1><?php echo $book['title'];?></h1>
                </div>
                <div class="author">
                    <h2>By : <?php echo $book['author'];?></h2>
                </div>
                <div class="description">
                    <h3>Avg. Rating : <?php echo $avg_rating;?></h3>
                    <h3>Genre : <?php echo $book['genre'];?></h3>
                </div>
                <div class="dropdown">
                    <button class="button">Want To Read</button>
                    <button class="dropbtn"><img src="img/drop.png" height="13px"></button>
                    <div class="dropdown-content">
                        <a href="includes/addtoshelf.php?book_id=<?php echo $book['book_id'];?>&shelf=to_read" id="shelf">Want to Read</a>
                        <a href="includes/addtoshelf.php?book_id=<?php echo $book['book_id'];?>&shelf=currently_reading" id="shelf">Currently Reading</a>
                        <a href="includes/addtoshelf.php?book_id=<?php echo $book['book_id'];?>&shelf=read" id="shelf">Read</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
                }
            }
            mysqli_close($conn);
        ?>
    </main>
    <?php include_once 'footer.html'; ?>
</div>
</body>
</html>