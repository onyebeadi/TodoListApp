<?php
/**
 * Created by PhpStorm.
 * User: onyebeadi.chimdindu
 * Date: 08/04/2020
 * Time: 01:27
 */

include_once"controller.php";

class list_menu extends controller{
    public $menu_option="";


    public function print_list(){
        echo "\e[1;31;40m\n       All your lists\n\e[1;32;40m";
        echo "*********************************************\n\n";
        $lists = $this->load_file("list_titles");
        if(is_array($lists) && !empty($lists)){
            foreach($lists as $key => $values){
                echo "[" . ($key + 1) . "]  (" . date('d/m/Y H:i', $values['time']) . ") " . $values['title'] . "\n";
            }
            echo"*********************************************\n\n";
        }else {

            echo "\e[1;31;40m No Lists were found. \e[1;32;40m \n";
        }
    }

    public function print_list_menu(){
        echo "\e[1;31;40m\nSelect the mode you wish to use: enter\e[1;32;40m\n
	         \n'C' to Create new List
	         \n'D' to delete List.
	         \n'E' to edit
	         \n'P' to pin/unpin
	         \n'R' to Return to main menu.
	         \n'V' to view / add items in a list. \n ";
        $this->menu_option = trim(fgets(STDIN));
    }

    public function create_list(){
        echo "\e[1;31;40m Entering addition mode;
              \n type content and press enter \e[1;32;40m \n";
        $content_entered = trim(fgets(STDIN));
            if($content_entered === 0){
            echo "\e[1;31;40m\nCancelling Addition of List \e[1;32;40m\n";
        }else{
            $this->store_and_reload("list_titles", $data = ['title' => $content_entered, 'time' => time(), 'pinned' => false]);
            echo "\e[1;31;40m list added \e[1;32;40m \n";
        }

    }

    public function edit_list_name(){
        $file_data = $this->load_file("list_titles");

        echo "\e[1;31;40m Entering edit mode;
              \n type the id you wish to edit \e[1;32;40m \n";
        $content_entered = trim(fgets(STDIN));

        if(is_numeric($content_entered)){
            $index = ((int)$content_entered - 1);
            $file_name = "list_titles";
            if(array_key_exists($index,$file_data)){
                echo "\e[1;31;40m edit list name [".$index."]".$file_data[$index]['title']."
                     \n enter new content ( this will replace what was previously there)\e[1;32;40m\n";
                $new_list_name = trim(fgets(STDIN));
                $oldData = $file_data[$index];
                $oldData['title'] = $new_list_name;
                $this->update_at($file_name,$index,$oldData);
            }else{
                echo "\e[1;31;40m list not found \e[1;32;40m\n";
            }

        }else {
            echo "\e[1;31;40m id not recognized/found \e[1;32;40m\n";
        }
    }

    public function pin_unpin_list(){
        $file_data = $this->load_file("list_titles");
        echo "\e[1;31;40m Entering pinning mode;
              \n type id you wish to pin: \e[1;32;40m\n";
        $content_entered = trim(fgets(STDIN));

        if(is_numeric($content_entered)) {
            $index = ((int)$content_entered - 1);
            $file_name = "list_titles";
            if(array_key_exists($index,$file_data)){
                $oldData = $file_data[$index];
                $oldData['pinned'] = !$oldData['pinned'];
                $this->update_at($file_name,$index,$oldData);

                echo "\e[1;31;40m list un/pinned \e[1;32;40m \n";
            }else{
                echo "\e[1;31;40m list not found \e[1;32;40m \n";
            }
        }else {
            echo "\e[1;31;40m id not recognized/found \e[1;32;40m\n";
        }
    }

    public function delete_list(){
        $file_data = $this->load_file("list_titles");
        echo "\e[1;31;40m Entering delete mode;
             \n type the id you wish to delete: \e[1;32;40m\n";
        $content_entered = trim(fgets(STDIN));

        if(is_numeric($content_entered)) {
            $index = ((int)$content_entered - 1);
            $file_name = "list_titles";
            if(array_key_exists($index,$file_data)){
                $this->delete_from($file_name,$index);
                echo "\e[1;31;40m list deleted \e[1;32;40m\n";
            }else {
                echo "\e[1;31;40m list not found \e[1;32;40m \n";
            }
        }else {
            echo "\e[1;31;40m id not recognized/found \e[1;32;40m\n";
        }

    }

    public function view_list_items(){
        $file_data = $this->load_file("list_titles");
        echo "\e[1;31;40m\n Enter id of a list to view items within.\e[1;32;40m \n";
        $content_entered = trim(fgets(STDIN));

        if(is_numeric($content_entered)) {
            $index = ((int)$content_entered - 1);

            if(array_key_exists($index,$file_data)){
                include_once'listitemsmenu.php';
                $itemsObj = new list_items();
                $listing_view=true;
                do{
                    $itemsObj->print_list_items($file_data,$index);
                    $itemsObj->print_items_menu();
                    $op = $itemsObj->options;
                    switch ($op) {
                        case "A":
                            $itemsObj->add_to_list($file_data, $index);
                            break;
                        case "a":
                            $itemsObj->add_to_list($file_data, $index);            ;
                            break;
                        case "D":
                            $itemsObj->delete_list_item($file_data,$index);
                            break;
                        case "d":
                            $itemsObj->delete_list_item($file_data,$index);
                            break;
                        case "E":
                            $itemsObj->edit_list_items($file_data,$index);
                            break;
                        case "e":
                            $itemsObj->edit_list_items($file_data,$index);
                            break;
                        case "R":
                            $listing_view = false;
                            break;
                        default:
                            echo "Your option wasn't found!\n";
                    }
                }
                while ($listing_view);
            }else {
                echo "\e[1;31;40m list not found \e[1;32;40m \n";
            }
        }else {
            echo "\e[1;31;40m id not recognized/found \e[1;32;40m\n";
        }
    }

}