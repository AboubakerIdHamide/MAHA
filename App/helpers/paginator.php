<?php

function paginator($totalRecords, $numberRecordsPerPage, $recordsName, $model, $method, $params = [])
{
	$totalPages = ceil($totalRecords / $numberRecordsPerPage);

	$page = strip_tags($_GET['page'] ?? '');
	if($page < 1 || $page > $totalPages) $page = 1;

	$offset = ($page - 1) * $numberRecordsPerPage;

	$records = call_user_func_array([$model, $method], array_merge([$offset], $params));

	return [
		'totalRecords' => (int) $totalRecords,
		'totalPages' => $totalPages,
		'currentPage' => (int) $page,
		'nextPage' => $page + 1 > $totalPages ? null : $page + 1,
		'prevPage' => $page - 1 === 0 ? null : $page - 1,
		$recordsName => $records,
	];
}