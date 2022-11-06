<?php
class grid{
    public $list;


    private $undo_coord;
    private $undo_recentMove;
    private $undo = FALSE;

    function setup_list() {
        $this->list = array(
            array(0,4,5,0,0,6,0,0,7),
            array(0,3,0,0,0,0,0,0,0),
            array(1,0,2,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,8),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,9,0,0,0),
            array(0,0,0,0,0,0,0,0,0),
            array(0,0,0,0,0,0,0,0,0)
        );
    }
    function check_possible() {

    }

    function get_row($large_box, $small_box){
    	// works
        $row = array();
        $large_box_y_coord = round((($large_box-1)/3)-0.4);
        $small_box_y_coord = round((($small_box-1)/3)-0.4);
        $y_coord = 3*$large_box_y_coord + $small_box_y_coord;
        for ($i=0; $i<9; $i++){
            $large_pos = $large_box_y_coord*3 + round(($i/3)-0.4);
            $small_pos = $small_box_y_coord*3 + fmod($i, 3);
            $item = $this->list[$large_pos][$small_pos];
            if($item!=0){array_push($row, $item);}

        }
        return $row;
    }
    function get_column($large_box, $small_box){
    	// does work?
        $row = array();
        $large_box_x_coord = round((fmod($large_box-1,3)));
        $small_box_x_coord = round((fmod($small_box-1,3)));
        //echo("(".$large_box_x_coord.",".$small_box_x_coord.")");
        $y_coord = 3*$large_box_x_coord + $small_box_x_coord;
        echo($y_coord);
        for ($i=0; $i<9; $i++){
            $large_pos = $large_box_x_coord+(3*round(($i/3)-0.4));
            $small_pos = $small_box_x_coord+(3*fmod($i,3));
            echo("(".$large_pos.",".$small_pos.")");
            $item = $this->list[$large_pos][$small_pos];
            if($item!=0){array_push($row, $item);}

        }
        return $row;
    }

    function set_value($big_sq, $small_sq, $value) {
        // includes chaching most recent move
        $this->undo_recentMove = $this->list[$big_sq-1][$small_sq-1];
        $this->list[$big_sq-1][$small_sq-1] = $value;
        $this->undo_coord = array($big_sq,$small_sq);
        $this->undo = TRUE;

    }
    function undo() {
        if ($this->undo == TRUE) {
            set_value($this->undo_coord[0],$this->undo_coord[1],$this->undo_recentMove);
            $this->undo = FALSE;
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
                    $impossible = array(1,2,3,4,5,6,7,8,9);//new Vector();//

                    // TODO
                    // 1. check sqaures
                    // a. get
                    // b. for each
                    // c. unset
                    // 2., 3. rows and columns (harder to get)
                    // 4. convert whats left into posibilities and push

                    // !! CODE
                    // !  Squares - TODO make a function
                    foreach($this->list[$i] as $square){
                        if ($square != 0) {
                            array_push($impossible, $square);
                        }
                    }
                    // !  Rows -works
                    $row = $this->get_row($i, $j);
                    $impossible = array_merge($impossible,$row);
                    // !  Columns - works
                    $column = $this->get_column($i, $j);
   	                $impossible = array_merge($impossible,$column);
                    // LIST OF THINGS IT CAN'T BE
                    $impossible = array_unique($impossible);
                    // CONVERT TO WHAT IT CAN

                    array_push($small_posibilities, $posibilities);// IDK if this is a good idea
                }
                array_push($large_posibilities,  $small_posibilities);
            }
        }
    }
}
// TESTING
$grid = new Grid();
$grid->setup_list();
$row = $grid->get_row(1,3);
echo($row);
print_r($row);
echo("<br> stuf <br>");
$row = $grid->get_column(1,3);
echo($row);
print_r($row);
//print_r(array_values(array_unique(arrar(0,1,2,2,3))));

?>