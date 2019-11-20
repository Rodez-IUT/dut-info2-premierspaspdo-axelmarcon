<!DOCTYPE html >
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>All Users</title>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<?php
			$host = 'localhost';
			$db   = 'my_activities';
			$user = 'root';
			$pass = 'root';
			$charset = 'utf8mb4';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			
			try {
				$pdo = new PDO($dsn, $user, $pass, $options);
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage(), (int)$e->getCode());
			}
			?>
			<h1>All Users</h1>
			<table>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Email</th>
					<th>Status name</th>
				</tr>
				<?php
					$status_id = 2;
					$lettre_username = 'e';
					$stmt = $pdo->query('SELECT users.id, username, email, status.name FROM users JOIN status ON users.status_id = status.id WHERE status.id="'.$status_id.'" AND username LIKE "'.$lettre_username.'%" ORDER BY username');
					while ($row = $stmt->fetch()){
						echo "<tr><td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td>".$row['name']."</td></tr>\n";
					}
				?>
			</table>

	</body>
</html>