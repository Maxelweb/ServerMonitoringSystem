<section>
	<h3><i class="fas fa-coffee"></i> Updates</h3>
	<?php 
		$hup = new Updates();
		if($hup->latestVersion() == "N/A")
			echo error("Unable to check for new updates. Try later or checkout the <a href='".REPO."'>official repository</a>.");
		elseif($hup->currentVersion() != $hup->latestVersion()) 
			echo error("Your version is <b>not</b> up to date.");
		else
			echo success("Your version is up to date.");
	?>

	<h3>Updates checker</h3>
	<ul>
		<li><strong>Current version:</strong> <?=$hup->currentVersion();?></li>
		<li><strong>Latest version:</strong> <?=$hup->latestVersion();?></li>
		<li><strong>Github repository for updates:</strong> <a href="<?=REPO;?>">click here</a></li>
	</ul>

	<?php
		if(!empty($hup->info()))
		{
			echo "<div class='responsive'><table>";
			foreach ($hup->info() as $key => $value) 
			{
				echo "<tr>
						<td><strong>$key</strong></td>
						<td>$value</td>
					  </tr>";
			}
			echo "</table></div>";
		}
	?>

</section>