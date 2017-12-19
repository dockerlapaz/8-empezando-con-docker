<!DOCTYPE html>
<html class="has-navbar-fixed-top">
<head>
	<title>Docker Nights 8</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
</head>
<body>

	<nav class="navbar is-info is-fixed-top" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">	
			<a class="navbar-item" href="/">
				<img src="https://hub.docker.com/public/images/logos/mini-logo.svg" alt="Docker La Paz">
			</a>
			<a class="navbar-item" href="https://www.facebook.com/dockerlapaz">
				Docker La Paz
			</a>
		</div>
	</nav>

	<section class="section">

		<div class="container">

			<div class="content">

				<div class="columns">

					<div class="column is-two-fifths">

						<h1 class="title">Docker Nights 8: ¿Cómo empiezo con Docker?</h1>
						<form action="/" method="post" accept-charset="utf-8">
							<div class="field">
								<label class="label" for="tu_nombre">Nombre:</label>
								<div class="control">
									<input class="input" type="text" name="tu_nombre" id="tu_nombre" placeholder="ej. Matador Mamani" required>
								</div>
							</div>

							<div class="field">
								<label class="label" for="tu_pregunta">Pregunta:</label>
								<div class="control">
									<textarea class="textarea" placeholder="ej. ¿Cómo abro el puerto 3306 en un contenedor?" name="tu_pregunta" id="tu_pregunta" rows="2" cols="5" required></textarea>
								</div>
							</div>

							<div class="field">
								<div class="control">
									<input class="button is-info" type="submit" name="enviar" value="Enviar">
								</div>
							</div>
						</form>

					</div>


					<div class="column">
						<?php echo (($all_questions->isDead() == TRUE) ? "<div class='notification'><h1 class='is-title'>¿Dudas con Docker?</h1><p class='subtitle'>Publica tu pregunta en el formulario de esta página.</p></div>" : "") . "\n"; ?>

						<?php
							foreach($all_questions as $q) {
								$q_date = $q["date"]->toDateTime()->format('Y-m-d H:i:s');
								$question = "<div class='box'>";
								$question .= "<strong>" . $q["name"] . "</strong> &middot; <small>" . $q["votes"] . (($q["votes"] == 1) ? " punto" :  " puntos ") . " &middot; " . $time_ago->inWords($q_date) . "</small>";
								$question .= "<p>" . $q["question"] . "</p>";
								$question .= "<button class='button' onclick=\"window.location.href='/vote/up?id=" . $q["_id"] . "'\" /><span class='icon'><i class='fa fa-thumbs-up' aria-hidden='true'></i></span></button>";
								$question .= "<button class='button' onclick=\"window.location.href='/vote/down?id=" . $q["_id"] . "'\" /><span class='icon'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></span></button>";
								$question .= "</div>";
								echo $question;
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>