<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/contact.php';


$database = new Database();
$db = $database->getConnection();

$contact = new Contact($db);
$stmt = $contact->read();
$num = $stmt->rowCount();

if($num>0){

    $contacts_arr=array();
    $contacts_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $contact_item=array(
            "id" => $id,
            "name" => $name,
            "last_name" => $last_name,
            "email" => $email,
            "image_url" => $image_url,
            "telephone" => $telephone
        );

        array_push($contacts_arr["records"], $contact_item);
    }


    http_response_code(200);
    echo json_encode($contacts_arr);
}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no contacts found
    echo json_encode(
        array("message" => "No contacts found.")
    );
}