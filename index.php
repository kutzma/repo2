<?php
// Configurazione del database SQLite
$dbname = "flights.db";

// Creazione connessione al database
$conn = new SQLite3($dbname);

// Creazione della tabella se non esiste
$sql = "CREATE TABLE IF NOT EXISTS flights (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    flight_number TEXT NOT NULL,
    departure TEXT NOT NULL,
    destination TEXT NOT NULL,
    departure_time TEXT NOT NULL,
    arrival_time TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->exec($sql)) {
    die("Errore nella creazione della tabella: " . $conn->lastErrorMsg());
}

// Inserimento dati nel database
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $flight_number = $_POST['flight_number'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    $stmt = $conn->prepare("INSERT INTO flights (flight_number, departure, destination, departure_time, arrival_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $flight_number, SQLITE3_TEXT);
    $stmt->bindValue(2, $departure, SQLITE3_TEXT);
    $stmt->bindValue(3, $destination, SQLITE3_TEXT);
    $stmt->bindValue(4, $departure_time, SQLITE3_TEXT);
    $stmt->bindValue(5, $arrival_time, SQLITE3_TEXT);

    if ($stmt->execute()) {
        echo "Volo aggiunto con successo.";
    } else {
        echo "Errore nell'aggiunta del volo: " . $conn->lastErrorMsg();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Volo</title>
</head>
<body>
    <h1>Inserisci Dati del Volo</h1>
    <form method="POST" action="">
        <label for="flight_number">Numero del Volo:</label>
        <input type="text" id="flight_number" name="flight_number" required><br><br>

        <label for="departure">Partenza:</label>
        <input type="text" id="departure" name="departure" required><br><br>

        <label for="destination">Destinazione:</label>
        <input type="text" id="destination" name="destination" required><br><br>

        <label for="departure_time">Ora di Partenza:</label>
        <input type="datetime-local" id="departure_time" name="departure_time" required><br><br>

        <label for="arrival_time">Ora di Arrivo:</label>
        <input type="datetime-local" id="arrival_time" name="arrival_time" required><br><br>

        <button type="submit">Salva Volo</button>
    </form>
</body>
</html>
