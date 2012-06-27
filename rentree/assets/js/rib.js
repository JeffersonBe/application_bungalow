function isValid(parm) {
var numb = '0123456789';
if (numb.indexOf(parm.charAt(0),0) == -1) return false;
return true;
}
var caractere= new Array();
caractere['A']=1;
caractere['B']=2;
caractere['C']=3;
caractere['D']=4;
caractere['E']=5;
caractere['F']=6;
caractere['G']=7;
caractere['H']=8;
caractere['I']=9;
caractere['J']=1;
caractere['K']=2;
caractere['L']=3;
caractere['M']=4;
caractere['N']=5;
caractere['O']=6;
caractere['P']=7;
caractere['Q']=8;
caractere['R']=9;
caractere['S']=2;
caractere['T']=3;
caractere['U']=4;
caractere['V']=5;
caractere['W']=6;
caractere['X']=7;
caractere['Y']=8;
caractere['Z']=9;

function clef_rib()
{
	$b=document.getElementById('clef_b').value;
	$g=document.getElementById('clef_g').value;
	$c=document.getElementById('clef_c').value;
	$r=document.getElementById('clef_r').value;

	if(($b.length!=5)||($g.length!=5)||($c.length!=11)||($r.length!=2))
	{
		document.getElementById('verif_rib_incomplet').style.display='block';
		document.getElementById('verif_rib_vrai').style.display='none';
		document.getElementById('verif_rib_faux').style.display='none';
	}
	else
	{
		$cbis='';
		for ($i = 0; $i < 11; $i++)
		{
			$car = $c.charAt($i);
            if (!isValid($car)) {
                $j = caractere[$car.toUpperCase()];
                $cbis =$cbis+$j;
                }
                else {
                        $cbis = $cbis+$car;
                }
		}
		key=(89*parseFloat($b))%97;
		key+=(15*parseFloat($g))%97;
		key+=(3*parseFloat($cbis))%97;
		r=parseFloat($r);
		key=key%97;
		//bouh=97 - ((89 * b + 15 * g + 76 * dbis + 3 * cbis) % 97);
		if (r==97 -key)
		{
			document.getElementById('verif_rib_incomplet').style.display='none';
			document.getElementById('verif_rib_vrai').style.display='block';
			document.getElementById('verif_rib_faux').style.display='none';
		}
		else
		{
			document.getElementById('verif_rib_incomplet').style.display='none';
			document.getElementById('verif_rib_vrai').style.display='none';
			document.getElementById('verif_rib_faux').style.display='block';
		}
	}
}