<?php foreach ($errors as $error): ?>
<div style="background-color:#ffc;border:1px solid #f44;margin:10px 0;">
	<table style="width:100%;border:1px solid #f44;">
		<tr style="font-weight:bold;">
			<td colspan="5"><?php echo $error['message'] . ' in ' . $error['file'] .
				' on line <i>' . $error['line'].'</i>'; ?></td>
		</tr>
		<tr>
			<td colspan="5">Backtraces</td>
		</tr>
		<tr>
			<td>#</td>
			<td>Function</td>
			<td>Location</td>
		</tr>
		<tr>
			<td>1</td>
			<td>{main}()</td>
			<td>/index.php:0</td>
		</tr>
		<?php foreach ($error['backtraces'] as $k => $backtrace): ?>
		<tr>
			<td><?php echo $k+1; ?></td>
			<td>
			<?php if (!empty($backtrace['class'])) echo $backtrace['class'] . $backtrace['type']; ?>
			<?php echo $backtrace['function']; ?>
			</td>
			<td></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php endforeach; ?>