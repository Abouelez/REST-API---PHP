<?php
include_once '../../models/Post.php';
class Category
{

    //DB stuff
    private $conn;
    public static $table = 'categories';

    //Category properties

    public $id;
    public $name;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get all categories
    public function read()
    {
        $query = 'SELECT * FROM ' . self::$table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read single 
    public function readSingle()
    {
        $query = 'SELECT * FROM ' . self::$table . ' WHERE id=?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $data['name'];
    }

    //Get category posts
    public function getPosts()
    {
        $query = 'SELECT * FROM ' . Post::$table . ' WHERE category_id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt;
    }

    //Create category
    public function create()
    {
        $query = 'INSERT INTO ' . self::$table . ' SET name = ?';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->execute([$this->name]);

        if ($stmt) return true;
        else return false;
    }

    //Update category
    public function update()
    {
        $query = 'UPDATE ' . self::$table . ' SET name = :name  WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) return true;
        else return false;
    }

    //Delete Category
    public function delete()
    {
        $query = 'DELETE FROM ' . self::$table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));


        $stmt->execute([$this->id]);

        if ($stmt) return true;
        else return false;
    }
}
