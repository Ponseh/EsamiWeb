<?php
function isValidDate($dateString) {
    if (!preg_match('/^(\d{1,4})-(\d{1,2})-(\d{1,2})$/', $dateString, $matches)) {
        return false;
    }
    
    $year = (int)$matches[1];
    $month = (int)$matches[2];
    $day = (int)$matches[3];
    
    return checkdate($month, $day, $year);
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RequestPHP</title>
</head>

<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "libro");
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    if( isset($_POST['titolo']) &&
        !empty($_POST['titolo']) &&
        isset($_POST['autore']) &&
        !empty($_POST['autore']) &&
        isset($_POST['isbn']) &&
        !empty($_POST['isbn']) &&
        isset($_POST['data_pubblicazione']) &&
        !empty($_POST['data_pubblicazione']) &&
        isset($_POST['genere']) &&
        !empty($_POST['genere']) &&
        is_string($_POST['titolo']) &&
        is_string($_POST['autore']) &&
        is_string($_POST['isbn']) &&
        ctype_digit($_POST['isbn']) &&
        strlen($_POST['isbn']) == 13 &&
        isValidDate($_POST['data_pubblicazione']) &&
        ($_POST['genere'] === "Romanzo" || $_POST['genere'] === "Saggio" || $_POST['genere'] === "Manuale" || $_POST['genere'] === "Altro")
    ) {
        $stmt = $conn->prepare("INSERT INTO libro (titolo, autore, isbn, data_pubblicazione, genere) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $_POST['titolo'], $_POST['autore'],  $_POST['isbn'], $_POST['data_pubblicazione'], $_POST['genere']);

        if ($stmt->execute()) {
            echo "<p>Dati inseriti correttamente.</p>";
        } else {
            echo "<p>Errore nell'inserimento: " . $stmt->error . "</p>";
        }

        $stmt->close();

    } elseif (isset($_GET['ID']) && !empty($_GET['ID'])) {
        $stmt = $conn->prepare("SELECT * FROM libro WHERE id=?");
        $stmt->bind_param("i", $_GET['ID']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr><th>ID</th><th>Titolo</th><th>Autore</th><th>ISBN</th><th>Data di Pubblicazione</th><th>Genere</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['titolo']}</td>
                            <td>{$row['autore']}</td>
                            <td>{$row['isbn']}</td>
                            <td>{$row['data_pubblicazione']}</td>
                            <td>{$row['genere']}</td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Nessun libro trovato con ID {$_GET['id']}.</p>";
            }
        } else {
            echo "<p>Errore nell'esecuzione della query: " . $stmt->error . "</p>";
        }

        $stmt->close();

    } else {
        $stmt = $conn->prepare("SELECT * FROM libro");

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr><th>ID</th><th>Titolo</th><th>Autore</th><th>ISBN</th><th>Data di Pubblicazione</th><th>Genere</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['titolo']}</td>
                            <td>{$row['autore']}</td>
                            <td>{$row['isbn']}</td>
                            <td>{$row['data_pubblicazione']}</td>
                            <td>{$row['genere']}</td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Nessun libro trovato.</p>";
            }
        } else {
            echo "<p>Errore nell'esecuzione della query: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>
</body>
</html>