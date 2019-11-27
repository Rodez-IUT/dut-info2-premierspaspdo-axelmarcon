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
			
			if( isset($_POST["lettre"])) {
				$lettre_username = $_POST["lettre"];
			}
			if( isset($_POST["status"])) {
				$status_id = $_POST["status"];
			}
			
			if(isset($_GET["status_id"], $_GET["user_id"], $_GET["action"])) {
				try {
					$pdo->beginTransaction();
					$stmt = $pdo->prepare("INSERT INTO users (name) VALUES (?)");  //TODO à faire
					
					$pdo->commit();
				}catch (Exception $e){
					$pdo->rollBack();
					throw $e;
				}
			}
			
			
			
		?>
			<h1>All Users</h1>
			
			<form method="post" action="all_users.php">
			
				<label for="lettre">Start with letter </label>
				<input type="text" id="lettre" name="lettre"  maxlength="1" size="2"
				<?php if (isset($lettre_username)){ echo "value='$lettre_username'"; } ?>
				/>
				
				<label for="status">and status is  </label>
				<select id="status" name="status" />
					<option value="1"
					<?php if (isset($status_id) && $status_id == 1){ echo "selected"; } ?>
					/>Waiting for account validation</option>
					<option value="2"
					<?php if (isset($status_id) && $status_id == 2){ echo "selected"; } ?>
					>Active account</option>
					<option value="3"
					<?php if (isset($status_id) && $status_id == 3){ echo "selected"; } ?>
					>Waiting for account deletion</option>
				</select>
				
				<input type="submit" value="Rechercher" />
				
			</form>
			
			<br/>
			
			<table>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Email</th>
					<th>Status name</th>
				</tr>
				<?php
					if ( isset($lettre_username, $status_id)) {
						$stmt = $pdo->prepare('SELECT users.id, username, email, status.name FROM users JOIN status ON users.status_id = status.id WHERE status.id= :status_id AND username LIKE :lettre_username ORDER BY username');
						$stmt->execute(['status_id' => $status_id, 'lettre_username' => $lettre_username.'%']);
					} else {
						$stmt = $pdo->query('SELECT users.id, username, email, status.name FROM users JOIN status ON users.status_id = status.id ORDER BY username');
					}
					while ($row = $stmt->fetch()){
						if($row['name'] == "Waiting for account deletion") {
							echo "<tr><td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td>".$row['name']."</td></tr>\n";
						} else {
							echo "<tr><td>".$row['id']."</td><td>".$row['username']."</td><td>".$row['email']."</td><td>".$row['name']."</td><td><a href='all_users.php?status_id=3&user_id=".$row['id']."&action=askDeletion'>Ask deletion</a></td></tr>\n";
						}
					}
				?>
			</table>

	</body>
</html>