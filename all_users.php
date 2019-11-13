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
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php
					$stmt = $pdo->query('SELECT users.id as user_id, username, email, status.name as status'); //TODO finir
					while ($row = $stmt->fetch()){
						echo "<tr><td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td>".$row['status']."</td></tr>\n";
					}
				?>
			</table>

	</body>
</html>