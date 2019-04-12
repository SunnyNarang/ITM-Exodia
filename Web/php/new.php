 <?php
 function stars($no){
    $star="";
    for($i=0;$i<$no-2;$i++)
    $star=$star."*";
    return $star;
}
function familyName($fname) {
    $a=explode(" ", $fname);
    $off[0] = 'hello';
$off[1] = 'fuck';
$off[2] = 'bye';
    for($i=0;$i<count($a);$i++)
    {
        
        for($j=0;$j<count($off);$j++)
        {
            //if("saurav"=="saurav")
            if($a[$i]==$off[$j])
            {
                $a[$i]=substr_replace($a[$i], "***", 1, count($a[$i])-2);
            }
        }
    }
    $clear="";
    for($i=0;$i<count($a);$i++){
      
        $clear.=" ".$a[$i];
    }
    return $clear;
    
}




echo familyName("hello fuck hello");

?>