<?php
function dataPascoa($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	if ($ano<1583) { 
		$A = ($ano % 4);
		$B = ($ano % 7);
		$C = ($ano % 19);
		$D = ((19 * $C + 15) % 30);
		$E = ((2 * $A + 4 * $B - $D + 34) % 7);
		$F = (int)(($D + $E + 114) / 31);
		$G = (($D + $E + 114) % 31) + 1;
		return date($form, mktime(0,0,0,$F,$G,$ano));
	}
	else {
		$A = ($ano % 19);
		$B = (int)($ano / 100);
		$C = ($ano % 100);
		$D = (int)($B / 4);
		$E = ($B % 4);
		$F = (int)(($B + 8) / 25);
		$G = (int)(($B - $F + 1) / 3);
		$H = ((19 * $A + $B - $D - $G + 15) % 30);
		$I = (int)($C / 4);
		$K = ($C % 4);
		$L = ((32 + 2 * $E + 2 * $I - $H - $K) % 7);
		$M = (int)(($A + 11 * $H + 22 * $L) / 451);
		$P = (int)(($H + $L - 7 * $M + 114) / 31);
		$Q = (($H + $L - 7 * $M + 114) % 31) + 1;
		return date($form, mktime(0,0,0,$P,$Q,$ano));
	}
}

function dataCarnaval($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	$a=explode("/", dataPascoa($ano));
	return date($form, mktime(0,0,0,$a[1],$a[0]-47,$a[2]));
}

function dataCorpusChristi($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	$a=explode("/", dataPascoa($ano));
	return date($form, mktime(0,0,0,$a[1],$a[0]+60,$a[2]));
}

function dataSextaSanta($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	$a=explode("/", dataPascoa($ano));
	return date($form, mktime(0,0,0,$a[1],$a[0]-2,$a[2]));
} 

?>