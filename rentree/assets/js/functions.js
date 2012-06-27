/** 	Configuration de jcarousel		**/
stepcarousel.setup({
	galleryid: 'mygallery', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:false, moveby:1, pause:3000},
	panelbehavior: {speed:500, wraparound:false, wrapbehavior:'slide', persist:true},
	defaultbuttons: {enable: false, moveby: 1, leftnav: ['http://i34.tinypic.com/317e0s5.gif', -5, 80], rightnav: ['http://i38.tinypic.com/33o7di8.gif', -20, 80]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'] //content setting ['inline'] or ['ajax', 'path_to_external_file']

})

function chemin(num)
{
	stepcarousel.stepTo('mygallery', num);
	for(i=1;i<num;i++)
	{
		document.getElementById('sl'+i).className = 'sli';
	}
	document.getElementById('sl'+i).className = 'sliclicked';
	for(i=num+1;i<=5;i++)
	{
		document.getElementById('sl'+i).className = 'sli';
	}
}




function calcul_bbq()
{
prix_unitaire=5;
prix=0;
if(document.getElementById("bbqsam").checked==true){prix=prix+prix_unitaire;}
if(document.getElementById("bbqdim").checked==true){prix=prix+prix_unitaire;}
if(document.getElementById("bbqmar").checked==true){prix=prix+prix_unitaire;}
if(document.getElementById("bbqmer").checked==true){prix=prix+prix_unitaire;}
if(document.getElementById("bbqjeu").checked==true){prix=prix+prix_unitaire;}
if(document.getElementById("bbqven").checked==true){prix=prix+prix_unitaire;}


if(prix!=0)
{
	if(document.getElementById("bbqpaye").checked==true)
	{
		document.getElementById('prixbbq').innerHTML='A payé '+prix+'€';
		document.getElementById('afficheprixbbq').innerHTML=prix+'€ (payés)';
	}
	else
	{
		document.getElementById('prixbbq').innerHTML='Doit payer: '+prix+'€';
		document.getElementById('afficheprixbbq').innerHTML=prix+'€ (non payés)';
	}
}
else
{
	document.getElementById('prixbbq').innerHTML='Rien à payer';
	document.getElementById('afficheprixbbq').innerHTML='0€';
}
}

function enable($checkbox,$id)
{
	if(document.getElementById($checkbox).checked==true)
	{
		document.getElementById($id).disabled=false;
	}
	else
	{
		document.getElementById($id).disabled=true;
	}
}

function afficheprixbde()
{
if(document.getElementById('cotisantbde').checked==true)
{
	if(document.getElementById('bde_1a').checked==true)
	{
			if(document.getElementById('comptesg').checked==true)
			{
				if(document.getElementById('pallier').value<=0)
				{
					document.getElementById('afficheprixbde').innerHTML='120€';
					document.getElementById('afficheprixbde2').innerHTML='120€';

				}
				else if(document.getElementById('pallier').value<=4)
				{
					document.getElementById('afficheprixbde').innerHTML='120€';
					document.getElementById('afficheprixbde2').innerHTML='120€';

				}
				else if(document.getElementById('pallier').value<=6)
				{
					document.getElementById('afficheprixbde').innerHTML='90€';
					document.getElementById('afficheprixbde2').innerHTML='90€';

				}
				else
				{
							if(document.getElementById('prixbde').value=='')
			{
					document.getElementById('afficheprixbde').innerHTML='erreur (entrer un tarif spécial)';
					document.getElementById('afficheprixbde2').innerHTML='erreur (entrer un tarif spécial)';

			}
			else
			{
					document.getElementById('afficheprixbde').innerHTML=document.getElementById('prixbde').value+'€';
					document.getElementById('afficheprixbde2').innerHTML=document.getElementById('prixbde').value+'€';

			}
				}
			}
			else
			{
				document.getElementById('afficheprixbde').innerHTML='150€';
				document.getElementById('afficheprixbde2').innerHTML='150€';

			}
	}
	else if(document.getElementById('bde_erasmus6').checked==true)
	{
			if(document.getElementById('comptesg').checked==true)
			{
					document.getElementById('afficheprixbde').innerHTML='50€';
					document.getElementById('afficheprixbde2').innerHTML='50€';

			}
			else
			{
					document.getElementById('afficheprixbde').innerHTML='150€';
					document.getElementById('afficheprixbde2').innerHTML='150€';

			}
	}
	else if(document.getElementById('bde_erasmus12').checked==true)
	{
			if(document.getElementById('comptesg').checked==true)
			{
					document.getElementById('afficheprixbde').innerHTML='30€';
					document.getElementById('afficheprixbde2').innerHTML='30€';

			}
			else
			{
					document.getElementById('afficheprixbde').innerHTML='150€';
					document.getElementById('afficheprixbde2').innerHTML='150€';

			}
	}
	else if(document.getElementById('bde_perso').checked==true)
	{
			if(document.getElementById('prixbde').value=='')
			{
					document.getElementById('afficheprixbde').innerHTML='erreur (entrer un tarif spécial)';
					document.getElementById('afficheprixbde2').innerHTML='erreur (entrer un tarif spécial)';

			}
			else
			{
					document.getElementById('afficheprixbde').innerHTML=document.getElementById('prixbde').value+'€';
					document.getElementById('afficheprixbde2').innerHTML=document.getElementById('prixbde').value+'€';

			}
	}
}
else
{
					document.getElementById('afficheprixbde').innerHTML='0€';
					document.getElementById('afficheprixbde2').innerHTML='0€';
}
}

