<?php
// Setează header pentru JSON
header("Content-Type: application/json");

// Verifică dacă este o cerere POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume = htmlspecialchars($_POST["nume"] ?? '');
    $email = htmlspecialchars($_POST["email"] ?? '');
    $mesaj = htmlspecialchars($_POST["mesaj"] ?? '');
    $data = date('Y-m-d H:i:s');

    // Validare simplă
    if (empty($nume) || empty($email) || empty($mesaj)) {
        echo json_encode(["status" => "error", "message" => "Toate câmpurile sunt obligatorii!"]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Adresă de email invalidă!"]);
        exit;
    }

    // Structura datelor pentru JSON
    $newEntry = [
        "nume" => $nume,
        "email" => $email,
        "mesaj" => $mesaj,
        "data" => $data
    ];

    $file = "messages.json"; // Fișierul unde salvăm mesajele

    // Citim datele existente
    if (file_exists($file)) {
        $currentData = json_decode(file_get_contents($file), true);
        if (!is_array($currentData)) {
            $currentData = [];
        }
    } else {
        $currentData = [];
    }

    // Adăugăm noua intrare
    $currentData[] = $newEntry;

    // Salvăm în fișier
    if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
        echo json_encode(["status" => "success", "message" => "Mesaj trimis cu succes!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Eroare la salvarea mesajului."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Cerere invalidă!"]);
}
?>
