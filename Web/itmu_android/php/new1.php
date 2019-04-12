 <?php
function familyName($fname) {

$off[0] = 'fucker';
$off[1] = 'motherfucker';
$off[2] = 'bastard';
$off[3] = 'ghanta';
$off[4] = 'fuck';
$off[5] = 'bitch';
   
   $temp=explode(" ",$fname);
   for($k=0;$k<count($temp);$k++){
        for($j=0;$j<count($off);$j++)
        {
            
            if (strpos($temp[$k], $off[$j]) !== false)
            {
                $star="";
                for($i=0;$i<strlen($off[$j])-2;$i++)
                {
                    $star=$star."*";
                }
                $temp[$k] = str_replace(substr( $off[$j],1,count($off[$j])-2),$star,$temp[$k]);
            }
        }

       $fname1=$fname1." ".$temp[$k];
   }
    return $fname1;
    
    
}
echo familyName("bitch you fucker.. bitch please.. fuck off..");

?>