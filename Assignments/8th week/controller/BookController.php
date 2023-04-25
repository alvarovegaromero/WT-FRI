<?php

require_once("model/BookDB.php");
require_once("ViewHelper.php");

# Controller for handling books
class BookController {

    public static function getAll() {
        # Reads books from the database
        $variables = ["books" => BookDB::getAll()];

        # Renders the view and sets the $variables array into view's scope
        ViewHelper::render("view/book-list.php", $variables);
    }

    public static function get() {
        $variables = ["book" => BookDB::get($_GET["id"])];
        ViewHelper::render("view/book-detail.php", $variables);
    }

    public static function showAddForm($variables = array("author" => "", "title" => "", 
        "price" => "", "year" => "")) {
        ViewHelper::render("view/book-add.php", $variables);
    }

    public static function add() {
        $validData = isset($_POST["author"]) && !empty($_POST["author"]) && 
                isset($_POST["title"]) && !empty($_POST["title"]) &&
                isset($_POST["year"]) && !empty($_POST["year"]) &&
                isset($_POST["price"]) && !empty($_POST["price"]);

        if ($validData) {
            BookDB::insert($_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
            ViewHelper::redirect(BASE_URL . "book");
        } else {
            self::showAddForm($_POST);
        }
    }

    # TODO: Implement controlers for searching, editing and deleting books

    public static function search(){
        $query = "";

        if(isset($_GET["query"]))
            $query  = $_GET["query"];
    
        $results = BookDB::search($query);
        #print(count($results));
        ViewHelper::render("view/book-search.php", $results);
    }

    public static function delete($id){
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $book = BookDB::get($id);

            if ($book) {
                BookDB::delete($id);
                ViewHelper::redirect(BASE_URL . "book");
            } 
            else {
                echo "Book not found";
            }
        } 
        else {
            echo "Invalid request";
        }
    }

    public static function edit($id)
    {
        $book = BookDB::get($id);

        if (!$book) {
            ViewHelper::error404();
        } 
        else {
            $validData =    isset($_POST["author"]) && !empty($_POST["author"]) &&
                            isset($_POST["title"]) && !empty($_POST["title"]) &&
                            isset($_POST["year"]) && !empty($_POST["year"]) &&
                            isset($_POST["price"]) && !empty($_POST["price"]);

            if ($validData) {
                BookDB::update($id, $_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
                ViewHelper::redirect(BASE_URL . "book");
            } 
            else {
                # If the form data is invalid, re-render the edit form with an error message
                $variables = ["book" => $book, "errorMessage" => "Invalid form data"];
                ViewHelper::render("view/book-edit.php", $variables);
            }
        }
    }    
}