<?

	include_once "../../../../inc/lib/base.class.php";

	$table = 'nb_request';
	$sql = "select * from $table";


	$result = mysql_query($sql);
	$rows = array(); 

	$entity = array(
		'region' => '지역', 
		'country_name' => '국가',
		'company_name' => '업체명', 
		'prod_name' => '제품명',
		'category' => '카테고리',
		'title' => '제목',
		'contents' => '내용',
		'name' => '담당자',
		'email' => 'E-mail', 
		'regdate' => '날짜',
		'phone_number' => '전화',
		'fannels' => '컨텍경로(유입경로)',
		'should_response' => '회신여부',
	);

	while($row = mysql_fetch_assoc($result)){
		$newRow = array();
        
        foreach ($entity as $k => $v) {
            if (isset($row[$k])) {
                $value = $row[$k];
                if ($k === 'should_response') {
                    $value = $value == '1' ? 'O' : 'X';
                }
                $newRow[$v] = $value;
            }
        }
        
        $rows[] = $newRow;
	}
	

	echo json_encode(array(
		'result' => $rows,
	)); exit; 