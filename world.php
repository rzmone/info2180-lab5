<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123'; // password for lab5_user
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// GET variables
$country = isset($_GET['country']) ? trim($_GET['country']) : ''; // country url
$lookup  = isset($_GET['lookup']) ? trim($_GET['lookup']) : '';

// choose query based on lookup
if ($lookup === 'cities') {
    $sql = "
        SELECT cities.name, cities.district, cities.population
        FROM cities
        JOIN countries ON cities.country_code = countries.code
        WHERE countries.name LIKE :country
        ORDER BY cities.name ASC
    ";
} else {
    $sql = "SELECT * FROM countries WHERE name LIKE :country"; 
}

$stmt = $conn->prepare($sql);
$search = '%' . $country . '%';
$stmt->bindParam(':country', $search, PDO::PARAM_STR);
$stmt->execute(); 

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// table structure
?>

<?php if ($lookup === 'cities'): ?>
<table border="1" cellpadding="5">
  <thead>
    <tr>
      <th>Name</th>
      <th>District</th>
      <th>Population</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']); ?></td>
        <td><?= htmlspecialchars($row['district']); ?></td>
        <td><?= htmlspecialchars($row['population']); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
<table border="1" cellpadding="5">           
  <thead>                                      
    <tr>                                          
      <th>Name</th>
      <th>Continent</th>
      <th>Independence Year</th>
      <th>Head of State</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']); ?></td>
        <td><?= htmlspecialchars($row['continent']); ?></td>
        <td><?= htmlspecialchars($row['independence_year']); ?></td>
        <td><?= htmlspecialchars($row['head_of_state']); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
