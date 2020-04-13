<?php

class Contact
{
    private $conn;
    private $table_name = "contact";

    public $id;
    public $name;
    public $last_name;
    public $email;
    public $telephone;
    public $image_url;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read contacts
    function read(){

        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // create contact
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, last_name=:last_name, email=:email, telephone=:telephone, image_url=:image_url";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->telephone=htmlspecialchars(strip_tags($this->telephone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->image_url=htmlspecialchars(strip_tags($this->image_url));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":image_url", $this->image_url);

        //print_r($stmt);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return true;

    }


    //delete contact

    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    // update the contact
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                last_name = :last_name,
                email = :email,
                telephone = :telephone,
                image_url = :image_url
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->telephone=htmlspecialchars(strip_tags($this->telephone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->image_url=htmlspecialchars(strip_tags($this->image_url));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

}
