<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:
        list: izpiše novice prijavljenega uporabnika
        create: izpiše obrazec za vstavljanje novice
        store: vstavi novico v bazo
        edit: izpiše vmesnik za urejanje novice
        update: posodobi novico v bazi
        delete: izbriše novico iz baze
*/

class articles_controller
{
    public function index()
    {
        //s pomočjo statične metode modela, dobimo seznam vseh novic
        //$ads bo na voljo v pogledu za vse oglase index.php
        $articles = Article::all();

        //pogled bo oblikoval seznam vseh oglasov v html kodo
        require_once('views/articles/index.php');
    }

    public function show()
    {
        //preverimo, če je uporabnik podal informacijo, o oglasu, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo oglas in ga prikažemo
        $article = Article::find($_GET['id']);
        require_once('views/articles/show.php');
    }

    public function create(){
        require_once('views/articles/create.php');
    }
    // predelam, da preveri, če article s tem imenom obstaja 
    function article_exists($article): bool
    {
        global $conn;
        $article = mysqli_real_escape_string($conn, $article);
        $query = "SELECT * FROM articles WHERE title='$article'";
        $res = $conn->query($query);
        return mysqli_num_rows($res) > 0;
    }

    //predelam, da doda article v sql 
    function submit_article($title, $abstract, $text): bool
    {
        global $conn;
        $title = mysqli_real_escape_string($conn, $title);
        $abstract = mysqli_real_escape_string($conn, $abstract);
        $text = mysqli_real_escape_string($conn, $text);
        //$date = date("Y-m-d H:i:s");
        $user_id = $_SESSION["USER_ID"];

        $query = "INSERT INTO articles (title, abstract, text, date, user_id) 
                VALUES ('$title', '$abstract', '$text', NOW(), '$user_id');";
        if($conn->query($query)){
        return true;
        }
        else{
        echo mysqli_error($conn);
        return false;
        }
    }
    //validacija
    function validate_article($title, $abstract, $text): string
    {
        if(empty($title) || empty($abstract) || empty($text)){
            return "Izpolnite vse podatke.";
        }
        else if(article_exists($title)){
            return "Ime novice je že zasedeno.";
        }
        else{
            return "";
        }
    }
}