<?php
/**
 * Created by PhpStorm.
 * User: onyebeadi.chimdindu
 * Date: 07/04/2020
 * Time: 22:24
 */
include_once 'dependency/listmenu.php';

function  main_menu(){
    system('cls');
    echo"\e[1;32;40m==========================================\n";
    echo"     \e[1;31;40m       TODO APPLICATION     \e[1;32;40m         \n";
    echo" ==========================================\n";
    echo "1-Create a Todo-list with items\n";
    echo "2-Show all Todo-list \n";
    echo "3-Show The Item In a list\n";
    echo "4-Delete list\n";
    echo "5-Delete a List Item\n";
    echo " -Enter Q or q to quit\n\n";
}


function lists_menu(){
    $list_view = true;
    $listObj = new list_menu();
    do{
        $listObj->print_list();
        $listObj->print_list_menu();
        $choice = $listObj->menu_option;

        switch ($choice) {
            case "C":
                $listObj->create_list();
                break;
            case "c":
                $listObj->create_list();
                break;
            case "D":
                $listObj->delete_list();
                break;
            case "d":
                $listObj->delete_list();
                break;
            case "E":
                $listObj->edit_list_name();
                break;
            case "e":
                $listObj->edit_list_name();
                break;
            case "P":
                $listObj->pin_unpin_list();
                break;
            case "p":
                $listObj->pin_unpin_list();
                break;
            case "R":
                $list_view = false;
                echo "Thank you... exiting list menu\n";
                break;
            case "r":
                $list_view = false;
                echo "Thank you... exiting list menu\n";
                break;
            case "V":
                $listObj->view_list_items();
                break;
            case "v":
                $listObj->view_list_items();
                break;
            default:
                echo "Your option wasn't found!\n";
        }
    }while($list_view);

}


do{
    $choice ="";
    main_menu();
    $choice = trim(fgets(STDIN));
    switch ($choice) {
        case "1":
            lists_menu();
            break;
        case "2":
            lists_menu();
            break;
        case "3":
            lists_menu();
            break;
        case "4":
            lists_menu();
            break;
        case "5":
            lists_menu();
            break;
        case "q":
            echo"Thank you, shutting down...\n";
            exit();
            break;
        case "Q":
            echo"Thank you, shutting down...\n";
            exit();
            break;
        default:
            echo "Your option wasn't found!\n";
    }
}while(!($choice === "Q" ) && !($choice === "q"));