<?php 
function closetags($html) 
    { 
        // strip fraction of open or close tag from end (e.g. if we take first x characters, we might cut off a tag at the end!) 
        $html = preg_replace('/<[^>]*$/','',$html); // ending with fraction of open tag 
        return $html;
        
        // put open tags into an array 
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result); 
        $opentags = $result[1]; 

        // put all closed tags into an array 
        preg_match_all('#</([a-z]+)>#iU', $html, $result); 
        $closetags = $result[1]; 

        $len_opened = count($opentags); 

        // if all tags are closed, we can return 
        if (count($closetags) == $len_opened) { 
            return $html; 
        } 

        // close tags in reverse order that they were opened 
        $opentags = array_reverse($opentags); 

        // self closing tags 
        $sc = array('br','input','img','hr','meta','link'); 
        // ,'frame','iframe','param','area','base','basefont','col' 
        // should not skip tags that can have content inside! 

        for ($i=0; $i < $len_opened; $i++) 
        { 
            $ot = strtolower($opentags[$i]); 
            if (!in_array($opentags[$i], $closetags) && !in_array($ot,$sc)) 
            { 
                $html .= '</'.$opentags[$i].'>'; 
            } 
            else 
            { 
                unset($closetags[array_search($opentags[$i], $closetags)]); 
            } 
        } 
        return $html; 
    } 
?>