function afficheprixwei()
{
if(document.getElementById('wei').checked==true)
{
	if(document.getElementById('wei_1a').checked==true)
	{
			if(document.getElementById('comptesg').checked==true)
			{
				if(document.getElementById('pallier').value<=0)
				{
					document.getElementById('afficheprixwei').innerHTML='180€';
					document.getElementById('afficheprixwei2').innerHTML='180€';

				}
				else if(document.getElementById('pallier').value<=4)
				{
					document.getElementById('afficheprixwei').innerHTML='120€';
					document.getElementById('afficheprixwei2').innerHTML='120€';

				}
				else if(document.getElementById('pallier').value<=6)
				{
					document.getElementById('afficheprixwei').innerHTML='30€';
					document.getElementById('afficheprixwei2').innerHTML='30€';

				}
				else
				{
							if(document.getElementById('prixwei').value=='')
			{
					document.getElementById('afficheprixwei').innerHTML='erreur (entrer un tarif spécial)';
					document.getElementById('afficheprixwei2').innerHTML='erreur (entrer un tarif spécial)';

			}
			else
			{
					document.getElementById('afficheprixwei').innerHTML=document.getElementById('prixbde').value+'€';
					document.getElementById('afficheprixwei2').innerHTML=document.getElementById('prixbde').value+'€';

			}
				}
			}
			else
			{
				document.getElementById('afficheprixwei').innerHTML='250€';
				document.getElementById('afficheprixwei2').innerHTML='250€';

			}
	}
	else if(document.getElementById('wei_erasmus6').checked==true)
	{
			if(document.getElementById('comptesg').checked==true)
			{
					document.getElementById('afficheprixwei').innerHTML='180€';
					document.getElementById('afficheprixwei2').innerHTML='180€';

			}
			else
			{
					document.getElementById('afficheprixwei').innerHTML='250€';
					document.getElementById('afficheprixwei2').innerHTML='250€';

			}
	}
	else if(document.getElementById('wei_erasmus12').checked==true)
	{
			if(document.getElementById('comptesg').checked==true)
			{
					document.getElementById('afficheprixwei').innerHTML='180€';
					document.getElementById('afficheprixwei2').innerHTML='180€';

			}
			else
			{
					document.getElementById('afficheprixwei').innerHTML='250€';
					document.getElementById('afficheprixwei2').innerHTML='250€';

			}
	}
	else if(document.getElementById('wei_perso').checked==true)
	{
			if(document.getElementById('prixwei').value=='')
			{
					document.getElementById('afficheprixwei').innerHTML='erreur (entrer un tarif spécial)';
					document.getElementById('afficheprixwei2').innerHTML='erreur (entrer un tarif spécial)';

			}
			else
			{
					document.getElementById('afficheprixwei').innerHTML=document.getElementById('prixwei').value+'€';
					document.getElementById('afficheprixwei2').innerHTML=document.getElementById('prixwei').value+'€';

			}
	}
}
else
{
	document.getElementById('afficheprixwei').innerHTML='0€';
	document.getElementById('afficheprixwei2').innerHTML='0€';
}
}

  function go() {
		var msg='';
		var prix=/\d{1,3}/;
		var lettresreq=/[A-z ']+/;
		var lettres=/[A-z ']*/;
		var telephone=/(\d{10})|(\d{13})/;
		var email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/
		var date=/\d{2}\/\d{2}\/\d{4}/;
		var disi=/([a-z_]{7,8})?/;
	if ((!document.getElementById('m').checked)&&(!document.getElementById('f').checked))
	  {
		msg=msg+'Le sexe doit être spécifié. \n';
		}
	if ((!document.getElementById('tsp').checked)&&(!document.getElementById('tem').checked))
	  {
		msg=msg+'Une école doit être spécifiée. \n';
		}
	if ((!document.getElementById('2annee').checked)&&(!document.getElementById('1annee').checked)&&(!document.getElementById('master').checked))
	  {
		msg=msg+'La promo doit être spécifiée. \n';
		}
      if (!lettresreq.test(document.getElementById('nom').value))
	  {
		msg=msg+'Un nom valide est requis. \n';
		}
		if((!telephone.test(document.getElementById('portable').value)))
		{
			msg=msg+"Le numéro de portable doit être valide.\n";
		}
		if(!lettresreq.test(document.getElementById('prenom').value))
		{
		msg=msg+'Un prenom valide est requis. \n';
		}
		if(!email.test(document.getElementById('email').value))
		{
			msg=msg+"Une adresse email valide est requise.\n";
		}
		if(!disi.test(document.getElementById('s2ia').value))
		{
			msg=msg+"Un login s2ia valide est requis.\n";
		}
		if((document.getElementById('bde_perso').checked==true)&&(!prix.test(document.getElementById('prixbde').value)))
		{
			msg=msg+"Le format du tarif spécial de la cotisation est incorrect (chiffres seulement)\n";
		}
		if((document.getElementById('wei_perso').checked==true)&&(!prix.test(document.getElementById('prixwei').value)))
		{
			msg=msg+"Le format du tarif spécial du wei est incorrect (chiffres seulement)\n";
		}

	  if(msg==''){
         document.getElementById('formulaire').submit();
      }
	  else
	  {
		alert(msg);
	  }
}

  function go1() {
		var msg='';
		var prix=/\d{1,3}/;
		var lettresreq=/[A-z ']+/;
		var lettres=/[A-z ']*/;
		var telephone=/(\d{10})|(\d{13})/;
		var email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/
		var date=/\d{2}\/\d{2}\/\d{4}/;
		var disi=/([a-z_]{7,8})?/;
	if ((!document.getElementById('m').checked)&&(!document.getElementById('f').checked))
	  {
		msg=msg+'Le sexe doit être spécifié. \n';
		}
	if ((!document.getElementById('tsp').checked)&&(!document.getElementById('tem').checked))
	  {
		msg=msg+'Une école doit être spécifiée. \n';
		}
	if ((!document.getElementById('2annee').checked)&&(!document.getElementById('1annee').checked)&&(!document.getElementById('master').checked))
	  {
		msg=msg+'La promo doit être spécifiée. \n';
		}
      if (!lettresreq.test(document.getElementById('nom').value))
	  {
		msg=msg+'Un nom valide est requis. \n';
		}
		if((!telephone.test(document.getElementById('portable').value)))
		{
			msg=msg+"Le numéro de portable doit être valide.\n";
		}
		if(!lettresreq.test(document.getElementById('prenom').value))
		{
		msg=msg+'Un prenom valide est requis. \n';
		}
		if(!email.test(document.getElementById('email').value))
		{
			msg=msg+"Une adresse email valide est requise.\n";
		}
		if(!disi.test(document.getElementById('s2ia').value))
		{
			msg=msg+"Un login s2ia valide est requis.\n";
		}


	  if(msg==''){
         chemin(2);
      }
	  else
	  {
		alert(msg);
	  }
}

  function go2() {
		var msg='';
		var prix=/\d{1,3}/;

		if((document.getElementById('bde_perso').checked==true)&&(!prix.test(document.getElementById('prixbde').value)))
		{
			msg=msg+"Le format du tarif spécial de la cotisation est incorrect (chiffres seulement)\n";
		}

	  if(msg==''){
         chemin(4);
      }
	  else
	  {
		alert(msg);
	  }
}

function go3() {
		var msg='';
		var prix=/\d{1,3}/;

		if((document.getElementById('wei_perso').checked==true)&&(!prix.test(document.getElementById('prixwei').value)))
		{
			msg=msg+"Le format du tarif spécial du wei est incorrect (chiffres seulement)\n";
		}

	  if(msg==''){
         chemin(5);
      }
	  else
	  {
		alert(msg);
	  }
}