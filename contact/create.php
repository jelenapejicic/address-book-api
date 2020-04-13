<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate contact object
include_once '../objects/contact.php';

$database = new Database();
$db = $database->getConnection();

$contact = new Contact($db);

// get posted data
$data = json_decode(file_get_contents("php://input"), false);
print_r($data);

//make sure data is not empty
if(!empty($data->name) &&
    !empty($data->last_name) &&
    !empty($data->telephone)
){

    // set contact property values
    $contact->name = $data->name;
    $contact->last_name = $data->last_name;
    $contact->telephone = $data->telephone;
    $contact->email = $data->email;
    $contact->image_url = $data->image_url;


    // create the contact
    if($contact->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Contact was created."));
    }

    // if unable to create the contact, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create contact."));
    }
}

 //tell the user data is incomplete
else{

    echo "kaooooo";
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create contact. Data is incompleteeee."));
}
