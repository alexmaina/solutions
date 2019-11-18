<?php
require 'data.php';
//connect to db
$con = dbconnect();

/**query table posts using CASE statements to get posts
whose dates fall within predefined date ranges.
https://www.sqlshack.com/case-statement-in-sql/
**/
 
$sql1 = "SELECT id AS post_id,text,post_date,  
	CASE 
		WHEN post_date BETWEEN '2019-11-10' AND  '2019-11-13' 
	THEN 1 
		WHEN post_date BETWEEN '2019-01-01' AND  '2019-01-15' 
	THEN 2 
		Else 1 END AS date_range_id FROM posts";
$sth = $con->prepare($sql1);
	$sth->execute();
	$sth->SetFetchMode(PDO::FETCH_ASSOC);
	while ($row=$sth->fetch()){
		//$post_id = $row['post_id'];
		//$text = $row['text'];
		//$post_date = $row['post_date'];
		$date_range_id = $row['date_range_id'];

		if($date_range_id == 1){
			$post_id = $row['post_id'];
			$text = $row['text'];
			$post_date = $row['post_date'];

			$array[] = [$post_id,$text,$post_date];
		}
		elseif($date_range_id == 2){
			$post_id = $row['post_id'];
			$text = $row['text'];
			$post_date = $row['post_date'];
			$array5[] = [$post_id,$text,$post_date];
		}

}
//adding an item to an associative array
//https://stackoverflow.com/questions/5384847/adding-an-item-to-an-associative-array
$x= 1;
//create an associative array  $q of $array[]
foreach($array as $y => $z){
	$q[] = ['id' => $x++,
		'post_id'=>$z[0],
		'text' =>$z[1],
		'post_date' => $z[2]
];

}

//create an associative array $r of $array5[]

foreach($array5 as $y => $z){
	$r[] = ['id' => $x++,
		'post_id'=>$z[0],
		'text' =>$z[1],
		'post_date' => $z[2]];

	//$r += ['id' => $x++];
}
//
//echo "<pre>";print_r($r);echo "</pre>";
//create associative array based on date ranges using $q and $r
$post_range = [
	"'2019-11-10' AND '2019-11-13'" => $q,
	"'2019-01-01' AND '2019-01-11'" => $r];
echo "<pre>";print_r($post_range);echo "</pre>";


