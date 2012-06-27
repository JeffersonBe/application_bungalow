var ids = new Array();
nb_ajouts=0;
sels=0;
sela=0;

function show()
{
	$q=document.getElementById("search").value;
	if ($q=="")
  {
  $q="_all";
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	document.getElementById("liste_recherche").innerHTML=xmlhttp.responseText;
    }
  }
  sels=0;
  document.getElementById("select_search").value="Sélectionner tout";
xmlhttp.open("GET","includes/search.php?q="+$q,true);
xmlhttp.send();
}

function sel_search()
{
if(sels)
{
	for (i=1;i<=document.getElementById('nb_recherches').value;i++)
	{
		document.getElementById("recherche["+i+"]").checked=false;
	}
	document.getElementById("select_search").value="Sélectionner tout";
	sels=0;
	}
	else
	{
		for (i=1;i<=document.getElementById('nb_recherches').value;i++)
	{
		document.getElementById("recherche["+i+"]").checked=true;
	}
	sels=1;
	document.getElementById("select_search").value="Désélectionner tout";
	}

}

function sel_ajout()
{
	if(sela)
	{
	for (i=1;i<=nb_ajouts;i++)
	{
		if(ids[i]==1){document.getElementById("ajout"+i).checked=false;}
	}
	sela=0;
	document.getElementById("select_ajout").value="Sélectionner tout";
	
	}
	else
	{
		for (i=1;i<=nb_ajouts;i++)
	{
		if(ids[i]==1){document.getElementById("ajout"+i).checked=true;}
	}
	sela=1;
	document.getElementById("select_ajout").value="Désélectionner tout";
	
	}

}

function aj()
{
$ligne=document.getElementById("liste_ajout").innerHTML.substring(0,document.getElementById("liste_ajout").innerHTML.lastIndexOf("</table>"));
j=0;
 for (i=1;i<=document.getElementById('nb_recherches').value;i++)
 {
	if(document.getElementById("recherche["+i+"]").checked==true){
	if(typeof(ids[document.getElementById("recherche["+i+"]").value])=='undefined'){
	$ligne=$ligne+"<tr class='element_ajout'><th scope='col'><input type='checkbox' value='"+document.getElementById("recherche["+i+"]").value+"' name='ajout"+i+"' id='ajout"+i+"'/><input type='hidden' value='"+document.getElementById("recherche["+i+"]").value+"' name='ajoutid"+i+"' id='ajoutid"+i+"'/></th>"
  +"<th scope='col'><label for='ajout"+i+"'>"+document.getElementById("nom["+i+"]").value+" "+document.getElementById("prenom["+i+"]").value+"</label><input type='hidden' name='info"+i+" value='"+document.getElementById("nom["+i+"]").value+" "+document.getElementById("prenom["+i+"]").value+"'/></th>"
  +"</tr>";
  j=j+1;
  ids[document.getElementById("recherche["+i+"]").value]=1;
  }
  else
  {
	if(ids[document.getElementById("recherche["+i+"]").value]==0)
	{
		$ligne=$ligne+"<tr class='element_ajout'><th scope='col'><input type='checkbox' value='"+document.getElementById("recherche["+i+"]").value+"' name='ajout"+i+"' id='ajout"+i+"'/><input type='hidden' value='"+document.getElementById("recherche["+i+"]").value+"' name='ajoutid"+i+"' id='ajoutid"+i+"'/></th>"
  +"<th scope='col'><label for='ajout"+i+"'>"+document.getElementById("nom["+i+"]").value+" "+document.getElementById("prenom["+i+"]").value+"</label><input type='hidden' name='info"+i+" value='"+document.getElementById("nom["+i+"]").value+" "+document.getElementById("prenom["+i+"]").value+"'/></th>"
  +"</tr>";
  j=j+1;
  ids[document.getElementById("recherche["+i+"]").value]=1;
	
	}
  }
  }
  
 }
 nb_ajouts=j+nb_ajouts;
 $ligne=$ligne+"</table>"+"<input type='hidden' name='nb_ajouts' value='"+nb_ajouts+"'/>";
 document.getElementById("liste_ajout").innerHTML=$ligne;

}

function ret()
{
$ligne="<table id='table_ajout' width='380'>";
j=0;
 for (i=1;i<=nb_ajouts;i++)
 {
	if(ids[i]==1)
	{
		if(document.getElementById("ajout"+i).checked==false){
	$ligne=$ligne+"<tr class='element_ajout'><th scope='col'><input type='checkbox' value='"+document.getElementById("recherche["+i+"]").value+"' name='ajout"+i+"' id='ajout"+i+"'/><input type='hidden' value='"+document.getElementById("recherche["+i+"]").value+"' name='ajoutid"+i+"' id='ajoutid"+i+"'/></th>"
  +"<th scope='col'><label for='ajout"+i+"'>"+document.getElementById("nom["+i+"]").value+" "+document.getElementById("prenom["+i+"]").value+"</label><input type='hidden' name='info"+i+" value='"+document.getElementById("nom["+i+"]").value+" "+document.getElementById("prenom["+i+"]").value+"'/></th>"
  +"</tr>";
  j=j+1;
  }else{ids[document.getElementById("ajout"+i).value]=0}
  }
 }
 $ligne=$ligne+"</table>"+"<input type='hidden' name='nb_ajouts' value='"+nb_ajouts+"'/>";
 document.getElementById("liste_ajout").innerHTML=$ligne;
 sela=0;
document.getElementById("select_ajout").value="Sélectionner tout";
}