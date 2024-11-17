<?php
session_start();
require 'config.php'; // Config contenant la connexion PDO

try {
    // Récupérer les paramètres envoyés via AJAX
    $arrival_date = $_POST['arrival_date'] ?? null;
    $departure_date = $_POST['departure_date'] ?? null;

    if ($arrival_date && $departure_date) {
        // Préparer la requête SQL
        $sql = "SELECT * FROM orders WHERE arr_date >= :arrival_date AND depart_date <= :departure_date";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':arrival_date', $arrival_date);
        $stmt->bindParam(':departure_date', $departure_date);
        $stmt->execute();

        // Récupérer les données
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les données en JSON
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
