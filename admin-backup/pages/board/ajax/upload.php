<?php 

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$root = trim($_SERVER['DOCUMENT_ROOT']);
$uploadDir = $root.'/uploads/board';
$uploadBaseDir = '/uploads/board';

$method = $_POST['_method'] ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
$method = strtolower($method);

$result = array(); 

if($method === 'post') {
    
    $ext = $_POST['extension'];
    
    if(isset($_FILES['file'])){
        $newName = uniqid() . '.' . $ext; 
        $uploadFile = $uploadDir . '/' . $newName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $jsonData = array(
                'filename' => $uploadBaseDir.'/'.$newName, 
                'success' => true
            );
        } else {
            $jsonData = array(
                'filename' => null, 
                'success' => false
            );
        }
    } else {
        $jsonData = array(
            'filename' => null, 
            'success' => false,
            'error' => 'File upload error'
        );
    }
}

if($method === 'delete'){
    $link = trim($_POST['link'],'/');
    
    if(file_exists($root.'/'.$link)){
        $result = unlink($root.'/'.$link);
        $jsonData = array('success' => $result);
    } else {
        $jsonData = array('success' => false);
    }
}

echo json_encode($jsonData);
