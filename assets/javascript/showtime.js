function suppression_adherent()
{
	confirm("Vous allez aussi supprimer toutes les informations de l'adhérent (comptabilité, profil, wei, sei, ...)")
}


function drawWei(occupation_pourc, max) {
	var data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['WEI', occupation_pourc]
	]);
	var options = {
		width: 200, height: 200,
		redFrom: (9/10)*max, redTo: max,
		yellowFrom: (7/10)*max, yellowTo: (9/10)*max,
		minorTicks: 10,
		max: max,
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
		height: 200,
		title: 'TEM vs TSP',
		is3D: true,
		legend: {position: 'none'},
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_ecoles'));
	chart.draw(data, options);
}

function drawSexes(hommes, femmes) {
	var data = google.visualization.arrayToDataTable([
		['Sexe', 'Effectif'],
		['Femmes', femmes],
		['Hommes', hommes],
	]);

	var options = {
		width: 200,
		height: 200,
		title: 'Hommes vs Femmes',
		is3D: true,
		legend: {position: 'none'},
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_sexes'));
	chart.draw(data, options);
}

function drawBoursiers(non_boursiers, boursiers) {
	var data = google.visualization.arrayToDataTable([
		['Pallier', 'Effectif'],
		['Non Boursiers', non_boursiers],
		['Boursiers', boursiers],
	]);

	var options = {
		width: 200,
		height: 200,
		title: 'Boursiers',
		is3D: true,
		legend: {position: 'none'},
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_boursiers'));
	chart.draw(data, options);
}

function toggle(id)
{
	$('#'+id).toggle('slow');
}

function reveal(show, hide)
{
	$('#'+hide).hide();
	$('#'+show).show('slow');
}

function charge_photo(login) {
    $(function () {
        var img = new Image();
        var lien = "http://trombi.it-sudparis.eu/jpegPhoto.php?dn=uid%3D"+login+"%2Cou%3DPeople%2Cdc%3Dint-evry%2Cdc%3Dfr"
        $(img).load(function () {
                    $(this).hide();
                    $('#photo_adherent').empty().append(this).append('<br /><br />');
					$('#photo_adherent').style = 'display: block;'
                    $(this).fadeIn();
        }).attr('src', lien+'&plop='+new Date().getTime());
    });
}