<?php

class DoctorModel
{
    public static function insert($data)
    {
        $db = DB::getInstance();
        $sql = "
            INSERT INTO nb_doctors (
                title, branch_id, position, department, keywords,
                career, activity, education,
                publication_visible, publications,
                thumb_image, detail_image,
                sort_no, is_active, is_ceo, created_at, updated_at
            ) VALUES (
                :title, :branch_id, :position, :department, :keywords,
                :career, :activity, :education,
                :publication_visible, :publications,
                :thumb_image, :detail_image,
                :sort_no, :is_active, :is_ceo, NOW(), NOW()
            )
        ";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':title'               => $data['title'],
            ':branch_id'           => $data['branch_id'],
            ':position'            => $data['position'],
            ':department'          => $data['department'],
            ':keywords'            => $data['keywords'],
            ':career'              => $data['career'],
            ':activity'            => $data['activity'],
            ':education'           => $data['education'],
            ':publication_visible' => $data['publication_visible'],
            ':publications'        => $data['publications'],
            ':thumb_image'         => $data['thumb_image'],
            ':detail_image'        => $data['detail_image'],
            ':sort_no'             => $data['sort_no'],
            ':is_active'           => $data['is_active'],
            ':is_ceo'              => $data['is_ceo'],
        ]);
    }


    public static function bumpSortNosOnInsert(?int $branch_id = null, ?string $department = null): void
    {
        $db = DB::getInstance();

        $where  = [];
        $params = [];

        if ($branch_id !== null) {
            $where[] = 'branch_id = :branch_id';
            $params[':branch_id'] = $branch_id;
        }
        if ($department !== null && $department !== '') {
            $where[] = 'department = :department';
            $params[':department'] = $department;
        }

        $sql = 'UPDATE nb_doctors SET sort_no = sort_no + 1'
             . (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
    }


    public static function update($id, $data)
    {
        $db = DB::getInstance();

        $fields = [
            'title', 'branch_id', 'position', 'department', 'keywords',
            'career', 'activity', 'education',
            'publication_visible', 'publications',
            'sort_no', 'is_active', 'is_ceo'
        ];

        if (!empty($data['thumb_image'])) $fields[] = 'thumb_image';
        if (!empty($data['detail_image'])) $fields[] = 'detail_image';

        $setClauses = array_map(fn($f) => "$f = :$f", $fields);
        $setClauses[] = "updated_at = NOW()";

        $sql = "UPDATE nb_doctors SET " . implode(", ", $setClauses) . " WHERE id = :id";
        $stmt = $db->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }


    public static function delete($id)
    {
        $db = DB::getInstance();

        // 삭제 전 해당 레코드의 sort_no 가져오기
        $stmt = $db->prepare("SELECT sort_no FROM nb_doctors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $sortNo = $stmt->fetchColumn();

        if ($sortNo === false) return false;

        // 삭제
        $stmt = $db->prepare("DELETE FROM nb_doctors WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if ($result) {
            // 삭제 후 sort_no 재조정
            $stmt = $db->prepare("
                UPDATE nb_doctors 
                SET sort_no = sort_no - 1 
                WHERE sort_no > :sortNo
            ");
            $stmt->execute([':sortNo' => $sortNo]);
        }

        return $result;
    }
    
    public static function deleteMultiple(array $ids)
    {
        if (empty($ids)) return false;

        $db = DB::getInstance();

        // 삭제 대상 ID 자리 표시자
        $placeholders = [];
        $params = [];
        foreach ($ids as $index => $id) {
            $key = ":id$index";
            $placeholders[] = $key;
            $params[$key] = (int)$id;
        }

        // 삭제 대상의 sort_no 가져오기
        $stmt = $db->prepare("SELECT sort_no FROM nb_doctors WHERE id IN (" . implode(', ', $placeholders) . ")");
        $stmt->execute($params);
        $sortNos = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($sortNos)) return false;

        $minSortNo = min($sortNos);
        $deletedCount = count($sortNos);

        // 삭제
        $sql = "DELETE FROM nb_doctors WHERE id IN (" . implode(', ', $placeholders) . ")";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute($params);

        if ($result) {
            // 삭제된 개수만큼 sort_no 감소
            $stmt = $db->prepare("
                UPDATE nb_doctors 
                SET sort_no = sort_no - :deletedCount 
                WHERE sort_no > :minSortNo
            ");
            $stmt->execute([
                ':deletedCount' => $deletedCount,
                ':minSortNo'    => $minSortNo
            ]);
        }

        return $result;
    }


    public static function find($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM nb_doctors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getMaxSortNo(): int
    {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT MAX(sort_no) FROM nb_doctors");
        return (int) $stmt->fetchColumn();
    }


    public static function shiftSortNosForUpdate(int $oldNo, int $newNo, int $id): void
    {
        $db = DB::getInstance();

        if ($newNo === $oldNo) return;

        if ($newNo < $oldNo) {
            $sql = "UPDATE nb_doctors SET sort_no = sort_no + 1 
                    WHERE sort_no >= :newNo AND sort_no < :oldNo AND id != :id";
        } else {
            $sql = "UPDATE nb_doctors SET sort_no = sort_no - 1 
                    WHERE sort_no > :oldNo AND sort_no <= :newNo AND id != :id";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':newNo' => $newNo,
            ':oldNo' => $oldNo,
            ':id'    => $id,
        ]);
    }

    public static function getMinSortNo(): int
    {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT MIN(sort_no) FROM nb_doctors");
        return (int)$stmt->fetchColumn();
    }



}