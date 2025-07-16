<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if( isset($_POST['id'], $_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['year'], $_POST['pages']) &&
        !empty($_POST['id']) &&
        !empty($_POST['title']) &&
        !empty($_POST['author']) &&
        !empty($_POST['publisher']) &&
        !empty($_POST['year']) &&
        !empty($_POST['pages'] &&
        ctype_digit($_POST['year']) &&
        ctype_digit($_POST['id']) &&
        ctype_digit($_POST['pages']))
    ) {
        $conn = new mysqli("localhost", "root", "", "db_manga");
        $stmt = $conn->prepare("UPDATE manga SET title=?, author=?, publisher=?, year=?, pages=? WHERE (ID=?)");
        $stmt->bind_param("sssiii", $_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['year'], $_POST['pages'], $_POST['id']);
        
        $stmt->execute();

        $stmt = $conn->prepare("SELECT * FROM manga WHERE id=?");
        $stmt->bind_param("i", $_POST['id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        }

        $stmt->close();
        $conn->close();
        
        if($row)
            echo json_encode($row);
        else
            echo json_encode(['error' => 'Errore nell\'update']);
    }

} elseif($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = new mysqli("localhost", "root", "", "db_manga");

    if(isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM manga WHERE id=?");
        $stmt->bind_param("i", $_GET['id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        }
        
        if($row)
            echo json_encode($row);
        else
            echo json_encode(['error' => 'Errore nella select']);

    } else {
        $serie = [];
        $stmt = $conn->prepare("SELECT * FROM manga");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc())
                $serie[] = $row;
        }
        
        if($serie)
            echo json_encode($serie);
        else
            echo json_encode(['error' => 'Errore nella select']);
    }

    $stmt->close();
    $conn->close();
}

?>