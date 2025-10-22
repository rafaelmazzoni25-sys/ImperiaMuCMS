<?php

echo '<form action="'.__BASE_URL__.'index.php?step=config" method="post">';
	echo '<input type="hidden" name="licenseok" value="1"/>';
	echo '<input type="submit" name="systemcheck" value="Continue" class="btn btn-primary btn-lg">';
echo '</form>';