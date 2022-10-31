<?php
class grid{
    // never done php properly before so this code is probarbly awfull...
    public $list;


    private $undo_coord;
    private $undo_recentMove;
    private $undo = FALSE;

    function setup_list() {
        $this->list = array(
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0)
        );
    }
    function check_possible() {

    }
    function set_value($big_sq, $small_sq, $value) {
        // includes chaching most recent move
        $this->$undo_recentMove = $this->list[$big_sq-1][$small_sq-1];
        $this->list[$big_sq-1][$small_sq-1] = $value;
        $this->$undo_coord = array($big_sq,$small_sq);
        $this->$undo = TRUE;

    }
    function undo() {
        if ($this->$undo == TRUE) {
            set_value($this->$undo_coord[0],$this->$undo_coord[1],$this->$undo_recentMove);
            $this->$undo = FALSE;
        }
    }
    function create_most_basic() {
        $this->setup_list();
        $stop = FALSE;
        while ($stop == FALSE) {
            $this->set_value(rand(1,9), rand(1,9), rand(1,9));
            $big_pos = rand(1,9);
            $small_pos = rand(1,9);
        }
    }
    function solve() {
        // I suspect there are multiple ways to solve this, my prelimenary method will be to, for each empty sqare find a list of every possible number
        $stop = FALSE;
        while ($stop == FALSE) {
            // Do it in itterations, I may be able to make this more effecient
            $large_posibilities = array();
            for ($i=1; $i<=9; $i++){
                $small_posibilities = array();
                for ($j=1; $j<=9; $j++){
                    // come up with possibilities
                    $posibilities = new Vector();//array(1,2,3,4,5,6,7,8,9);

                    // TODO
                    // 1. check sqaures
                    // a. get
                    // b. for each
                    // c. unset
                    // 2., 3. rows and columns (harder to get)
                    // 4. convert whats left into posibilities and push

                    // remove from the array
                    if (($key = array_search($value, $array)) !== false) {
                        unset($array[$key]);
                    }
                    // no go though each row grid and column removing everything it can't be
                    array_push($small_posibilities, $posibilities);
                }
                array_push($large_posibilities,  $small_posibilities);
            }
        }
    }
}
?>