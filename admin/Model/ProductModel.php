<?php

class ProductModel
{
    public static function insert(array $data)
    {
        $db = DB::getInstance();
        $sql = "
            INSERT INTO nb_products (
                product_category_id, title, sub_title, description, url,
                feature, feature_desc,
                thumb_image, detail_image, banner_img,
                product_img_1, product_img_2, product_img_3, product_img_4, product_img_5,
                selected_variants, variant_specs,
                sort_no, is_active, created_at, updated_at
            ) VALUES (
                :product_category_id, :title, :sub_title, :description, :url,
                :feature, :feature_desc,
                :thumb_image, :detail_image, :banner_img,
                :product_img_1, :product_img_2, :product_img_3, :product_img_4, :product_img_5,
                :selected_variants, :variant_specs,
                :sort_no, :is_active, NOW(), NOW()
            )
        ";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':product_category_id' => $data['product_category_id'],
            ':title'               => $data['title'],
            ':sub_title'           => $data['sub_title'] ?? null,
            ':description'         => $data['description'] ?? null,
            ':url'                 => $data['url'] ?? null,
            ':feature'             => $data['feature'] ?? null,
            ':feature_desc'        => $data['feature_desc'] ?? null,
            ':thumb_image'         => $data['thumb_image'] ?? null,
            ':detail_image'        => $data['detail_image'] ?? null,
            ':banner_img'          => $data['banner_img'] ?? null,
            ':product_img_1'       => $data['product_img_1'] ?? null,
            ':product_img_2'       => $data['product_img_2'] ?? null,
            ':product_img_3'       => $data['product_img_3'] ?? null,
            ':product_img_4'       => $data['product_img_4'] ?? null,
            ':product_img_5'       => $data['product_img_5'] ?? null,
            ':selected_variants'   => $data['selected_variants'] ?? null,
            ':variant_specs'       => $data['variant_specs'] ?? null,
            ':sort_no'             => (int)$data['sort_no'],
            ':is_active'           => (int)$data['is_active'],
        ]);
    }

    public static function bumpSortNosOnInsert(): void
    {
        $db = DB::getInstance();
        $db->query("UPDATE nb_products SET sort_no = sort_no + 1");
    }

    public static function update(int $id, array $data)
    {
        $db = DB::getInstance();

        $fields = [
            'product_category_id',
            'title',
            'sub_title',
            'description',
            'url',
            'feature',
            'feature_desc',
            'selected_variants',
            'variant_specs',
            'sort_no',
            'is_active'
        ];

        $imageFields = [
            'thumb_image','detail_image','banner_img',
            'product_img_1','product_img_2','product_img_3','product_img_4','product_img_5'
        ];
        foreach ($imageFields as $f) {
            if (array_key_exists($f, $data) && $data[$f] !== null && $data[$f] !== '') {
                $fields[] = $f;
            }
        }

        $sets = array_map(fn($f) => "$f = :$f", $fields);
        $sets[] = "updated_at = NOW()";

        $sql = "UPDATE nb_products SET " . implode(", ", $sets) . " WHERE id = :id";
        $stmt = $db->prepare($sql);

        $params = [
            ':product_category_id' => $data['product_category_id'],
            ':title'               => $data['title'],
            ':sub_title'           => $data['sub_title'] ?? null,
            ':description'         => $data['description'] ?? null,
            ':url'                 => $data['url'] ?? null,
            ':feature'             => $data['feature'] ?? null,
            ':feature_desc'        => $data['feature_desc'] ?? null,
            ':selected_variants'   => $data['selected_variants'] ?? null,
            ':variant_specs'       => $data['variant_specs'] ?? null,
            ':sort_no'             => (int)$data['sort_no'],
            ':is_active'           => (int)$data['is_active'],
            ':id'                  => $id,
        ];
        foreach ($imageFields as $f) {
            if (in_array($f, $fields, true)) {
                $params[":$f"] = $data[$f] ?? null;
            }
        }

        return $stmt->execute($params);
    }

    public static function delete(int $id)
    {
        $db = DB::getInstance();

        $stmt = $db->prepare("SELECT sort_no FROM nb_products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $sortNo = $stmt->fetchColumn();
        if ($sortNo === false) return false;

        $stmt = $db->prepare("DELETE FROM nb_products WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if ($result) {
            $stmt = $db->prepare("UPDATE nb_products SET sort_no = sort_no - 1 WHERE sort_no > :s");
            $stmt->execute([':s' => $sortNo]);
        }
        return $result;
    }

    public static function deleteMultiple(array $ids)
    {
        if (empty($ids)) return false;

        $db = DB::getInstance();
        $ph = [];
        $params = [];
        foreach ($ids as $i => $v) {
            $k = ":id$i";
            $ph[] = $k;
            $params[$k] = (int)$v;
        }

        $stmt = $db->prepare("SELECT sort_no FROM nb_products WHERE id IN (" . implode(',', $ph) . ")");
        $stmt->execute($params);
        $sortNos = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (empty($sortNos)) return false;

        $minSortNo = min($sortNos);
        $deletedCount = count($sortNos);

        $stmt = $db->prepare("DELETE FROM nb_products WHERE id IN (" . implode(',', $ph) . ")");
        $result = $stmt->execute($params);

        if ($result) {
            $stmt = $db->prepare("
                UPDATE nb_products
                SET sort_no = sort_no - :cnt
                WHERE sort_no > :minNo
            ");
            $stmt->execute([
                ':cnt'   => $deletedCount,
                ':minNo' => $minSortNo
            ]);
        }
        return $result;
    }

    public static function find(int $id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM nb_products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getMaxSortNo(): int
    {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT MAX(sort_no) FROM nb_products");
        return (int)$stmt->fetchColumn();
    }

    public static function getMinSortNo(): int
    {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT MIN(sort_no) FROM nb_products");
        return (int)$stmt->fetchColumn();
    }

    public static function shiftSortNosForUpdate(int $oldNo, int $newNo, int $id): void
    {
        $db = DB::getInstance();
        if ($newNo === $oldNo) return;

        if ($newNo < $oldNo) {
            $sql = "UPDATE nb_products SET sort_no = sort_no + 1
                    WHERE sort_no >= :newNo AND sort_no < :oldNo AND id != :id";
        } else {
            $sql = "UPDATE nb_products SET sort_no = sort_no - 1
                    WHERE sort_no > :oldNo AND sort_no <= :newNo AND id != :id";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':newNo' => $newNo,
            ':oldNo' => $oldNo,
            ':id'    => $id,
        ]);
    }
}