<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once('./config/config.php');
try{

    $non_validated=array(input($_POST['first_user_id']),input($_POST['second_user_id']),input($_POST['process']),input($_POST['winner_id']));
    $validated=array();
    
    if(empty($non_validated[0])){
        $data['message']="No first user id Found.";
        $data['status']=false;
        echo json_encode($data);
        exit();
    }else{
        array_push($validated,$non_validated[0]);
    }
    
    if(empty($non_validated[1])){
        $data['message']="No second user id found.";
        $data['status']=false;
    }else{
        array_push($validated,$non_validated[1]);
    }
    
    if(empty($non_validated[2])){
        $data['message']="No process found.";
        $data['status']=false;
        echo json_encode($data);
        exit();
    }else{
        array_push($validated,$non_validated[2]);
    }
    
    if(empty($non_validated[3])){
        $data['message']="No winner id found.";
        $data['status']=false;
    }else{
        array_push($validated,$non_validated[3]);
    }
    
    
    if(!empty($validated[0]) && (!empty($validated[2]) || !empty($validated[1]))){
        if(!empty($validated[0]) && ($validated[2]=='join' || $validated[1]=='join')){
            $checkSql = "SELECT `id`,`coin` FROM `cutie`.`game_user` WHERE `id`=:user_id ;";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bindParam(':user_id',$validated[0]);
            $result=$checkStmt->execute();
            $checkRowCount=$checkStmt->rowCount();
            $row = $checkStmt->fetch();
            if($checkRowCount >=1 && $row['coin']>=50){
                try{
                    $updateSql = "UPDATE `cutie`.`game_user` SET `coin`=`coin`-50,`hold_coin`=`hold_coin`+50 WHERE `id`=:user_id ;";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bindParam(':user_id',$validated[0]);
                    $result = $updateStmt->execute();
                    if($result){
                        $data['message']="Joined successfully.";
                        $data['status']=true;
                        echo json_encode($data);
                        exit();
                    }else{
                        $data['message']="Oops something went wrong.";
                        $data['status']=false;
                        echo json_encode($data);
                        exit();    
                    }
                }catch(PDOException $e){
                    $data['message']="Backend issue.";
                    $data['status']=false;
                    echo json_encode($data);
                    exit(); 
                }
            }else{
                $data['message']="Insufficent coin, please recharge now.";
                $data['status']=false;
                echo json_encode($data);
                exit();
            }
        }elseif(!empty($validated[0]) && !empty($validated[1]) && (!empty($validated[2]) && $validated[2]=="win") && !empty($validated[3])){
            try{
                $winSql = "UPDATE `cutie`.`game_user` SET `coin`=`coin`+`hold_coin`-10,`hold_coin`=0 WHERE `id`=:user_id";
                $winStmt = $conn->prepare($winSql);
                $winStmt->bindParam(':user_id',$validated[3]);
                $winResult = $winStmt->execute();
                $loseSql = "UPDATE `cutie`.`game_user` SET `hold_coin`=0 WHERE `id`=:user_id";
                $loseStmt = $conn->prepare($loseSql);
                $loseStmt->bindParam(':user_id',$validated[1]);
                $loseResult = $loseStmt->execute();
                if($winResult && $loseResult){
                    $data['message']="Result Updated, Match Finished.";
                    $data['status']=true;
                    echo json_encode($data);
                    exit();
                }else{
                    $data['message']="Data missing.";
                    $data['status']=false;
                    echo json_encode($data);
                    exit();    
                }
            }
            catch(PDOException $e){
                $data['message']=$e->getMessage();
                $data['status']=false;
                echo json_encode($data);
                exit(); 
            }
        }else{
            $data['message']="Data missing.";
            $data['status']=false;
            echo json_encode($data);
            exit();
        }
    }else{
        $data['message']="Main data not found.";
        $data['status']=false;
        echo json_encode($data);
        exit();
    }
}catch(Exception $f){
    $data['message']=$f->getMessage();
    $data['status']=false;
    echo json_encode($data);
    exit();
}

?>