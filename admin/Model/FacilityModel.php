<?php

class FacilityModel
{
    public static function insert($data)
    {
        $db = DB::getInstance();
        $sql = "
            INSERT INTO nb_facilities (
                title, branch_id, categories, thumb_image,
                sort_no, is_active, created_at, updated_at
            ) VALUES (
                :title, :branch_id, :categories, :thumb_image,
                :sort_no, :is_active, NOW(), NOW()
            )
        ";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':title'      => $data['title'],
            ':branch_id'  => $data['branch_id'],
            ':categories' => $data['categories'],
            ':thumb_image'=> $data['thumb_image'],
            ':sort_no'    => $data['sort_no'],
            ':is_active'  => $data['is_active'],
        ]);
    }


	public static function bumpSortNosOnInsert(?int $branch_id = null, ?int $categories = null): void
	{
		$db = DB::getInstance();

		$where = [];
		$params = [];

		if ($branch_id !== null) {
			$where[] = 'branch_id = :branch_id';
			$params[':branch_id'] = $branch_id;
		}
		if ($categories !== null) {
			$where[] = 'categories = :categories';
			$params[':categories'] = $categories;
		}

		$sql = 'UPDATE nb_facilities SET sort_no = sort_no + 1'
			 . (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');

		$stmt = $db->prepare($sql);
		$stmt->execute($params);
	}

    public static function update($id, $data)
    {
        $db = DB::getInstance();

        $fields = [
            'title', 'branch_id', 'categories',
            'sort_no', 'is_active'
        ];

        if (!empty($data['thumb_image'])) $fields[] = 'thumb_image';

        $setClauses = array_map(fn($f) => "$f = :$f", $fields);
        $setClauses[] = "updated_at = NOW()";

        $sql = "UPDATE nb_facilities SET " . implode(", ", $setClauses) . " WHERE id = :id";
        $stmt = $db->prepare($sql);

        $data['id'] = $id;
        return $stmt->execute($data);
    }

    
    public static function delete($id)
    {
        $db = DB::getInstance();

        // 삭제 전 해당 레코드의 sort_no 가져오기
        $stmt = $db->prepare("SELECT sort_no FROM nb_facilities WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $sortNo = $stmt->fetchColumn();

        if ($sortNo === false) return false;

        // 삭제
        $stmt = $db->prepare("DELETE FROM nb_facilities WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if ($result) {
            // 삭제 후 sort_no 재조정
            $stmt = $db->prepare("
                UPDATE nb_facilities 
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
        $stmt = $db->prepare("SELECT sort_no FROM nb_facilities WHERE id IN (" . implode(', ', $placeholders) . ")");
        $stmt->execute($params);
        $sortNos = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($sortNos)) return false;

        $minSortNo = min($sortNos);
        $deletedCount = count($sortNos);

        // 삭제
        $sql = "DELETE FROM nb_facilities WHERE id IN (" . implode(', ', $placeholders) . ")";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute($params);

        if ($result) {
            // 삭제된 개수만큼 sort_no 감소
            $stmt = $db->prepare("
                UPDATE nb_facilities 
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
        $stmt = $db->prepare("SELECT * FROM nb_facilities WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public static function getMaxSortNo(): int
    {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT MAX(sort_no) FROM nb_facilities");
        return (int) $stmt->fetchColumn();
    }


    public static function shiftSortNosForUpdate(int $oldNo, int $newNo, int $id): void
    {
        $db = DB::getInstance();

        if ($newNo === $oldNo) return;

        if ($newNo < $oldNo) {
            $sql = "UPDATE nb_facilities SET sort_no = sort_no + 1 
                    WHERE sort_no >= :newNo AND sort_no < :oldNo AND id != :id";
        } else {
            $sql = "UPDATE nb_facilities SET sort_no = sort_no - 1 
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
        $stmt = $db->query("SELECT MIN(sort_no) FROM nb_facilities");
        return (int)$stmt->fetchColumn();
    }



}