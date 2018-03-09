<?php
include 'PageRank.php';

//TODO OOP
$dom = new DOMDocument;
$url = $argv[1];
//var_dump($url);
$n=$argv[2];
$flag = "".$argv[3];
//$dom->loadHTML(file_get_contents($url));
//$links = $dom->getElementsByTagName('a');
//$arrayOfHrefs = array();
////$arrayOfHrefs[]=$url;
//foreach($links as $node){
//    $href= $node->getAttribute('href');
//    if (
//        !is_null($href) && !empty($href) &&
//        $href!==$url &&
////        !preg_match("@(https|http)://". explode("://",$url)[1] . "@i",$href) &&
//        preg_match('@(https|http)://.+@i',$href)
//    ) {
//            if ($flag==='0') {
//                preg_match('@(https|http)://(www\.){0,1}'. explode("://",$url)[1] .'.+@i',$href,$matches);
//                if (is_array($matches)&&!empty($matches[0])) {
//                    array_push($arrayOfHrefs,$matches[0]);
//                }
//            } else {
//                $arrayOfHrefs[] = $href;
//            }
//    }
//}
//
//$arrayOfHrefs=array_values(array_slice(array_unique($arrayOfHrefs),0,$n));
//$matrix = buildAdjacencyMatrix($arrayOfHrefs);
$pr = new PageRank();
//var_dump($pr->get());
//$pr->writeM()
//for ($i=0;$i<10;$i++) {
    $pr->getPR();
//var_dump(intval("0"));
    $pr->writePR();
//}



//foreach ($arrayOfHrefs as $line) {
//    file_put_contents('out.txt',writeLine(getAdjacencyLine($line,$arrayOfHrefs)) .' '. $line."\n",FILE_APPEND);
//}

function buildAdjacencyMatrix ($hrefs) {
    $matrix =array();
    foreach ($hrefs as $href) {
        array_push($matrix,getAdjacencyLine($href,$hrefs));
    }
    return $matrix;
}

function getAdjacencyLine($line,$arrayOfHrefs) {
    $dom1= new DOMDocument();
    $dom1->loadHTML(file_get_contents($line));
    $links1=$dom1->getElementsByTagName('a');
    $hrefs=array();
    $line1= array_fill(0,count($arrayOfHrefs),0);
    foreach($links1 as $node){
        $href= $node->getAttribute('href');
        if (
            !is_null($href) && !empty($href) &&
            preg_match('@(https|http)://.+@i',$href)
        ) {
            $hrefs[] = $href;
        }
    }
    $hrefs= array_values($hrefs);
    for ($i = 0; $i<count($hrefs);$i++) {
        if (in_array($hrefs[$i],$arrayOfHrefs)) {
            $line1[array_search($hrefs[$i],$arrayOfHrefs)]=1;
        }
    }
    return $line1;
}
function writeLine ($line) {
    return '['.implode(' ',$line).']';
}
