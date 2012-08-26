<!-- !header! -->
<header class="row">
	<nav class="twelve columns">
		<ul class="nav-bar">
			<?php
			$uri_current = uri_string();
			$items = array(
				"Accueil" => "backend",
				"Liste" => "backend/liste",
				"Statistiques" => "backend/stats",
				"Comptabilité" => "backend/comptabilite",
				"WEI" => "backend/wei",
				"SEI" => "backend/sei"
			);

			foreach($items as $titre => $uri)
			{
				if ($uri_current == $uri)
					echo "<li class='active'>".anchor($uri, $titre)."</a></li>";
				else
					echo "<li class='button-bar'>".anchor($uri, $titre)."</a></li>";
			}
			?>
		</ul>
	</nav>
</header>