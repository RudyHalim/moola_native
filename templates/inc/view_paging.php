<?php
$currentPage 	= isset($config['url']['querystring']['page']) ? (int)$config['url']['querystring']['page'] : 1;

$startPage 		= 1;
$endPage 		= $pagination->maxPage > $pagination->maxShowingPaging ? $pagination->maxShowingPaging : $pagination->maxPage;
$intervalPage 	= ceil($pagination->maxShowingPaging / 2);

// echo "$currentPage > $intervalPage";

if($currentPage > $intervalPage) {
	$endPage	= $currentPage + $intervalPage-1;
	if($endPage > $pagination->maxPage) {
		$endPage = $pagination->maxPage;
		$startPage = $endPage - $pagination->maxShowingPaging + 1;
	} else {
		$startPage 	= $currentPage - $intervalPage+1;
	}
}

$startPage		= $startPage < 1 ? 1 : $startPage;
$endPage		= $endPage > $pagination->maxPage ? $pagination->maxPage : $endPage;

$btn_first 		= $currentPage <= 1 ? "First" : "<a href='".$config['url']['querystring']['_url']."?page=1'>First</a>";
$btn_prev 		= $currentPage <= 1 ? "Prev" : "<a href='".$config['url']['querystring']['_url']."?page=".($currentPage-1)."'>Prev</a>";
$btn_next 		= $currentPage >= $pagination->maxPage ? "Next" : "<a href='".$config['url']['querystring']['_url']."?page=".($currentPage+1)."'>Next</a>";
$btn_last 		= $currentPage >= $pagination->maxPage ? "Last" : "<a href='".$config['url']['querystring']['_url']."?page=".$pagination->maxPage."'>Last</a>";

echo "<table id='pagination'><tr>";
	echo "<td>".$btn_first."</td>";
	echo "<td>".$btn_prev."</td>";

	for ($i=$startPage; $i <= $endPage; $i++) { 
		$btn_current = $currentPage == $i ? $i : "<a href='".$config['url']['querystring']['_url']."?page=".$i."'>".$i."</a>";
		echo "<td>".$btn_current."</td>";
	}

	echo "<td>".$btn_next."</td>";
	echo "<td>".$btn_last."</td>";
echo "</tr></table>";