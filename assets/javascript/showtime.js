function suppression_adherent()
{
	confirm("Vous allez aussi supprimer toutes les informations de l'adhérent (comptabilité, profil, wei, sei, ...)")
}


function drawWei(occupation_pourc) {
	var data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['WEI', occupation_pourc]
	]);

	var options = {
		width: 200, height: 200,
		redFrom: 90, redTo: 100,
		yellowFrom:75, yellowTo: 90,
		minorTicks: 5,
		backgroundColor: '#f2f2f2'
	};

	var chart = new google.visualization.Gauge(document.getElementById('chart_wei'));
	chart.draw(data, options);
}


function drawEcoles(tem, tsp) {
	var data = google.visualization.arrayToDataTable([
		['Ecole', 'Effectif'],
		['TEM', tem],
		['TSP', tsp],
	]);

	var options = {
		width: 200,
		height: 200
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_ecoles'));
	chart.draw(data, options);
}

function drawSexes(hommes, femmes) {
	var data = google.visualization.arrayToDataTable([
		['Sexe', 'Effectif'],
		['Femme', femmes],
		['Homme', hommes],
	]);

	var options = {
		width: 200,
		height: 200
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_sexes'));
	chart.draw(data, options);
}

function voir_plus_stats(stats)
{
	$('#plus_stats').toggle('slow');
}

function plus_chercher()
{
	$('#voir_plus_chercher').hide();
	$('#plus_chercher').show('slow');
}