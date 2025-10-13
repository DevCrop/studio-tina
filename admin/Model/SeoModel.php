<?php

class SeoModel
{
    public static function insert($data)
    {
        $db = DB::getInstance();

        $sql = "
            INSERT INTO nb_branch_seos 
                (path, page_title, meta_title, meta_description, meta_keywords)
            VALUES 
                (:path, :page_title, :meta_title, :meta_description, :meta_keywords)
        ";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':path'             => $data['path'],
            ':page_title'       => $data['page_title'],
            ':meta_title'       => $data['meta_title'],
            ':meta_description' => $data['meta_description'],
            ':meta_keywords'    => $data['meta_keywords'],
        ]);
    }

    public static function update($id, $data)
    {
        $db = DB::getInstance();

        $sql = "
            UPDATE nb_branch_seos
            SET
                path = :path,
                page_title = :page_title,
                meta_title = :meta_title,
                meta_description = :meta_description,
                meta_keywords = :meta_keywords,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':path'             => $data['path'],
            ':page_title'       => $data['page_title'],
            ':meta_title'       => $data['meta_title'],
            ':meta_description' => $data['meta_description'],
            ':meta_keywords'    => $data['meta_keywords'],
            ':id'               => $id
        ]);
    }

    public static function delete($id)
    {
        $db = DB::getInstance();

        $sql = "DELETE FROM nb_branch_seos WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public static function deleteMultiple(array $ids): bool
    {
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $db = DB::getInstance();
        $stmt = $db->prepare("DELETE FROM nb_branch_seos WHERE id IN ($placeholders)");

        return $stmt->execute($ids);
    }
}