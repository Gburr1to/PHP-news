<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:
        list: izpiše novice prijavljenega uporabnika //
        create: izpiše obrazec za vstavljanje novice //
        store: vstavi novico v bazo //
        edit: izpiše vmesnik za urejanje novice - index, kjer imaš samo svoje novice //
        update: posodobi novico v bazi //
        delete: izbriše novico iz baze //
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
        //preverimo, če je uporabnik podal informicijo, o oglasu, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo oglas in ga prikažemo
        $article = Article::find($_GET['id']);
        require_once('views/articles/show.php');
    }

    public function list()
    {
        // Preverimo, če je uporabnik prijavljen
        if(isset($_SESSION["USER_ID"])){
            // Iz seje dobimo ID prijavljenega uporabnika
            $user_id = $_SESSION["USER_ID"];
            // S pomočjo statične metode modela dobimo seznam novic za tega uporabnika
            $articles = Article::listByUser($user_id);
            // Prikažemo seznam novic
            require_once('views/articles/indexMine.php');
        } else {
            // Če ni prijavljen, ga preusmerimo na prijavo
            header("Location: /auth/login");
        }
    }

    function create(){
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Ime novice je že zasedeno."; break;
                default: $error = "Prišlo je do napake med objavo novice.";
            }
        }
        require_once('views/articles/create.php');
    }

    function store(){
        if(empty($_POST["article-title"]) || empty($_POST["article-story"]) || empty($_POST["article-abstract"])){
            header("Location: /articles/create?error=1");
        }
        else if(Article::is_not_available($_POST["article-title"])){
            header("Location: /articles/create?error=2");
        }
        else if(Article::create($_POST["article-title"], $_POST["article-abstract"], $_POST["article-story"])){
            header("Location: /articles/list");
        }
        else{
            header("Location: /articles/create?error=3");
        }
        die();
    }

    function edit(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        if(!isset($_GET["id"])){
            header("Location: /articles/list");
            die();
        }
        $article = Article::find($_GET["id"]);
        // Preverimo, če je uporabnik lastnik novice
        if($article->user->id != $_SESSION["USER_ID"]){
            header("Location: /pages/error");
            die();
        }

        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Ime novice je že zasedeno."; break;
                default: $error = "Prišlo je do napake med urejanjem novice.";
            }
        }
        require_once('views/articles/edit.php');
    }

    function update(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }

        if(empty($_POST["id"]) || empty($_POST["article-title"]) || empty($_POST["article-story"]) || empty($_POST["article-abstract"])){
            header("Location: /articles/edit?id=" . $_POST["id"] . "&error=1");
        }
        else{
            $article = Article::find($_POST["id"]);
            // Preverimo, če je uporabnik lastnik novice
            if($article->user->id != $_SESSION["USER_ID"]){
                header("Location: /pages/error");
                die();
            }

            if($article->update($_POST["article-title"], $_POST["article-abstract"], $_POST["article-story"])){
                header("Location: /articles/list");
            }
            else{
                header("Location: /articles/edit?id=" . $_POST["id"] . "&error=3");
            }
        }
        die();
    }

    function delete(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        if(!isset($_GET["id"])){
            header("Location: /articles/list");
            die();
        }

        $article = Article::find($_GET["id"]);
        // Preverimo, če je uporabnik lastnik novice
        if($article->user->id != $_SESSION["USER_ID"]){
            header("Location: /pages/error");
            die();
        }

        if(Article::delete($_GET["id"])){
            header("Location: /articles/list");
        } else {
            header("Location: /pages/error");
        }
        die();
    }

}