<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sudoku</title>
</head>

<?php
class grid{
    public $list;


    private $undo_coord;
    private $undo_recentMove;
    private $undo = FALSE;

    function setup_list_empty() {
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
    function setup_list_2() {
        // an easy sudoku
        $this->list = array(
            array(0,0,0,6,8,0,1,9,0),
            array(2,6,0,0,7,0,0,0,4),
            array(7,0,1,0,9,0,5,0,0),
            array(8,2,0,0,0,4,0,5,0),
            array(1,0,0,6,0,2,0,0,3),
            array(0,4,0,9,0,0,0,2,8),
            array(0,0,9,0,4,0,7,0,3),
            array(3,0,0,0,5,0,0,1,8),
            array(0,7,4,0,3,6,0,0,0)
        );
    }
    function setup_list_hardest() {
        // the worlds hardest ??
        $this->list = array(
            array(8,0,0,0,0,3,0,7,0),
            array(0,0,0,6,0,0,0,9,0),
            array(2,0,0,0,0,0,0,0,0),
            array(0,5,0,0,0,0,0,0,0),
            array(0,0,7,0,4,5,1,0,0),
            array(0,0,0,7,0,0,0,3,0),
            array(0,0,1,0,0,8,0,9,0),
            array(0,0,0,5,0,0,0,0,0),
            array(0,6,8,0,1,0,4,0,0)
        );
    }
    function setup_list_4() {
        $this->list = array(
            array(0,0,0,0,1,6,4,7,0),
            array(0,6,0,0,0,0,3,0,0),
            array(0,7,0,0,0,0,0,0,8),
            array(0,0,5,1,2,0,0,0,7),
            array(0,7,9,0,0,4,0,2,0),
            array(0,4,0,5,0,0,9,6,0),
            array(6,3,0,2,0,8,0,0,0),
            array(7,0,0,0,0,0,0,5,0),
            array(0,0,4,0,0,0,0,1,0)
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
        //echo($y_coord);
        for ($i=0; $i<9; $i++){
            $large_pos = $large_box_x_coord+(3*round(($i/3)-0.4));
            $small_pos = $small_box_x_coord+(3*fmod($i,3));
            //echo("(".$large_pos.",".$small_pos.")");
            $item = $this->list[$large_pos][$small_pos];
            if($item!=0){array_push($row, $item);}

        }
        return $row;
    }
    function get_square($large_box,$small_box){
        // Seems kind of unessacery as its so easy but for code completnesss/neatness i'll do it anyway
        $toreturn = array();
        foreach($this->list[$i] as $square){
            if ($square != 0) {
                array_push($toreturn, $square);
            }
        }
        return $toreturn;
    }

    function set_value($big_sq, $small_sq, $value) {
        // includes chaching most recent move
        $this->undo_recentMove = $this->list[$big_sq-1][$small_sq-1];
        $this->list[$big_sq-1][$small_sq-1] = $value;
        $this->undo_coord = array($big_sq,$small_sq);
        $this->undo = TRUE;
    }
    function get_value($big_sq, $small_sq) {
        return $this->list[$big_sq-1][$small_sq-1];
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
            $big_pos = rand(1,9);
            $small_pos = rand(1,9);
            $val = rand(1,9);
            // test if possible
            $box = $this->get_square($big_pos,$small_pos);
            $row = $this->get_row($big_pos,$small_pos);
            $column = $this->get_column($big_pos,$small_pos);
            $allvalues = array_merge($box,$row);
            $allvalues = array_merge($allvalues,$column);
            if (!in_array($val, $allvalues)) {
                $this->set_value($big_pos,$small_pos,$val);
                // TRY TO SOLVE
            }
        }
    }
    function solve() {
        $stop = FALSE;
        while ($stop == FALSE) {
            // To get it working just keep running the for loop until one thing is found then go again
            // Later for optimizarion I can do find one then spread out and find others etc. etc.


            for ($i=1; $i<=9; $i++){
                $small_posibilities = array();
                for ($j=1; $j<=9; $j++){
                    if($this->list[$i-1][$j-1] == 0){
                        // come up with possibilities
                        $impossible = array();

                        // ! CODE 
                        //  Squares - TODO make a function
                        $square = $this->get_square($i,$j);
                        $impossible = array_merge($impossible,$square);
                        //  Rows -works
                        $row = $this->get_row($i, $j);
                        $impossible = array_merge($impossible,$row);
                        //  Columns - works
                        $column = $this->get_column($i, $j);
                        $impossible = array_merge($impossible,$column);

                        // Create a combined list
                        $impossible = array_values(array_unique($impossible));
                        
                        
                        if(count($impossible)==8){
                            $this->list[$i-1][$j-1] = 45 - array_sum($impossible);
                        }
                        //array_push($small_posibilities, $posibilities);// IDK if this is a good idea
                    }
                }
                //array_push($large_posibilities,  $small_posibilities);
            }
            $stop = TRUE;
            foreach($this->list as $largeSQ){
                foreach($largeSQ as $smallSQ){
                    if($smallSQ == 0){
                        $stop = FALSE;
                    }
                }
            }
        }
    }
}
function createHTMLfromGrid($grid){
    $html = "<div class=\"grid\">";
    for($i=1;$i<=9;$i++){
        $html .= "<div class=\"square_9\">";
        for($j=1;$j<=9;$j++){
            $value = $grid->get_value($i,$j);
            if($value==0){
                $html .= "<input class=\"square_1\" maxlength=\"1\"></input>";
            }else{
                $html .= "<div class=\"square_1\">".$value."</div>";
            }
        }
        $html .= "</div>";
    }
    $html .= "</div>";
    return $html;
}
function createHTMLform(){
    $html = "<form method=\"post\" action=\"./index.php\">";
    $html .= "<div class=\"grid\">";
    for ($i = 0; $i < 9; $i++) {
        $html .= "<div class=\"square_9\">";
        for ($j=0; $j < 9; $j++) {
            $html .= "<input type=\"text\" id=\"".$i.$j."\" name=\"".$i.$j."\" class=\"square_1\" maxlength=\"1\"></input>";
        }
        $html .= "</div>";
    }
    $html .= "</div>";
    $html .= "<input type=\"submit\" value=\"Submit\">";
    $html .= "</form>";
    return $html;
}
function getGridFromForm(){
    $grid = new Grid();
    $grid->setup_list_empty();
    for ($i = 0; $i < 9; $i++) {
        for ($j=0; $j < 9; $j++) {
            $value = $_POST[$i.$j];
            //echo("[(".$i.",".$j.") ".$value."]");
            if($value != ""){
                $grid->set_value($i+1,$j+1,$value);
            }
        }
    }
    return $grid;
}

// scripts to solve an inputed gird

if(isset($_POST["00"])){
    echo("1");
    $grid = getGridFromForm();
    echo("2");
    echo(createHTMLfromGrid($grid));
    echo("2b");
    $grid->solve();
    echo("3");
    $html = createHTMLfromGrid($grid);
    echo("4");
}else{
    $html = createHTMLform();
}





// NOTE unused because of file imports
// $grid = new Grid();
// $grid->setup_list_2();
// $output = createHTMLfromGrid($grid);
// $output .= "<br>";
// $grid->solve();
// $output .= createHTMLfromGrid($grid);
?>

<body>
    <header>
        <h1>Sudoku</h1>
    </header>
    <main>

        <?php echo($html); ?>

    </main>
</body>
</html>