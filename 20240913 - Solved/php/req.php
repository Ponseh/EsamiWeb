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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Esercizio PHP</title>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "db_esami");
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    if( isset($_POST['nome']) &&
        !empty($_POST['nome']) &&
        isset($_POST['cognome']) &&
        !empty($_POST['cognome']) &&
        isset($_POST['codice_fiscale']) &&
        !empty($_POST['codice_fiscale']) &&
        isset($_POST['ddn']) &&
        !empty($_POST['ddn']) &&
        isset($_POST['sesso']) &&
        !empty($_POST['sesso']) &&
        is_string($_POST['nome']) &&
        is_string($_POST['cognome']) &&
        is_string($_POST['codice_fiscale']) &&
        strlen($_POST['codice_fiscale']) == 16 &&
        isValidDate($_POST['ddn']) &&
        ($_POST['sesso'] == "M" || $_POST['sesso'] == "F" || $_POST['sesso'] == "A")) {

            $stmt = $conn->prepare("INSERT INTO cittadino (nome, cognome, codicefiscale, datanascita, sesso) VALUES (?, ?, ?, ?, ?)");
            $upperCF = strtoupper($_POST['codice_fiscale']);
            $stmt->bind_param("sssss", $_POST['nome'], $_POST['cognome'], $upperCF, $_POST['ddn'], $_POST['sesso']);

            if ($stmt->execute()) {
                echo "<p>Dati inseriti correttamente.</p>";
            } else {
                echo "<p>Errore nell'inserimento: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {

            if(isset($_POST['ID']) && !empty($_POST['ID']) && ctype_digit($_POST['ID'])) {

                $stmt = $conn->prepare("SELECT * FROM cittadino WHERE idcittadino=?");
                $stmt->bind_param("i", $_POST['ID']);
            } else {

                $stmt = $conn->prepare("SELECT * FROM cittadino");
            }

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr><th>idcittadino</th><th>nome</th><th>cognome</th><th>codicefiscale</th><th>data di nascita</th><th>sesso</th></tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['idcittadino']}</td>
                                <td>{$row['nome']}</td>
                                <td>{$row['cognome']}</td>
                                <td>{$row['codicefiscale']}</td>
                                <td>{$row['datanascita']}</td>
                                <td>{$row['sesso']}</td>
                            </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>Nessun cittadino trovato.</p>";
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