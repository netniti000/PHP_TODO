<?php
//モデルファイルは基本的にDBから値を取得したり
require_once('./../../config/db.php');


class Todo{
    
    const STATUS_INCOMPLETE = 0;
    const STATUS_COMPLETED = 1;

    const STATUS_INCOMPLETE_TXT = "未完了";
    const STATUS_COMPLETED_TXT = "完了";

    public $title;
    public $detail;
    public $status;

    //$titleプロパティのゲッター
    public function getTitle() {
        return $this->title;
    }
    //$titleプロパティのセッター
    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDetail() {
        return $this->title;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public static function findByQuery($query){
        $pdo = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $pdo->query($query);
        
        if($stmh){
            $todo_list = $stmh->fetchall(PDO::FETCH_ASSOC);
        } else {
            $todo_list = array();
        }

        if($todo_list && count($todo_list) > 0) {
            foreach ($todo_list as $index => $todo) {
                $todo_list[$index]['display_status'] = self::getDisplayStatus($todo['status']);
            }
        }

        return $todo_list;
    }
    // Todosテーブルのクエリを全て返す
    public static function findAll() {
        $pdo = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $pdo->query('select * from todos');
        
        if($stmh){
            $todo_list = $stmh->fetchall(PDO::FETCH_ASSOC);
        } else {
            $todo_list = array();
        }

        if($todo_list && count($todo_list) > 0) {
            foreach ($todo_list as $index => $todo) {
                // $todo_listの各index番号のdisplay_statusにgetDisplayStatusから値を取得する
                // todo_listの連想配列の中身を変更するときは、indexを使用する。
                $todo_list[$index]['display_status'] = self::getDisplayStatus($todo['status']);
            }
        }

        return $todo_list;
    }

    public static function findByID($todo_id){
        $pdo = new PDO(DSN, USERNAME, PASSWORD);
        // sprintfは文字列化 todosテーブルからidカラムを取得
        $stmh = $pdo->query(sprintf('select * from todos where id = %s' , $todo_id));
        
        if($stmh){
            $todo = $stmh->fetch(PDO::FETCH_ASSOC);
        } else {
            $todo = array();
        }

        if($todo){
            // findByIdから取得したidに新しくdisplay_statusというキーを$todoに持たせて、
            //TodoクラスのgetDisplayStatusを通して$todoのステータスカラムを渡す。TodoクラスはここにあるのでselfでもOK

            $todo['display_status'] = self::getDisplayStatus($todo['status']);

        }

        return $todo;
    }

    public static function getDisplayStatus($status){
        //クラス定数を使用するときは、self::を使う

        if($status == self::STATUS_INCOMPLETE){
            return self::STATUS_INCOMPLETE_TXT;

        } else if($status == self::STATUS_COMPLETED) {
            return self::STATUS_COMPLETED_TXT;
        }

    

        return "";

    }

    public function save(){
        $query = sprintf("INSERT INTO `todos` (`title`, `detail`, `status`, 
        `created_at`, `updated_at`)
         VALUES  ('%s','%s',0, NOW(), NOW())",
            //$queryインスタンスが持つtitleにアクセス
            $this->title,
            $this->detail 
        );

        $pdo = new PDO(DSN, USERNAME, PASSWORD);
        $result = $pdo->query($query);

        return $result;

    }

}