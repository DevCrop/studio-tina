<?php

class EtcModel
{
    public static function update($data)
    {
        $db = DB::getInstance();

        $sql = "
            UPDATE nb_etcs
            SET
                non_pay_last_modified = :non_pay_last_modified,
                banner_rolling_times = :banner_rolling_times
            LIMIT 1
        ";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':non_pay_last_modified' => $data['non_pay_last_modified'],
            ':banner_rolling_times' => $data['banner_rolling_times']
        ]);
    }
}