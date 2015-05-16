<?php
function generate_options($from,$to,$callback=false)
{
    $reverse=false;

    if($from>$to)
    {
        $tmp=$from;
        $from=$to;
        $to=$tmp;

        $reverse=true;
    }

    $return_string=array();
    for($i=$from;$i<=$to;$i++)
    {
        $return_string[]='
        <option value="'.$i.'">'.($callback?$callback($i):$i).'</option>
        ';
    }

    if($reverse)
    {
        $return_string=array_reverse($return_string);
    }

    return join('',$return_string);
}

function callback_month($month)
{
    return date('M',mktime(0,0,0,$month,1));
}

/* and here is how we use it (taken from our XHTML code above):
generate_options(1,31);				// generate days
generate_options(date('Y'),1900);			// generate years, in reverse
generate_options(1,12,'callback_month');		// generate months
*/
?>