<?php
$conn = new mysqli("localhost", "root", "", "programmitv");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if( isset($_POST['name'], $_POST['seasons']) &&
    !empty($_POST['name']) &&
    !empty($_POST['seasons']) &&
    is_string($_POST['name']) &&
    ctype_digit($_POST['seasons']) ) {

        $stmt = $conn->prepare("INSERT INTO serie (name, seasons) VALUES (?, ?)");
        $stmt->bind_param("si", $_POST['name'], $_POST['seasons']);

        $stmt->execute();
        
        $stmt->close();
    }
        
} elseif($_SERVER['REQUEST_METHOD'] == 'GET') {
    $serie = [];

    if( isset($_GET['id']) &&
        !empty($_GET['id']) &&
        ctype_digit($_GET['id']) ) {

        $stmt = $conn->prepare("SELECT * FROM serie WHERE id=?");
        $stmt->bind_param("i", $_GET['id']);

    } else {
        $stmt = $conn->prepare("SELECT * FROM serie");
    }

    $stmt->execute();
    
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $serie[] = $row;
    }

    $stmt->close();

    if($serie == null)
        $serie = [["error" => "Nessuna serie trovata"]];
    
    header('Content-Type: application/json');
    
    echo json_encode($serie);
}

$conn->close();
?>