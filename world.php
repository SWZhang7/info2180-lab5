<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup  = isset($_GET['lookup']) ? $_GET['lookup'] : '';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($lookup === 'cities') {
    
    $sql = "
        SELECT cities.name, cities.district, cities.population
        FROM cities
        JOIN countries ON cities.country_code = countries.code
        WHERE countries.name LIKE :country
    ";
    $stmt = $conn->prepare($sql);
    $like = "%$country%";
    $stmt->bindParam(':country', $like, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['district']) . "</td>";
            echo "<td>" . htmlspecialchars($row['population']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No cities found.</p>";
    }

} else {
    
    if ($country === '') {
        $sql = "SELECT name, continent, independence_year, head_of_state FROM countries";
        $stmt = $conn->query($sql);
    } else {
        $sql = "SELECT name, continent, independence_year, head_of_state 
                FROM countries 
                WHERE name LIKE :country";
        $stmt = $conn->prepare($sql);
        $like = "%$country%";
        $stmt->bindParam(':country', $like, PDO::PARAM_STR);
        $stmt->execute();
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Continent</th><th>Independence</th><th>Head of State</th></tr>";
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
            echo "<td>" . htmlspecialchars($row['independence_year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['head_of_state']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No countries found.</p>";
    }
}
?>
