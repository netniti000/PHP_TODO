<?php
// Controllerは処理の流れを制御する処理
require_once('./../../model/Todo.php');
require_once('./../../validation/TodoValidation.php');

class TodoController {
    public function index(){
       // TodoモデルのfindAllメソッドを呼び出す
       $todo_list =  Todo::findAll();
       return $todo_list;
    }

    public function detail(){
        $todo_id = $_GET['todo_id'];

        $todo = Todo::findById($todo_id);
        
        return $todo;
    }

    public function new() {
        $title = $_POST['title'];
        $detail = $_POST['detail'];

        $data = array(
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        );

        $validation = new TodoValidation;
        $validation->setData($data);
        if($validation->check() === false) {
            $params = sprintf("?title=%s&detail=%s", $_POST['title'], $_POST['detail']);
            header(sprintf("Location: ./new.php%s", $params));
        }

        exit;

        $todo = new Todo;
        //setTitleというメソッドをTodoクラスに追加する。setTitleを通してTodoクラスのオブジェクトのtitleというプロパティに
        //POSTから渡ってきた$titleを入れる。
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $result = $todo->save();

        $result = false;
        if($result === false) {
            //?マークを付けることでGETパラメータにすることができる
            $params = sprintf("?title=%s&detail=%s", $title, $detail);
            header(sprintf("Location: ./new.php%s", $params));
            return;
        }

        header("Location: ./index.php");
    }
}