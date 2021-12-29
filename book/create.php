<?php
namespace book;

use models\admin\Book;

$book = new Book();

    if (isset($_POST['send'])) {
        $data = array(
            'title' => $_POST['title'],
            'author' => $_POST['author'],           
            'date_added' => $_POST['date_added'],
            'count_page' => $_POST['count_page'],
            'description' => $_POST['description']
        );

        $book->create($data);
        
        if (empty($book->error)) {
            //переадресация на вьюшку
            var_dump($book->id);die;

        }

        $error = $book->error;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Создание книги</title>
</head>
<body>
  <form class="creating-form" action="" method="POST" enctype="multipart/form-data">
    <p>
      <label>
        <input class="style-input" type="text" name="title" placeholder="Название книги" value="<?=$data['title']??false?>">
      </label>      
      <span><?=$error['title']??false?></span>
    </p>
    <p>
      <label>
        <input class="style-input" type="text" name="author" placeholder="Автор книги"  value="<?=$data['author']??false?>">
      </label>
      <span><?=$error['author']??false?></span>
    </p>
    <p>
      <label>
        <input class="style-input" type="date" name="date_added" value="<?=$data['date_added']??false?>">
      </label>
      <span><?=$error['date_added']??false?></span>
    </p>
    <p>
      <label>
        <input class="style-input" type="number" name="count_page" placeholder="Количество страниц"  value="<?=$data['count_page']??false?>">
      </label>
      <span><?=$error['count_page']??false?></span>
    </p>
    <p>
      <label>
        <textarea class="style-input" name="description" cols="30" rows="10" placeholder="Описание статьи">
          <?=$data['description']??false?>
        </textarea>
        <span><?=$error['description']??false?></span>
      </label>
    </p>
    <p>
      <label>
        <input type="file" name="image">
      </label>
      <span><?=$error['file']??false?></span>
    </p>
    <p>
      <label>
        <input class="button" type="submit" name="send" value="Send">
      </label>
    </p>
  </form>
</body>
</html>