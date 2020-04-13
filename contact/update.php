<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/contact.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare contact object
$contact = new Contact($db);

// get id of contact to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of contact to be edited
$contact->id = $data->id;

// set contact property values
$contact->name = $data->name;
$contact->last_name = $data->last_name;
$contact->telephone = $data->telephone;
$contact->email = $data->email;
$contact->image_url = $data->image_url;
// update the contact
if ($contact->update()) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Contact was updated."));
} // if unable to update the contact, tell the user
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update contact."));
}