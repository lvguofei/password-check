<?php
/**
 * Create by.
 * User:C Three FF
 * Date:2017/3/14
 * Time:13:34
 * Email: tose2008@163.com
 */
include_once('./lib.php');
$libClass = new lib();
$libClass->connect_db();
	$user = isset($_GET['user']) ? $_GET['user'] : '';
	$pwd = isset($_GET['pwd']) ? $_GET['pwd'] : '0';
	$count = '1';
	/*Create*/
	$host='localhost';  //host
    $root = '';  //name
    $pwd1 = ''; //password
    $dbname = ""; //dbname
    $con = mysql_connect($host,$root,$pwd1);
    $k_ling = '0';
   if($user == ''){
    	$where = " password  like '%$pwd%'";
    }else{
    	$where = " username = '$user' and password  like '%$pwd%' ";
    }
    $where_sql ="select * from weak_accounts where".$where;
	$check_sql = mysql_query($where_sql);
	$arr_check = mysql_fetch_array($check_sql);
	if(!empty($arr_check['password'])){
		$k_ling = '1';
	
	}else{
		$k_ling = '0';
	}
   	$sql_check ="select * from accounts where username in ('$user') and password in ('$pwd')";
   	$query_check = mysql_query($sql_check);
  	$arr_list = mysql_fetch_array($query_check);
  
   	if(!empty($arr_list)){	
   		$sql ="UPDATE accounts set count = count+1 where username = '$user'";
   	}else{
   		$sql="INSERT INTO accounts(username,password,count)values('$user','$pwd','1')";
   	}
	$query=mysql_query($sql);
	/**********/
	$nScore='0'; $nLength='0'; $nAlphaUC='0'; $nAlphaLC='0'; $nNumber='0'; $nSymbol='0'; $nMidChar='0'; $nRequirements='0'; $nAlphasOnly='0'; $nNumbersOnly='0'; $nUnqChar='0'; $nRepChar='0'; $nRepInc='0'; $nConsecAlphaUC='0'; $nConsecAlphaLC='0'; $nConsecNumber='0'; $nConsecSymbol='0'; $nConsecCharType='0'; $nSeqAlpha='0'; $nSeqNumber='0'; $nSeqSymbol='0'; $nSeqChar='0'; $nReqChar='0'; $nMultConsecCharType='0';
	 $nMultRepChar='1'; $nMultConsecSymbol='1';
	 $nMultMidChar='2'; $nMultRequirements='2'; $nMultConsecAlphaUC='2'; $nMultConsecAlphaLC='2'; $nMultConsecNumber='2';
	 $nReqCharType='3'; $nMultAlphaUC='3'; $nMultAlphaLC='3'; $nMultSeqAlpha='3'; $nMultSeqNumber='3'; $nMultSeqSymbol='3';
	 $nMultLength='4'; $nMultNumber='4';
	 $nMultSymbol='6'; $rev = '0';$sum_count = '0';
	$sAlphas = "abcdefghijklmnopqrstuvwxyz";
	$sBlphas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$sDlphas = "qwertyuiopasdfghjklzxcvbnm";
	$sClphas = "qazwsxedcrfvtgbyhnujmikolp";
	$sElphas = "QAZWSXEDCRFVTGBYHNUJMIKOLP";
	$sFlphas = "QWERTYUIOPASDFGHJKLZXCVBNM";
	$sNumerics = "0123456789";
	$arrNumer = array(0,1,2,3,4,5,6,7,8,9);
	$arrFailPars = array(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z);
	$nTmpAlphaUC = array(A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z);
	$sSymbolsArr = array('!','@','#','$','%','^','&','*','(',')');
	$sSymbols = "!@#$%^&*()";
	$sComplexity = "Too Short";
	$sStandards = "Below";
	$nMinPwdLen = 8;
	$nTmpAlphaUC ='';$nConsecAlphaUC='0';$nConsecCharType='0';
	if($pwd){
		$nScore = strlen($pwd) * $nMultLength;
		$nLength = strlen($pwd);   //字符数
		$arrpwd = str_split($pwd,'1');   //字符串拆分成数组
		$arruser = str_split($user,'1');
		$diff = '';
		
		$arrPwdLen = sizeof($arrpwd);
		//数字
		for ($a=0; $a<$arrPwdLen; $a++) {
				if(preg_match("/^\d*$/",$arrpwd[$a])){
					if ($a > 0 && $a < ($arrPwdLen - 1)) { $nMidChar++; }
					if ($nTmpNumber !== "") { if (($nTmpNumber + 1) == $a) { $nConsecNumber++; $nConsecCharType++; } }
					$nTmpNumber = $a;
					$nNumber++;
				}
				else if(preg_match("/^[A-Z]$/",$arrpwd[$a])) {
					if ($nTmpAlphaUC !== "") { if (($nTmpAlphaUC + 1) == $a) { /*$nConsecAlphaUC++;*/ $nConsecCharType++; } }
					$nTmpAlphaUC = $a;
					$nAlphaUC++;
				}
				else if (preg_match("/^[a-z]$/",$arrpwd[$a])) { 
					if ($nTmpAlphaLC !== "") { if (($nTmpAlphaLC + 1) == $a) { /*$nConsecAlphaLC++; */$nConsecCharType++; } }
					$nTmpAlphaLC = $a;
					$nAlphaLC++;
				}
				else if (preg_match("/^[^a-zA-Z0-9_]*$/",$arrpwd[$a])) { 
					if ($a > 0 && $a < ($arrPwdLen - 1)) { $nMidChar++; }
					if ($nTmpSymbol !== "") { if (($nTmpSymbol + 1) == $a) { $nConsecSymbol++; $nConsecCharType++; } }
					$nTmpSymbol = $a;
					$nSymbol++;
				}
		}
		$bCharExists = false;
		for ( $b=0; $b < $arrPwdLen; $b++) {
				if ($arrPwd[$a] == $arrPwd[$b] && $a != $b) {
					$bCharExists = true;
					$nRepInc += abs($arrPwdLen/($b-$a));
				}
		}
		if ($bCharExists) { 
				$nRepChar++; 
				$nUnqChar = $arrPwdLen-$nRepChar;
				$nRepInc = ($nUnqChar) ? ceil($nRepInc/$nUnqChar) : ceil($nRepInc); 
		}
		/*字母序字母*/
		for($i=0;$i<strlen($sBlphas);$i++){
			$sFwd = substr($sBlphas,$i,3);
			$sRev =strrev($sFwd);
			$sFwd1 = substr($sAlphas,$i,3);
			$sRev1 =strrev($sFwd1);
			if(strlen($sFwd) >2 || strlen($sFwd1) > 2){
			if(strstr($pwd,$sFwd) || strstr($pwd,$sRev) ||strstr($pwd,$sFwd1)|| strstr($pwd,$sRev1)){
				$nSeqAlpha++;
			}
			}
		}
		//判断连续的字母或数字()
		$n_abc=array();
		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr(strtolower($pwd),$i,1);
			if(substr_count($sAlphas,$sFwd) ==1 ){
				$num++;
			}else{		
				$num = '0';
			}
			$n_num[] = $num;
		}
		rsort($n_num);
		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($pwd,$i,1);
			if(substr_count($sNumerics,$sFwd) == 1 ){
				$abc++;
			}else{
				$abc='0';
			}
			$n_abc[] =$abc;
		}
		rsort($n_abc);
		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($pwd,$i,1);
			if(substr_count($sSymbols,$sFwd) ==1 ){
				$symbo++;
			}else{
				$symbo = '0';
				
			}
			$n_symbo[] =$symbo;
		}
		rsort($n_symbo);
		$arr_sum = $nLength/2;
		if($n_num[0] > $arr_sum){
			$ko_ling = '1';
			$sum_count++;
		}else if($abc[0] > $arr_sum){
			$ko_ling = '1';
			$sum_count++;
		}else if($symbo[0] >$arr_sum){
			$ko_ling = '1';
			$sum_count++;
		}else{
			$ko_ling ='0';
		}
		/*键盘序字母*/
		for($i=0;$i<strlen($sDlphas);$i++){
			$sFwd = substr($sDlphas,$i,3);
			$sRev =strrev($sFwd);
			$sFwd1 = substr($sClphas,$i,3);
			$sRev1 =strrev($sFwd1);
			if(strlen($sFwd)>2 || strlen($sFwd1) >2){
			if(strstr($pwd,$sFwd) || strstr($pwd,$sRev) || strstr($pwd,$sRev1) || strstr($pwd,$sFwd1)){
				//echo $sRev.'-'.$sFwd.'-'.$sRev1.'-'.$sFwd1.'-'.$pwd;
				$nConsecAlphaUC++;
			}
			}
		}
		for($i=0;$i<strlen($sElphas);$i++){
			$sFwd = substr($sElphas,$i,3);
			$sRev =strrev($sFwd);
			$sFwd1 = substr($sFlphas,$i,3);
			$sRev1 =strrev($sFwd1);
			if(strlen($sFwd)>2 || strlen($sFwd1) >2){
			if(strstr($pwd,$sFwd) || strstr($pwd,$sRev) || strstr($pwd,$sRev1) || strstr($pwd,$sFwd1)){
				//echo $sRev.'-'.$sFwd.'-'.$sRev1.'-'.$sFwd1.'-'.$pwd;
				$nConsecAlphaUC++;
			}
			}
		}
		//echo $nConsecAlphaUC;die;
		for($i=0;$i<strlen($sNumerics);$i++){
			$sFwd = substr($sNumerics,$i,3);
			$sRev =strrev($sFwd);
			if(strlen($sFwd)>2){
				if(strstr($pwd,$sFwd)|| strstr($pwd,$sRev)){
					$nSeqNumber++;
				}
			}
		}
		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($user,$i,3);
			$sRev =strrev($sFwd);
			if(strpos($pwd,$sFwd) !== false || strpos($pwd,$sRev) !== false){
				$diff++;
			}
		}
		$ikl='0';
		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($pwd,$i,($i+3));
			$sRev = strrev($sFwd);
			for($j=0;$j<count($arrNumer);$j++){
				//echo $arrNumer[$j];
				if(substr_count($pwd,$arrNumer[$j]) >= 3 || substr_count($pwd,$arrNumer[$j]) >= 3){
					$ikl++;
				}
			}
		}
		
		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($pwd,$i,3);
			$sRev = strrev($sFwd);
			for($j=0;$j<count($sSymbolsArr);$j++){
				if(substr_count($pwd,$sSymbolsArr[$j]) >= 3 || substr_count($pwd,$sSymbolsArr[$j]) >= 3){
					$ikl++;
				}
			}
		}

		for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($pwd,$i,3);
			$sRev = strrev($sFwd);
				for($j=0;$j<count($nTmpAlphaUC);$j++){
				if(substr_count($pwd,$nTmpAlphaUC[$j]) >= 3 || substr_count($pwd,$nTmpAlphaUC[$j]) >= 3){
					$ikl++;
				}
			}
		}
			for($i=0;$i<strlen($pwd);$i++){
			$sFwd = substr($pwd,$i,3);
			$sRev = strrev($sFwd);
			for($j=0;$j<count($arrFailPars);$j++){
			if(substr_count($pwd,$arrFailPars[$j]) >= 3 || substr_count($pwd,$arrFailPars[$j]) >= 3){
				//echo $arrFailPars[$i];
				$ikl++;
			}
			}
		}

		for($i=0;$i<strlen($sSymbols);$i++){
			$sFwd = substr($sSymbols,$i,($i+3));
			$sRev = strrev($sFwd);
			if(strstr($pwd,$sFwd) || strstr($pwd,$sRev)){
				$nSeqSymbol++;   //减1
			//	$nSeqChar++;
			}
		}
		
		if($pwd == strrev($user)){
			$rev ++;
		}
		if($nLength < 8){
			$nScore =8 * 6;
			$data['nlist'] .='{nLength:'.$nLength.',';
			$sum_count++;
		}else{
			$data['nlist'] .='{nLength:0,';
		}
		
		//	包含字母 大小写字母 特殊字符    $pWdQD
		$PwdDQ =Array($nAlphaUC,$nAlphaLC,$nNumber,$nSymbol);
		$nNumchar = "0";
		for($i=0;$i<count($PwdDQ);$i++){
			if($PwdDQ[$i] > 0){
				$nNumchar++;
			}
		}
		if($rev > 0){
			$data['nlist'] .= 'rev:'.$rev.',';
			$sum_count++;
		}else{
			$data['nlist'] .= 'rev:0,';
		}
		if($nNumchar < 3){
			$nScore = $nScore +($nNumchar * 10);
			$data['nlist'] .= 'nNumchar:'.$nNumchar.',';
			$sum_count++;
		}else{
			$pWdQD = "+"."0";
			$data['nlist'] .= 'nNumchar:0,';

		}
		/* +++++++++++++++++++++++++++++++++++++++*/
		/* Point deductions for poor practices */
		if (($nAlphaLC > 0 || $nAlphaUC > 0) && $nSymbol == 0 && $nNumber == 0) {  
			// Only Letters
			//$nScore =($nScore - $nLength);
		}		
		if ($nAlphaLC == 0 && $nAlphaUC == 0 && $nSymbol == 0 && $nNumber > 0) {  // Only Numbers
		//	$nScore = $nScore-$nLength; 
		//	$nNumbersOnly = $nLength;
			//$sNumbersOnly = "- ".$nLength;
		}

		if ($nConsecAlphaUC >0) {  // Consecutive Uppercase Letters exist
			$nScore =$nScore - 10;
			$data['nlist'] .='nConsecAlphaUC:'.$nConsecAlphaUC.','; 
			$sum_count++;
			//$sConsecAlphaUC = "- ".($nConsecAlphaUC * $nMultConsecAlphaUC);
		}else{
			$data['nlist'] .='nConsecAlphaUC:0,'; 
		}

		if ($nSeqAlpha  > 0) {  // Sequential alpha strings exist (3 characters or more)
			$nScore = $nScore - 10; 
			$data['nlist'] .='nSeqAlpha:'.$nSeqAlpha.',';
			$sum_count++;
			//$sSeqAlpha = "- ".($nSeqAlpha * $nMultSeqAlpha);
		}else{
			$data['nlist'] .='nSeqAlpha:0,';
		}
		if($k_ling > 0){
			$nScore = $nScore - 10;    //5
			$data['nlist'] .='k_ling:'.$k_ling.',';
			$sum_count++;
		}else{
			$data['nlist'] .='k_ling:0,';
		}
		if($ko_ling > 0){
			$data['nlist'] .= 'ko_ling:'.$ko_ling.",";
		}else{
			$data['nlist'] .= 'ko_ling:0,';
		}
		if($ikl > 0){
			$nScore = $nScore - 10;   //3
			$data['nlist'] .='ikl:'.$ikl.',';
			$sum_count++;
		}else{
			$data['nlist'] .='ikl:0,';
		}
		//echo $diff;die;

		if($diff >= 3){
			$nScore = $nScore - 10;   //6 
			$data['nlist'] .='diff:'.$diff.',';
			$sum_count++;
		}else{
			$data['nlist'] .='diff:0,';
		}
		if ($nSeqNumber >0) {  // Sequential numeric strings exist (3 characters or more)
			$nScore = $nScore - 10; 
			$data['nlist'] .='nSeqNumber:'.$nSeqNumber.',';
			$sum_count++;
			//$sSeqNumber = "- ".($nSeqNumber * $nMultSeqNumber);
		}else{
			$data['nlist'] .='nSeqNumber:0,';
		}
		if ($nSeqSymbol > 0) {  // Sequential symbol strings exist (3 characters or more)
			$nScore = $nScore - 10; 
			$data['nlist'] .='nSeqSymbol:'.$nSeqSymbol.'}';
			$sum_count++;
			//$sSeqSymbol = "- ".($nSeqSymbol * $nMultSeqSymbol);
		}else{
			$data['nlist'] .='nSeqSymbol:0}';
		}

		if($sum_count == 0){
			$data['nScore'] = '0';
		}else{
			$data['nScore'] .= $sum_count;
		}
		echo json_encode($data);
		/*------------------------------------------------*/



}
?>