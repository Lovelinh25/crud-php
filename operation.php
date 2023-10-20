<?php

require_once("db.php");
require_once("operation.php");

$con=Createdb();

//click button

if(isset($_POST['create'])){
    createData();
}

if(isset($_POST['update'])){
    UpdateData();
}

if(isset($_POST['delete'])){
    deleteRecord();
}

if(isset($_POST['deleteall'])){
    deleteAll();
}


function createData(){
    $bookname=textboxValue("book_name");
    $bookpublisher=textboxValue("book_publisher");
    $bookprice=textboxValue("book_price");

    if($bookname && $bookpublisher && $bookprice){
        $sql="INSERT INTO books(book_name,book_publisher,book_price)
              Value('$bookname','$bookpublisher','$bookprice')";

    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("success","record successfully inserted..!");
        
    }else{
        echo "error";
    }
    }else{
        TextNode("error","provide data in the textbox");
    }
}

function textboxValue($value){
    $textbox=mysqli_real_escape_string($GLOBALS['con'],trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox;
    }
}

//messages

function TextNode($classname,$msg){
    $element="<h6 class='$classname'>$msg</h6>";
    echo $element;
}

//get data

function getData(){
    $sql="SELECT * FROM books";
    $result=mysqli_query($GLOBALS['con'],$sql);

    if(mysqli_num_rows($result)>0){
        return $result;
    }
}

//update data

function UpdateData(){
    $bookid=textboxValue("book_id");
    $bookname=textboxValue("book_name");
    $bookpublisher=textboxValue("book_publisher");
    $bookprice=textboxValue("book_price");

    if($bookname && $bookpublisher && $bookprice){
        $sql="
            UPDATE books SET book_name='$bookname',book_publisher='$bookpublisher',book_price='$bookprice' WHERE id='$bookid';
        ";

        if(mysqli_query($GLOBALS['con'],$sql)){
            TextNode("success","data successfully update");
        }else{
            TextNode("error","enable to update data");
        }
    }else{
        TextNode("error","select data using icon");
    }
}

//delete data

function deleteRecord(){
    $bookid=(int)textboxValue("book_id");

    $sql="DELETE FROM books WHERE id=$bookid";

    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("success","Record delete successfully");
    }else{
        TextNode("error","enable to delete");
    }
}

function deleteBtn(){
    $result=getData();
    $i=0;
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $i++;
            if($i>3){
                buttonElement("btn-deleteall","btn btn-danger","<i class='fas fa-trash'></i> deleteall","deleleall","");
                return;
            }
        }
    }
}

function deleteAll(){
    $sql="DROP TABLE books";
    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("sussecc","all record delete successfull");
        Createdb();
    }else{
        TextNode("error","something went strong record cannot delete");
    }
}

// set id to textbox
function setID(){
    $getid = getData();
    $id = 0;
    if($getid){
        while ($row = mysqli_fetch_assoc($getid)){
            $id = $row['id'];
        }
    }
    return ($id + 1);
}