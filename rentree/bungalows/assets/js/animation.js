fenetre=1920;
$(document).ready(function(){

        $('#submit1').click(function(){
			$.post("../assets/includes/verif_inscription.php", {prenom: ""+document.getElementById("prenom").value+"", nom: ""+document.getElementById("nom").value+""}, function(data){
					$('#panneau-contenu').html(data);
					$('a[href][title]').qtip({
					content: {
						text:false// Use each elements title attribute
					},
					position: { target: 'mouse' },
					adjust: {mouse: true},
					style:
						{
							width:'auto',
							height:'auto',
							border: {
							width: 10,
							radius: 8
						},
					name:'blue', // Give it some style
					tip: { // Now an object instead of a string
					corner: 'topLeft', // We declare our corner within the object using the corner sub-option
					color: '#6699CC',
					size: {
					x: 10, // Be careful that the x and y values refer to coordinates on screen, not height or width.
					y : 10 // Depending on which corner your tooltip is at, x and y could mean either height or width!
					}
					}
					}
					});

					$('#submit2').click(function(){
						if(chosen==0)
						{
							alert("Choisis un Bungalow s'il-te-plait...");
						}
						else
						{
							var plop;
							if (document.getElementById(document.getElementById("bungalow").value).innerHTML==''){plop=""+document.getElementById(document.getElementById("bungalow").value).value+"";}else{plop='';}
							$.post("../assets/includes/register.php", {bungalow: ""+document.getElementById("bungalow").value+"", nom2: ""+document.getElementById("nom2").value+"", prenom2: ""+document.getElementById("prenom2").value+"", id_eleve: ""+document.getElementById("id_eleve").value+"", nom_bungalow: ""+plop+""}, function(data){
									$('#fin-contenu').html(data);
							});
							part3();
						}
					});
			});
			part1();
				setTimeout("part2()",5000);
        });
});

var fenetre=getWindowWidth();
var posbg=6000-fenetre;
var pospanneau=200 -(posbg-2700);

function part1(){
	nuit1();
		$('#bg').animate({backgroundPosition: '-1600px 0px'}, 5000);
			$('#quai').animate({backgroundPosition: '-1600px 600px'}, 5000);
				$('#etoiles').animate({backgroundPosition: '-50px 0px'}, 5000);
					$('#panneau').animate({backgroundPosition: '1400px 50px'}, 5000);
						$('#panneau-contenu').animate({left: '1500'}, 5000);
}

function part2(){
	nuit4();
		$('#bg').animate({backgroundPosition: '-2700px 0px'}, 3000);
			$('#etoiles').animate({backgroundPosition: '-1220px 0px'}, 3000);
				$('#train').animate({backgroundPosition: '-1100px 300px'}, 3000);
					$('#train-contenu').animate({left: '-1100px'}, 3000);
						$('#panneau').animate({backgroundPosition: '200px 50px'}, 3000);
							$('#panneau-contenu').animate({left: '300'}, 3000);
}

function part3(){
	posbg=6000-fenetre;
		$('#bg').animate({backgroundPosition: '-'+posbg+'px 0px'}, 4000);
			$('#panneau').animate({backgroundPosition: pospanneau+'px 50px'}, 4000);
				$('#panneau-contenu').animate({left: (pospanneau+100)}, 4000);
					$('#fin-contenu').animate({left: (5200-posbg)}, 4000);
						$('#soleil').animate({top:'-=200', opacity:1}, 4000);
}

function nuit1(){
	$('#soleil').animate({top:'+=400', opacity:0}, 2500);
		setTimeout("nuit2()",2000);
}

function nuit2(){
	$('#lune').animate({top:'-=300', opacity:1}, 1875);
		setTimeout("nuit3()",1875);
}

function nuit3(){
	$('#lune').animate({top:'+=100'}, 1125);
}

function nuit4(){
	$('#lune').animate({top:'+=200', opacity:0}, 2000);
		setTimeout("nuit5()",2000);
}

function nuit5(){
	$('#soleil').animate({top:'-=100', opacity:0.5}, 1000);
}

function getWindowWidth() {
	var windowWidth=0;
	if (typeof(window.innerWidth)=='number') {
		windowWidth=window.innerWidth;
	} else {
		if (document.documentElement&& document.documentElement.clientWidth) {
			windowWidth = document.documentElement.clientWidth;
		} else {
			if (document.body&&document.body.clientWidth) {
				windowWidth=document.body.clientWidth;
			}
		}
	}
	return windowWidth;
}
