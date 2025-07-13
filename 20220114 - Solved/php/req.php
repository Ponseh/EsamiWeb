<?php
/*
Scrivere il codice PHP valido (ovvero che esegua correttamente su server web Apache) che consenta di:

Controllare se in POST sono stati inviati i seguenti parametri: nome, cognome, codice fiscale, data di nascita e sesso. Controllare che nome e cognome siano due stringhe, codice fiscale sia una stringa di 16 caratteri, data di nascita sia una data nel formato YYYY-MM-DD e che sesso sia un carattere tra M, F o A. In caso siano presenti tutti i parametri e che questi siano corretti, inserire i dati nella tabella e visualizzare un corrispondente messaggio di avvenuto inserimento.
Se è stato inviato un parametro id visualizzare solo l’elemento con tale id, altrimenti visualizzare tutti i dati presenti sul db. In entrambi i casi, i dati vanno visualizzati in una tabella.
Dovete supporre che il db esista (nome database: db_esami; nome tabella: cittadino; username: root, pw: ) e che la tabella " cittadino" sia strutturata secondo le istruzioni che trovate nel file "README_DB.txt".
NB: il codice deve essere valido e accessibile.
*/

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
    <title>Document</title>
    <style>
        table, th, td {
            border: 1px solid black
        }
    </style>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "", "db_esami");
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    if( !empty($_POST['nome']) &&
        !empty($_POST['cognome']) &&
        !empty($_POST['codice_fiscale']) &&
        !empty($_POST['ddn']) &&
        !empty($_POST['sesso']) &&
        is_string($_POST['nome']) &&
        is_string($_POST['cognome']) && 
        is_string($_POST['codice_fiscale']) &&
        strlen($_POST['codice_fiscale']) == 16 &&
        isValidDate($_POST['ddn']) &&
        ($_POST['sesso'] === 'M' || $_POST['sesso'] === 'F' || $_POST['sesso'] === 'A')) {
            $stmt = $conn->prepare("INSERT INTO cittadino (nome, cognome, codicefiscale, datanascita, sesso) VALUES (?, ?, ?, ?, ?)");
            $cfUppato = strtoupper($_POST['codice_fiscale']);
            $stmt->bind_param("sssss", $_POST['nome'], $_POST['cognome'], $cfUppato, $_POST['ddn'], $_POST['sesso']);

            if ($stmt->execute()) {
                echo "<p>Dati inseriti correttamente.</p>";
            } else {
                echo "<p>Errore nell'inserimento: " . $stmt->error . "</p>";
            }

            $stmt->close();

        } elseif (!empty($_POST['id'])) {
            $stmt = $conn->prepare("SELECT * FROM cittadino WHERE idcittadino=?");
            $stmt->bind_param("i", $_POST['id']);

            if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr><th>ID</th><th>Nome</th><th>Cognome</th><th>Codice Fiscale</th><th>Data di Nascita</th><th>Sesso</th></tr>";

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
                echo "<p>Nessun cittadino trovato con ID {$_POST['id']}.</p>";
            }
        } else {
            echo "<p>Errore nell'esecuzione della query: " . $stmt->error . "</p>";
        }

        $stmt->close();

        } else {
            $stmt = $conn->prepare("SELECT * FROM cittadino");

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<table style=\"border:1px solid black\">
                            <tr><th>ID</th><th>Nome</th><th>Cognome</th><th>Codice Fiscale</th><th>Data di Nascita</th><th>Sesso</th></tr>";

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
                    echo "<p>Nessun cittadino trovato con ID {$_POST['id']}.</p>";
                }
            } else {
                echo "<p>Errore nell'esecuzione della query: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }
    
    $conn->close()
    ?>
</body>
</html>