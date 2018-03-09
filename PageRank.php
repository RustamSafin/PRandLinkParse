<?php
/**
 * Created by PhpStorm.
 * User: rustam
 * Date: 02.03.18
 * Time: 19:47
 */

class PageRank {

    private $matrix;
    private $pageRank;
    private $links;
    const D=0.85;

    public function __construct()
    {
        $this->matrix=$this->editMatrix($this->readMatrix());
        $this->pageRank = array_fill(0,count($this->matrix),1);
    }

    public function get(){
        return $this->pageRank;
    }

    public function getMatrix() {
        return $this->matrix;
    }
//    public function sumRanks($ranks)
//    {
//        $r = array();
//        foreach ($ranks as $i => $rank) {
//            if ($rank !== 0) {
//                $r[]=$this->pageRank[$i]/$rank;
//            } else {
//                $r[]=0;
//            }
//        }
//        return array_sum($r);
//    }

    public function sumRanks($index) {
        $r = array();
        for ($i=0; $i<count($this->matrix);$i++) {
            if ($this->matrix[$i][$index] !== 0) {
                $r[]=$this->pageRank[$i]/array_sum($this->matrix[$i]);

            }
        }
        return array_sum($r);
    }
    public function getPR(){
        for ($i=0;$i<2;$i++) {
            foreach ($this->matrix as $key => $line) {
                $this->pageRank[$key] = $this->pagerank($key);
            }
        }
    }
    public function pagerank($index) {
        return 1-self::D + self::D*(self::sumRanks($index));
    }

//    public function getPR(){
////        for ($i=0;$i<5;$i++) {
//            foreach ($this->matrix as $key=>$line){
//                $this->pageRank[$key] = $this->pagerank($line);
////            }
//        }
//    }
//
//
//
//    public function pagerank($ranks) {
//        return 1-self::D + self::D*(self::sumRanks($ranks));
//    }
    public function editMatrix($matrix){
        for ($i=0;$i<count($matrix);$i++) {
            for ($j=0;$j<count($matrix);$j++) {
                if ($i===$j) {$matrix[$i][$j]=0;}
            }
        }
        return $matrix;
    }

    public function writeM(){
        foreach ($this->getMatrix() as $m) {
            file_put_contents('matrix.txt',implode(', ', $m)."\n", FILE_APPEND);
        }
    }
    public function writePR(){
        for ($i=0;$i<count($this->pageRank);$i++){
            file_put_contents('pagerank.txt',$this->pageRank[$i].$this->links[$i]."\n",FILE_APPEND);
        }
    }

    public function readMatrix(){
        $m=array();
        $file = fopen('out.txt','r');
        if ($file) {
            while (($line = fgets($file))!==false) {
                $this->links[]=substr($line,strpos($line,']')+1,strlen($line));
                $line = explode(' ',substr($line,1,strpos($line,']')-1));

                foreach ($line as $k=>$l) {
                    $line[$k]=intval($l);
                }
                $m[]=$line;
            }
            fclose($file);
        }
        return $m;
    }
}