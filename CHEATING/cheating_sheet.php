<?php
// PHP CHEAT SHEET

// Controlla come è stata fatta la richiesta
$_SERVER['REQUEST_METHOD'] === 'POST';
$_SERVER['REQUEST_METHOD'] === 'GET';

/**********************************************************/

// Controlla se la data è valida (YYYY-MM-GG)
function isValidDate($dateString) {
    if (!preg_match('/^(\d{1,4})-(\d{1,2})-(\d{1,2})$/', $dateString, $matches)) {
        return false;
    }
    
    $year = (int)$matches[1];
    $month = (int)$matches[2];
    $day = (int)$matches[3];
    
    return checkdate($month, $day, $year);
}

/**********************************************************/

// Apri connessione db
$conn = new mysqli("localhost", "root", "", "libro");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

/**********************************************************/

// Inserimento
$stmt = $conn->prepare("INSERT INTO libro (titolo, autore, isbn, data_pubblicazione, genere) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $_POST['titolo'], $_POST['autore'],  $_POST['isbn'], $_POST['data_pubblicazione'], $_POST['genere']);

if ($stmt->execute()) {
    echo "<p>Dati inseriti correttamente.</p>";
} else {
    echo "<p>Errore nell'inserimento: " . $stmt->error . "</p>";
}

$lastInsert = $conn->insert_id; // Utile ogni tanto, restituisce l'ID dell'ultimo elemento inserito

$stmt->close();
$conn->close();

/**********************************************************/

// Selezione con ciclo valori e creazione tabella
$stmt = $conn->prepare("SELECT * FROM libro WHERE id=?");
$stmt->bind_param("i", $_POST['ID']);

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
        echo "<p>Nessun cittadino trovato con ID {$_POST['ID']}.</p>";
    }
} else {
    echo "<p>Errore nell'esecuzione della query: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();

/******************************************************** */

// Ciclo su tutte le entry del select + json

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

/**********************************************************/

// Controlla il cf con regex 
function validaCodiceFiscale(string $cf) {
    return preg_match(
        '/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/',
        strtoupper($cf)
    ) === 1;
}

/**********************************************************/

/*
i - integer
d - double
s - string
b - BLOB
*/

ctype_digit()
isset()
empty()
is_string()
strlen()
strtoupper()
json_encode()  // ci metti dentro un array e restituisce un json fatto

header('Content-Type: application/json');
?>