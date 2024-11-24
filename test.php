<?php
session_start();
require 'config.php'; // Assuming config.php contains the PDO setup

// Check if the 'export' parameter is set to 'excel' in the URL
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    // Export to Excel logic
    $sql = "SELECT * FROM `order`";
    $stmt = $pdo->query($sql);

    // Set headers to force the browser to download the file as an Excel file
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=orders.xls");

    // Output column headers for Excel
    echo "Order Number\tFirst Name\tLast Name\tEmail\tPhone\tArrival Date\tDeparture Date\tMessage Note\tProduct Category\tProduct ID\tProduct Name\tPrice\tCirc Number of Persons\tActivity Type\tRequest Date Time\tLanguage\tSpecific Request\tPayment Mode\tPaid Amount\tStatus\tSource\n";

    // Output the data rows
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row["order_number"] . "\t" . 
             $row["fname"] . "\t" . 
             $row["lname"] . "\t" . 
             $row["email"] . "\t" . 
             $row["phone"] . "\t" . 
             $row["arr_date"] . "\t" . 
             $row["depart_date"] . "\t" . 
             $row["message_note"] . "\t" . 
             $row["product_cat"] . "\t" . 
             $row["product_id"] . "\t" . 
             $row["product_name"] . "\t" . 
             $row["price"] . "\t" . 
             $row["circ_number_of_persons"] . "\t" . 
             $row["act_type"] . "\t" . 
             $row["request_date_time"] . "\t" . 
             $row["language"] . "\t" . 
             $row["specific_rq"] . "\t" . 
             $row["modepaiement"] . "\t" . 
             $row["paidamount"] . "\t" . 
             $row["status"] . "\t" . 
             $row["source"] . "\n";
    }
    exit; // Stop further execution after export
}

// Regular page logic for displaying orders with search functionality
$sql = "SELECT * FROM `order` WHERE 1=1"; // Start with a basic query

// Check if filters are set and modify the query
if (!empty($_GET['arrival_date'])) {
    $sql .= " AND arr_date = :arrival_date";
}

if (!empty($_GET['departure_date'])) {
    $sql .= " AND depart_date = :departure_date";
}
if (!empty($_GET['category'])) {
    $sql .= " AND product_cat = :category";
}
if (!empty($_GET['number_of_persons'])) {
    $sql .= " AND circ_number_of_persons = :number_of_persons";
}

$stmt = $pdo->prepare($sql);

// Bind parameters if they are set
if (!empty($_GET['arrival_date'])) {
    $stmt->bindParam(':arrival_date', $_GET['arrival_date']);
}
if (!empty($_GET['departure_date'])) {
    $stmt->bindParam(':departure_date', $_GET['departure_date']);
}
if (!empty($_GET['category'])) {
    $stmt->bindParam(':category', $_GET['category']);
}
if (!empty($_GET['number_of_persons'])) {
    $stmt->bindParam(':number_of_persons', $_GET['number_of_persons']);
}

$stmt->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <!-- Add necessary CSS for the table, forms, etc. -->
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="card-body">
        <?php if ($stmt->rowCount() > 0) : ?>
            <!-- Search Form -->
            <form id="search-form" method="GET">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="arrival_date">Arrival date:</label>
                            <input type="date" class="form-control" id="arrival_date" name="arrival_date" value="<?php echo isset($_GET['arrival_date']) ? $_GET['arrival_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="departure_date">Departure date:</label>
                            <input type="date" class="form-control" id="departure_date" name="departure_date" value="<?php echo isset($_GET['departure_date']) ? $_GET['departure_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="category">Category:</label>
                            <select name="category" id="category" class="form-control">
                                <option value="excursion" <?php echo (isset($_GET['category']) && $_GET['category'] == 'excursion') ? 'selected' : ''; ?>>Excursion</option>
                                <option value="activity" <?php echo (isset($_GET['category']) && $_GET['category'] == 'activity') ? 'selected' : ''; ?>>Activity</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="number_of_persons">Number of Persons:</label>
                            <input type="number" class="form-control" id="number_of_persons" name="number_of_persons" value="<?php echo isset($_GET['number_of_persons']) ? $_GET['number_of_persons'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary w-md" style="margin-top:25px;">Search</button>
                    </div>
                </div>
            </form>

            <!-- Export to Excel Button -->
            <a href="?export=excel" class="btn btn-primary">Export to Excel</a>

            <!-- Display the Orders in Table -->
            <table id="orderTable" class="display">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Arrival Date</th>
                        <th>Departure Date</th>
                        <th>Message Note</th>
                        <th>Product Category</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Circ Number of Persons</th>
                        <th>Activity Type</th>
                        <th>Request Date Time</th>
                        <th>Language</th>
                        <th>Specific Request</th>
                        <th>Payment Mode</th>
                        <th>Paid Amount</th>
                        <th>Status</th>
                        <th>Source</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?php echo $row["order_number"]; ?></td>
                            <td><?php echo $row["fname"]; ?></td>
                            <td><?php echo $row["lname"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["arr_date"]; ?></td>
                            <td><?php echo $row["depart_date"]; ?></td>
                            <td><?php echo $row["message_note"]; ?></td>
                            <td><?php echo $row["product_cat"]; ?></td>
                            <td><?php echo $row["product_id"]; ?></td>
                            <td><?php echo $row["product_name"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td><?php echo $row["circ_number_of_persons"]; ?></td>
                            <td><?php echo $row["act_type"]; ?></td>
                            <td><?php echo $row["request_date_time"]; ?></td>
                            <td><?php echo $row["language"]; ?></td>
                            <td><?php echo $row["specific_rq"]; ?></td>
                            <td><?php echo $row["modepaiement"]; ?></td>
                            <td><?php echo $row["paidamount"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo $row["source"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>No records found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Add necessary JS -->
<script src="path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
