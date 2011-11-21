<html>

<head>
	<title>Dummy page</title>
</head>

<body>
	<h1>Kifs is the best framework ever made</h1>

	<p>There are <?php echo count($this->messages); ?> messages</p>

	<table>
		<tr>
			<td>Date</td>
			<td>User</td>
			<td>Message</td>
		</tr>
		<?php foreach ($this->messages as $message): ?>
		<tr>
			<td><?php echo $message['ts_create']; ?></td>
			<td><?php echo $message['user']; ?></td>
			<td><?php echo $message['message']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>

</html>