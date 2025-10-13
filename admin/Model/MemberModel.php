<?php

class MemberModel {
    
    public static function updateStatus($id, $status)
    {
        $db = DB::getInstance();

        $sql = "UPDATE nb_users SET active_status = :status WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }


}