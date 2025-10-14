<?php

class SitemapBgModel
{
    /**
     * 모든 사이트맵 배경 이미지 조회
     */
    public static function getAllSitemapBackgrounds()
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT id, title, bg_image FROM nb_etcs ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 특정 title의 배경 이미지 조회
     */
    public static function getSitemapBackgroundByTitle($title)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT id, title, bg_image FROM nb_etcs WHERE title = :title");
        $stmt->execute([':title' => $title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 배경 이미지 업데이트
     */
    public static function updateSitemapBackground($title, $bg_image)
    {
        $db = DB::getInstance();
        
        $sql = "UPDATE nb_etcs SET bg_image = :bg_image WHERE title = :title";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':bg_image' => $bg_image,
            ':title' => $title
        ]);
    }

    /**
     * 여러 배경 이미지 업데이트
     */
    public static function updateMultipleSitemapBackgrounds($images)
    {
        $db = DB::getInstance();
        
        if (empty($images)) {
            return false;
        }

        $db->beginTransaction();
        
        try {
            foreach ($images as $title => $bg_image) {
                $sql = "UPDATE nb_etcs SET bg_image = :bg_image WHERE title = :title";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':bg_image' => $bg_image,
                    ':title' => $title
                ]);
            }
            
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
}