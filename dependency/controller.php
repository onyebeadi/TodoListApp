<?php
/**
 * Created by PhpStorm.
 * User: onyebeadi.chimdindu
 * Date: 08/04/2020
 * Time: 00:17
 */
class controller{
    public function load_file($file_name){
        $load_from = "store/".$file_name.".txt";
        if(file_exists($load_from)){
            $content = file_get_contents($load_from);
            if(strlen($content) == 0 ){
                return [];
            }else{
                return (array)json_decode($content,true);
            }
        }else{
            return [];
        }
    }

    public function rearrange($s){
        $d=[]; $w=0;
        foreach($s as $key => $values){
            $d[] = $values;
            $w++;
        }
        return $d;
    }

    public function update_at($file_name,$index,$data=[]){
        $oldData = $this->load_file($file_name);
        $oldData = $this->rearrange($oldData);
        if(is_array($oldData)){
            if(array_key_exists($index,$oldData)){
                $oldData[$index] = $data;
                $this->just_store($file_name,$oldData);
            }
        }
    }

    public function delete_from($file_name,$index){
        $oldData = $this->load_file($file_name);
        if(is_array($oldData)){
            if(array_key_exists($index,$oldData)){
                unset($oldData[$index]);
                $h = $this->rearrange($oldData);
                $this->just_store($file_name,$h);
            }
        }
    }

    public function just_store($file_name,$oldData){
        $load_from = "store/".$file_name.".txt";
        $current = json_encode($oldData);
        file_put_contents($load_from,$current);
        echo"\e[1;31;40m Saved Succesfully \e[1;32;40m\n";
    }

    public function store_and_reload($file_name,$data = []){
        $oldData = $this->load_file($file_name);
        $load_from = "store/".$file_name.".txt";

        if(file_exists($load_from)) {
            if (is_array($data)) {
                array_push($oldData, $data);
                $current = json_encode($oldData);
                file_put_contents($load_from, $current);
                echo "\e[1;31;40m Saved Succesfully \e[1;32;40m\n";
            } else {
                echo "Failed to save data\n";
            }
        }else{
            if(is_array($data)){
                array_push($oldData,$data);
                $current = json_encode($oldData);
                file_put_contents($load_from,$current);
                echo"\e[1;31;40m Saved Succesfully \e[1;32;40m\n";
            }else{
                echo"\e[1;31;40m failed to Save \e[1;32;40m\n";
            }
        }
        return $this->load_file($file_name);
    }

}