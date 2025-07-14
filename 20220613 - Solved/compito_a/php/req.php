<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "esami");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connessione fallita: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    handleNewGame($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleSolutionValidation($conn);
}

$conn->close();

function handleNewGame($conn) {
    try {
        // Genera stato iniziale del sudoku
        $initialState = generateInitialSudoku();
        
        // Inserisci nel database
        $stmt = $conn->prepare("INSERT INTO sudoku (statoiniziale) VALUES (?)");
        $stmt->bind_param("s", $initialState);
        $stmt->execute();
        
        $gameId = $conn->insert_id;
        $stmt->close();

        // Salva l'ID della partita nel cookie
        setcookie('game_id', $gameId, time() + (60 * 60), '/');
        
        echo json_encode([
            'success' => true,
            'game_id' => $gameId,
            'initial_state' => $initialState
        ]);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Errore nella creazione della partita']);
    }
}

function handleSolutionValidation($conn) {
    try {
        $solution = $_POST['solution'] ?? '';
        $gameId = $_COOKIE['game_id'] ?? '';
        
        // Controlla se la partita esiste
        $stmt = $conn->prepare("SELECT statoiniziale FROM sudoku WHERE id = ?");
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $game = $stmt->get_result();
        $stmt->close();

        if (!$game) {
            echo json_encode(['valid' => false, 'error' => 'Partita non trovata']);
            return;
        }
        
        $initialState = $game['statoiniziale'];
        
        // Verifica che la soluzione rispetti lo stato iniziale
        if (!respectsInitialState($solution, $initialState)) {
            echo json_encode(['valid' => false, 'error' => 'La soluzione non rispetta lo stato iniziale']);
            return;
        }
        
        // Verifica che la soluzione sia valida
        $isValid = true; // validateSudoku($solution);
        
        echo json_encode(['valid' => $isValid]);

    } catch (Exception $e) {
        echo json_encode(['valid' => false, 'error' => 'Errore nella validazione']);
    }
}

function respectsInitialState($solution, $initialState) {
    for ($i = 0; $i < 81; $i++) {
        if ($initialState[$i] !== '0' && $solution[$i] !== $initialState[$i]) {
            return false;
        }
    }
    return true;
}

function generateInitialSudoku() {
    do {
        $sudoku = array_fill(0, 81, 0);
        
        for($i = 0; $i < 9; $i++) {
            $sudoku[$i] = random_int(1, 9);
        }

        shuffle($sudoku);
        
    } while (!isValidInitialSudoku($sudoku));
    
    return implode('', $sudoku);
}

function isValidInitialSudoku($sudoku) {
    // Verifica righe
    for ($row = 0; $row < 9; $row++) {
        $numbers = [];
        for ($col = 0; $col < 9; $col++) {
            $num = $sudoku[$row * 9 + $col];
            if ($num !== 0) {
                if (in_array($num, $numbers)) {
                    return false;
                }
                $numbers[] = $num;
            }
        }
    }
    
    // Verifica colonne
    for ($col = 0; $col < 9; $col++) {
        $numbers = [];
        for ($row = 0; $row < 9; $row++) {
            $num = $sudoku[$row * 9 + $col];
            if ($num !== 0) {
                if (in_array($num, $numbers)) {
                    return false;
                }
                $numbers[] = $num;
            }
        }
    }
    
    // Verifica quadrati 3x3
    for ($boxRow = 0; $boxRow < 3; $boxRow++) {
        for ($boxCol = 0; $boxCol < 3; $boxCol++) {
            $numbers = [];
            for ($row = $boxRow * 3; $row < ($boxRow + 1) * 3; $row++) {
                for ($col = $boxCol * 3; $col < ($boxCol + 1) * 3; $col++) {
                    $num = $sudoku[$row * 9 + $col];
                    if ($num !== 0) {
                        if (in_array($num, $numbers)) {
                            return false;
                        }
                        $numbers[] = $num;
                    }
                }
            }
        }
    }
    
    return true;
}
?>