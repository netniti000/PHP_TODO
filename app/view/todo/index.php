<?php
//Viewは画面表示

require_once('./../../controller/TodoController.php');


// $todo_list = Todo::findAll();

$controller = new TodoController;
$todo_list = $controller->index();


// $todo_list = array();
// var_dump($stmh);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODOLIST</title>
</head>
<body>
    <div><a href="./new.php">新規作成</a></div>
    <?php if($todo_list): ?>
    <ul>
        <?php foreach($todo_list as $todo):?>
            <!-todoの配列からidを取得してパラメータ(値)としてtodo_idに入れる。クエスチョンマークでパラメータを付与できる ->
            <li><a href="./detail.php?todo_id=<?php echo $todo['id'] ?>"><?php echo $todo['title'];?></a> : <?php echo $todo['display_status'];?></li>
        <?php endforeach;?>
    </ul>
    <?php else: ?>
         <p>データなし</p>
    <?php endif; ?>
    
</body>
</html>