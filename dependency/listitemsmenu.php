<?php
/**
 * Created by PhpStorm.
 * User: onyebeadi.chimdindu
 * Date: 08/04/2020
 * Time: 04:12
 */
include_once"controller.php";

class list_items extends controller{
    public $options = "";

    public function print_list_items($list_data,$index){
        $new_file_name = $list_data[$index]['time'];
        $list_items_data = $this->load_file($new_file_name);
        if(is_array($list_items_data) && !empty($list_items_data)){
            echo "\e[1;34;40m ******************************************\e[1;32;40m\n";
            echo "Items in list (".$list_data[$index]['title']." )\n";
            foreach($list_items_data as $key => $value){
                echo "[". ($key + 1) ."]  (". date('d/m/Y H:i', $value['time']).")  ". $value['content']."\n";
            }
        }else {
            echo "\e[1;31;40m List has no items \e[1;32;40m \n";
        }
        echo "\e[1;34;40m ******************************************\e[1;32;40m \n";
    }

    public function print_items_menu(){
        echo "\n\e[1;31;40m Select the list mode you wish to use; enter\e[1;32;40m \n
              \n'A' to Add Item to List
              \n'D' to Delete item from list.
              \n'E' to edit
              \n\n''R' to return to previous menu\n";
        $this->options = trim(fgets(STDIN));
    }

    public function add_to_list($list_data,$index){
        echo "\e[1;31;40mEntering addition mode;
              \n > type content and press enter \n\e[1;32;40m";
        $filename = $list_data[$index]['time'];
        $content_entered = trim(fgets(STDIN));
        $this->store_and_reload($filename,$data = ['content' => $content_entered, 'time' => time()]);
        echo "\e[1;31;40m> item added to list\e[1;32;40m\n";
    }

    public function edit_list_items($list_data,$index){
        echo "\e[1;31;40m Entering edit mode;
              \n > type the id you wish to edit \e[1;32;40m\n";
        $content_entered = trim(fgets(STDIN));
        if(is_numeric($content_entered)){
            if(array_key_exists($index,$list_data)){
                $item_id=((int)$content_entered-1);
                $filename=$list_data[$index]['time'];

                $list_items_data = $this->load_file($filename);

                echo "> edit item [".$item_id."]".$list_items_data[$item_id]['content']."
                      \n enter new content ( this will replace what was previously there)\n";

                $o7=trim(fgets(STDIN));

                $this->update_at($filename,$item_id,$data=['content'=>$o7,'time'=>time()]);

                echo "\n\e[1;31;40m  Item updated \e[1;32;40m \n";
            }else{
                echo "\e[1;31;40m Item not found \e[1;32;40m\n";
            }

        }else {
            echo "\e[1;31;40m id not recognized/found \e[1;32;40m\n";
        }
    }

    public function delete_list_item($list_data,$index){
        echo "\e[1;31;40mEntering delete mode;
              \n > type the id you wish to delete \e[1;32;40m\n";
        $content_entered = trim(fgets(STDIN));
        if(is_numeric($content_entered)){
            if(array_key_exists($index,$list_data)){
                $item_id=((int)$content_entered-1);
                $filename=$list_data[$index]['time'];
                 $this->delete_from($filename, $item_id);

                echo "\n\e[1;31;40m  Item deleted \e[1;32;40m \n";
            }else{
                echo "\e[1;31;40m Item not found \e[1;32;40m\n";
            }

        }else {
            echo "\e[1;31;40m id not recognized/found \e[1;32;40m\n";
        }
    }
}