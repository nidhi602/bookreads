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
    <title>My Books | Bookreads</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/mybooks.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>
</body>
    <div class="page">
        <?php include_once 'header.html'; ?>
        <main>
            <div class="shelf">
                <table class="shelflink">
                    <tr>
                        <th>Select shelf</th>
                        <td><a href="mybooks.php">All Books</a></td>
                        <td><a href="mybooks.php?shelf=to_read">To-Read</a></td>
                        <td><a href="mybooks.php?shelf=currently_reading">Currently-Reading</a></td>
                        <td><a href="mybooks.php?shelf=read">Read</a></td>
                    </tr>
                </table>
            </div>

            <div class="tab">
                <table>
                    <tr>
                        <th>Book Cover</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Average Rating</th>
                        <th>Rating</th>
                        <th>Genre</th>
                        <th>Shelf</th>
                        <th>Remove</th>
                    </tr>
                    <?php 
                        $username = $_SESSION['username'];
                        if(isset($_GET['shelf']))
                            $shelf = $_GET['shelf'];
                        else
                            $shelf = NULL;

                        $sql = "SELECT b.book_id, cover, title, author, rating, genre, shelf FROM book b, user_book u WHERE u.username=? AND u.book_id = b.book_id ORDER BY title;";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql))
                        {
                            header("Location: ../signup.php?error=sqlerror");
                            exit();	
                        }
                        else
                        {
                            mysqli_stmt_bind_param($stmt, "s", $username);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                        }
                
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($book = mysqli_fetch_assoc($result))
                            {
                                if(is_null($shelf) || (!is_null($shelf) && $book['shelf'] == $shelf))
                                {
                                    $avg_rating_sql = "CALL get_avg_rating(?);";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $avg_rating_sql))
                                        echo "SQL Error!!!!!!";
                                    mysqli_stmt_bind_param($stmt, 's', $book['book_id']);
                                    mysqli_stmt_execute($stmt);
                                    $res = mysqli_stmt_get_result($stmt);
                                    $avg_rating = mysqli_fetch_assoc($res)['avg(rating)'];
                                    if(is_null($avg_rating))
                                        $avg_rating = 0;
                                    $avg_rating = number_format((float)$avg_rating, 2);                                        
                    ?>
                    <tr>
                        <td><img src="img/book_covers/<?php echo $book['cover'];?>" alt="book cover" height="150em"></td>
                        <td><?php echo $book['title'];?></td>
                        <td><?php echo $book['author'];?></td>
                        <td><?php echo $avg_rating;?></td>
                        <td><div class="rate">
                            <input type="radio" id="star5-<?php echo $book['book_id'];?>" name="rate-<?php echo $book['book_id'];?>" value="5" <?php echo ($book['rating'] == 5)?'checked':'';?> onclick="update('<?php echo $book['book_id'];?>', this.value)">
                            <label for="star5-<?php echo $book['book_id'];?>" title="5 stars"></label>
                            
                            <input type="radio" id="star4-<?php echo $book['book_id'];?>" name="rate-<?php echo $book['book_id'];?>" value="4" <?php echo ($book['rating'] == 4)?'checked':'';?> onclick="update('<?php echo $book['book_id'];?>', this.value)">
                            <label for="star4-<?php echo $book['book_id'];?>" title="4 stars"></label>
                            
                            <input type="radio" id="star3-<?php echo $book['book_id'];?>" name="rate-<?php echo $book['book_id'];?>" value="3" <?php echo ($book['rating'] == 3)?'checked':'';?> onclick="update('<?php echo $book['book_id'];?>', this.value)">
                            <label for="star3-<?php echo $book['book_id'];?>" title="3 stars"></label>
                            
                            <input type="radio" id="star2-<?php echo $book['book_id'];?>" name="rate-<?php echo $book['book_id'];?>" value="2" <?php echo ($book['rating'] == 2)?'checked':'';?> onclick="update('<?php echo $book['book_id'];?>', this.value)">
                            <label for="star2-<?php echo $book['book_id'];?>" title="2 stars"></label>
                            
                            <input type="radio" id="star1-<?php echo $book['book_id'];?>" name="rate-<?php echo $book['book_id'];?>" value="1" <?php echo ($book['rating'] == 1)?'checked':'';?> onclick="update('<?php echo $book['book_id'];?>', this.value)">
                            <label for="star1-<?php echo $book['book_id'];?>" title="1 star"></label>
                        </div></td>
                        <td><?php echo $book['genre'];?></td>
                        <td><?php echo $book['shelf'];?><br>
                            <div class="dropdown">
                                <button class="dropbtn">edit</button>
                                <div class="dropdown-content">
                                    <a href="includes/addtoshelf.php?book_id=<?php echo $book['book_id'];?>&shelf=to_read" id="shelf">Want to Read</a>
                                    <a href="includes/addtoshelf.php?book_id=<?php echo $book['book_id'];?>&shelf=currently_reading" id="shelf">Currently Reading</a>
                                    <a href="includes/addtoshelf.php?book_id=<?php echo $book['book_id'];?>&shelf=read" id="shelf">Read</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="button" name="delete" onclick="confirmRemove('<?php echo $book['book_id'];?>')">Remove</button>
                        </td>
                    </tr>
                    <?php
                                }
                            }
                            echo '</table>';
                        }
                        else
                            echo '</table><br>No matched items!';
                            mysqli_stmt_close($stmt);
	                        mysqli_close($conn);
                    ?>
            </div>
            <script>
                function update(book_id, rating)
                {
                    let url = 'includes/updaterating.php?book_id=';
                    url = url.concat(book_id,'&rating=',rating);
                    window.location.replace(url);
                }

                function confirmRemove(book_id)
                {
                    let confirmAction = confirm("Remove this book from your shelf?");
                    if (confirmAction) {
                        let url = 'includes/removebook.php?book_id=';
                        url = url.concat(book_id);
                        window.location.replace(url);
                    }
                }
            </script>
        </main>
        <?php include_once 'footer.html'; ?>
    </div>
</body>
</html>