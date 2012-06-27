<?php
function prixWei($type,$bourse,$soge)
{
	switch($type)
	{
		case '1a':
			if($soge)
			{
				if($bourse<=0)
				{
					return 180;
				}
				elseif($bourse<=4)
				{
					return 120;
				}
				elseif($bourse<=6)
				{
					return 30;
				}
			}
			else
			{
				return 250;
			}
		case 'erasmus6':
			if($soge)
			{
				return 180;
			}
			else
			{
				return 250;
			}
		case 'erasmus12':
			if($soge)
			{
				return 180;
			}
			else
			{
				return 250;
			}
		default: return -1;
	}// fin de switch
}// fin de prixWei

function prixBde($type,$bourse,$soge)
{
	switch($type)
	{
		case '1a':
			if($soge)
			{
				if($bourse<=0)
				{
					return 120;
				}
				elseif($bourse<=4)
				{
					return 120;
				}
				elseif($bourse<=6)
				{
					return 90;
				}
			}
			else
			{
				return 150;
			}
		case 'erasmus6':
			if($soge)
			{
				return 50;
			}
			else
			{
				return 150;
			}
		case 'erasmus12':
			if($soge)
			{
				return 90;
			}
			else
			{
				return 150;
			}
		default: return 150;
	}// fin de switch
}// fin de prix BDE
?>