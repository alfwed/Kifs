<?php
echo <<<'EOD'
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
			<td colspan="5">
				<table cellspacing="0" width="100%">
				<tr>
					<td style="border-right:1px solid #888;">#</td>
					<td style="border-right:1px solid #888;">Function</td>
					<td>Location</td>
				</tr>
				<tr>
					<td style="border:1px solid #888;border-left:none;border-bottom:none;">1</td>
					<td style="border:1px solid #888;border-left:none;border-bottom:none;">{main}()</td>
					<td style="border-top:1px solid #888;">/index.php:0</td>
				</tr>
				<?php foreach ($error['backtraces'] as $k => $backtrace): ?>
				<tr>
					<td style="border:1px solid #888;border-left:none;border-bottom:none;"><?php echo $k+1; ?></td>
					<td style="border:1px solid #888;border-left:none;border-bottom:none;">
					<?php if (!empty($backtrace['class'])) echo $backtrace['class'] . $backtrace['type']; ?>
					<?php echo $backtrace['function']; ?>
					</td>
					<td style="border-top:1px solid #888;">
					<?php echo $backtrace['file'].':'.$backtrace['line']; ?>
					</td>
				</tr>
				<?php endforeach; ?>
				</table>
			</td>
		</tr>
	</table>
</div>
<?php endforeach; ?>
EOD;
