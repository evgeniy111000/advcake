<?php 
function revert_characters($str){
	$tstr=trim($str);
	$charset='utf-8';
	if (empty($tstr)||mb_strlen($tstr,$charset)==1) return $str;
	$reverse_word='';
	$revert_str='';
	$result='';
	$array_save_case_sensitive=array();
	for($i=0;$i<mb_strlen($str,$charset);$i++){
		$array_save_case_sensitive[$i]=-1;
		$substr=mb_substr($str,$i,1,$charset);
		if ($substr==' '){
			$result.=$revert_str.$reverse_word.' ';
			$reverse_word='';
			$revert_str='';
		}else{
			if (preg_match('/[a-zабвгдеёжзийклмнопрстуфхцчшщьыъэюя]/i',$substr) > 0){	
				$reverse_word=$substr.$reverse_word;
				if (mb_strtolower($substr,$charset)==$substr)
					$array_save_case_sensitive[$i]=0;
				else
					$array_save_case_sensitive[$i]=1;
			}else{
				$revert_str.=$reverse_word.$substr;
				$reverse_word='';
			}
		}
	}
	if (!empty($reverse_word)||!empty($revert_str))
		$result.=$revert_str.$reverse_word;
	$result_case_sensitive='';
	for($i=0;$i<count($array_save_case_sensitive);$i++){
		$substr=mb_substr($result,$i,1,$charset);
		if ($array_save_case_sensitive[$i]==1)
			$substr=mb_strtoupper($substr,$charset);
		if ($array_save_case_sensitive[$i]==0)
			$substr=mb_strtolower($substr,$charset);
		$result_case_sensitive.=$substr;	
	}
	return $result_case_sensitive;
}
echo '<pre>';
echo revert_characters('Привет! Давно не виделись.');
echo '<br>';
echo revert_characters('     Привет!    !Longago!     нЕ       вИдЕлисЬ.    ');
echo '<br>';
echo revert_characters('         ');
echo '<br>';
echo revert_characters('');
echo '<br>';
echo revert_characters('  s   ');
echo '<br>';
echo revert_characters('     П    ');
echo '</pre>';
?>
