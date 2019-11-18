<?php

//alexmaina@afroscholar.info 18-11-2019
/**The code snippet below answers the following question posted 
on stackoverflow
https://stackoverflow.com/questions/58856118/group-by-date-range-in-mysql-and-php/58856724?noredirect=1#comment104025532_58856724


First and foremost the table *posts* was created as follows:
	CREATE TABLE posts(id int(11) not null auto_increment primary key, 
	post_date varchar(60), text varchar(40));

Secondly, insert data into the table:
	INSERT INTO posts(post_date, text)
	VALUES
    		('2019-11-10','xsomething'),
		('2019-11-10','ysomething'),
		('2019-11-11','ysomething'),
		('2019-11-12','ysomething'),
		('2019-11-13','xysomething'),
		('2019-01-01','xysomething'),
		('2019-01-05','xysomething'),
		('2019-01-06','ysomething'),
		('2019-01-10','xsomething'),
		('2019-01-11','ysomething');

The new table can be seen below.

+----+------------+-------------+
| id | post_date  | text        |
+----+------------+-------------+
|  1 | 2019-11-10 | xsomething  |
|  2 | 2019-11-10 | ysomething  |
|  3 | 2019-11-11 | ysomething  |
|  4 | 2019-11-12 | ysomething  |
|  5 | 2019-11-13 | xysomething |
|  6 | 2019-01-01 | xysomething |
|  7 | 2019-01-05 | xysomething |
|  8 | 2019-01-06 | ysomething  |
|  9 | 2019-01-10 | xsomething  |
| 10 | 2019-01-11 | ysomething  |
+----+------------+-------------+
Table1. posts


The task at hand requires us to build an associative array consisting of two distinctive 
two-dimensional arrays based on pre-defined date ranges.('2019-11-10' AND  '2019-11-13')
and ('2019-01-01' AND  '2019-01-15')
The first query we run is a MySQL CASE Statement(lines 59-65)**/

require 'data.php';
//connect to db
$con = dbconnect();

/**query table posts using CASE statements to get posts
whose dates fall within predefined date ranges..
https://www.sqlshack.com/case-statement-in-sql/
**/
 
$sql1 = "SELECT id AS post_id,text,post_date,  
	CASE 
		WHEN post_date BETWEEN '2019-11-10' AND  '2019-11-13' 
	THEN 1 
		WHEN post_date BETWEEN '2019-01-01' AND  '2019-01-15' 
	THEN 2 
		Else 1 END AS date_range_id FROM posts";

/**
The MySQL query above named $sql1 yields a table structure below:

+----+-------------+------------+---------------+
| id | text        | post_date  | date_range_id |
+----+-------------+------------+---------------+
|  1 | xsomething  | 2019-11-10 |             1 |
|  2 | ysomething  | 2019-11-10 |             1 |
|  3 | ysomething  | 2019-11-11 |             1 |
|  4 | ysomething  | 2019-11-12 |             1 |
|  5 | xysomething | 2019-11-13 |             1 |
|  6 | xysomething | 2019-01-01 |             2 |
|  7 | xysomething | 2019-01-05 |             2 |
|  8 | ysomething  | 2019-01-06 |             2 |
|  9 | xsomething  | 2019-01-10 |             2 |
| 10 | ysomething  | 2019-01-11 |             2 |
+----+-------------+------------+---------------+
Table2. posts table with a new additional field "date_range_id"



The next step is to loop through the results and create 
two-dimensional arrays based on "date_range_id".**/

$sth = $con->prepare($sql1);
	$sth->execute();
	$sth->SetFetchMode(PDO::FETCH_ASSOC);
	while ($row=$sth->fetch()){
		$date_range_id = $row['date_range_id'];
		//create two-dimensional array $array[] for date range '2019-11-10' AND  '2019-11-13'
		if($date_range_id == 1){
			$post_id = $row['post_id'];
			$text = $row['text'];
			$post_date = $row['post_date'];

			$array[] = [$post_id,$text,$post_date];
		}
		//create two-dimensional array $array5[] for date range '2019-01-01' AND  '2019-01-15'
		elseif($date_range_id == 2){
			$post_id = $row['post_id'];
			$text = $row['text'];
			$post_date = $row['post_date'];
			$array5[] = [$post_id,$text,$post_date];
		}

}


/**
The next step is to convert the two-dimensional arrays into
associative arrays.see https://www.geeksforgeeks.org/multidimensional-arrays-in-php/
https://stackoverflow.com/questions/5384847/adding-an-item-to-an-associative-array.
item'id' was added by simply typing "'id' => $x++," inside the array. Also note the variable $x set to 
1 and auto_increments.
**/
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

/**
Lastly, combine the two associative arrays $q and $r
**/
$post_range = [
	"'2019-11-10' AND '2019-11-13'" => $q,
	"'2019-01-01' AND '2019-01-11'" => $r];
echo "<pre>";print_r($post_range);echo "</pre>";


/**

The desired result can be seen below.
Lines 157-247 delivers the results below.

Array
(
    ['2019-11-10' AND '2019-11-13'] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [post_id] => 1
                    [text] => xsomething
                    [post_date] => 2019-11-10
                )

            [1] => Array
                (
                    [id] => 2
                    [post_id] => 2
                    [text] => ysomething
                    [post_date] => 2019-11-10
                )

            [2] => Array
                (
                    [id] => 3
                    [post_id] => 3
                    [text] => ysomething
                    [post_date] => 2019-11-11
                )

            [3] => Array
                (
                    [id] => 4
                    [post_id] => 4
                    [text] => ysomething
                    [post_date] => 2019-11-12
                )

            [4] => Array
                (
                    [id] => 5
                    [post_id] => 5
                    [text] => xysomething
                    [post_date] => 2019-11-13
                )

        )

    ['2019-01-01' AND '2019-01-11'] => Array
        (
            [0] => Array
                (
                    [id] => 6
                    [post_id] => 6
                    [text] => xysomething
                    [post_date] => 2019-01-01
                )

            [1] => Array
                (
                    [id] => 7
                    [post_id] => 7
                    [text] => xysomething
                    [post_date] => 2019-01-05
                )

            [2] => Array
                (
                    [id] => 8
                    [post_id] => 8
                    [text] => ysomething
                    [post_date] => 2019-01-06
                )

            [3] => Array
                (
                    [id] => 9
                    [post_id] => 9
                    [text] => xsomething
                    [post_date] => 2019-01-10
                )

            [4] => Array
                (
                    [id] => 10
                    [post_id] => 10
                    [text] => ysomething
                    [post_date] => 2019-01-11
                )

        )

)
**/


