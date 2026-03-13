<?php
/*
    Model za novico. Vsebuje lastnosti, ki definirajo strukturo novice in sovpadajo s stolpci v bazi.

    V modelu moramo definirati tudi relacije oz. povezane entitete/modele. V primeru novice je to $user, ki 
    povezuje novico z uporabnikom, ki je novico objavil. Relacija nam poskrbi za nalaganje podatkov o uporabniku, 
    da nimamo samo user_id, ampak tudi username, ...
*/

require_once 'users.php'; // Vključimo model za uporabnike

class Article
{
    public $id;
    public $title;
    public $abstract;
    public $text;
    public $date;
    public $user;

    // Konstruktor - Ga moram poklicati v create.php
    public function __construct($id, $title, $abstract, $text, $date, $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->abstract = $abstract;
        $this->text = $text;
        $this->date = $date;
        $this->user = User::find($user_id); //naložimo podatke o uporabniku
    }

    // Metoda, ki iz baze vrne vse novice
    public static function all()
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $query = "SELECT * FROM articles;"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $articles = array();
        while ($article = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $articles
            array_push($articles, new Article($article->id, $article->title, $article->abstract, $article->text, $article->date, $article->user_id));
        }
        return $articles;
    }

    // Metoda, ki vrne eno novico z določenim id-jem iz baze
    public static function find($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM articles WHERE id = '$id';";
        $res = $db->query($query);
        if ($article = $res->fetch_object()) {
            return new Article($article->id, $article->title, $article->abstract, $article->text, $article->date, $article->user_id);
        }
        return null;
    }

    //funkcija prejme id userja, najde vse article z user_id = id, vrne vse article.
     public static function listByUser($user_id)
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $user_id = mysqli_real_escape_string($db, $user_id);
        $query = "SELECT * FROM articles WHERE user_id = '$user_id';"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $articles = array();
        while ($article = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $articles
            array_push($articles, new Article($article->id, $article->title, $article->abstract, $article->text, $article->date, $article->user_id));
        }
        return $articles;
    }

    public static function create($title, $abstract, $text){
        $db = Db::getInstance();
        $title = mysqli_real_escape_string($db, $title);
        $abstract = mysqli_real_escape_string($db, $abstract);
        $text = mysqli_real_escape_string($db, $text);
        $user_id = $_SESSION["USER_ID"];
        $query = "INSERT INTO articles (title, abstract, text, user_id) VALUES ('$title', '$abstract', '$text', '$user_id');";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        }
    }

    // Metoda, ki preveri razpoložljivost imena
    public static function is_not_available($title){
        $db = Db::getInstance();
        $title = mysqli_real_escape_string($db, $title);
        $query = "SELECT * FROM articles WHERE title='$title'";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }

    public function update($title, $abstract, $text){
        $db = Db::getInstance();
        $title = mysqli_real_escape_string($db, $title);
        $abstract = mysqli_real_escape_string($db, $abstract);
        $text = mysqli_real_escape_string($db, $text);
        $id = $this->id;
        $query = "UPDATE articles SET title='$title', abstract='$abstract', text='$text', date=NOW() WHERE id=$id LIMIT 1;";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function delete($id){
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "DELETE FROM articles WHERE id=$id LIMIT 1;";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        }
    }
        
        
}