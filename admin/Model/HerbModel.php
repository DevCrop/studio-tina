<?php
	class HerbModel
	{
		private const TABLE = 'nb_herb_inquiries';

		/** 단건 조회 */
		public static function find(int $id): ?array
		{
			$db = DB::getInstance();
			$stmt = $db->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
			$stmt->execute([':id' => $id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row ?: null;
		}

		/** 확인 필드 3종만 업데이트 */
		public static function updateConfirmFields(int $id, array $data): bool
		{
			$db = DB::getInstance();
			$sql = "UPDATE " . self::TABLE . "
					   SET is_confirmed = :is_confirmed,
						   confirm_by   = :confirm_by,
						   confirm_note = :confirm_note
					 WHERE id = :id";
			$stmt = $db->prepare($sql);
			return $stmt->execute([
				':is_confirmed' => (int)$data['is_confirmed'],
				':confirm_by'   => $data['confirm_by'],
				':confirm_note' => $data['confirm_note'],
				':id'           => $id,
			]);
		}
	}
?>