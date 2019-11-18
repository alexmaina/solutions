# Solutions
## Problem 1: How to group data by date range and creating a multi-imensional array based on these date ranges.

A question was raised in stack overflow on how to group records in a table by date_range and create a multi-dimensional array based on these groups.Here is the [question] (https://stackoverflow.com/questions/58856118/group-by-date-range-in-mysql-and-php/58856724#58856724)

The assumption is that the table schema in question looks like this(see table structure below named > posts):

Attempt | #1 | #2 | #3 | #4 | #5 | #6 | #7 | #8 | #9 | #10 | #11
--- | --- | --- | --- |--- |--- |--- |--- |--- |--- |--- |---
Seconds | 301 | 283 | 290 | 286 | 289 | 285 | 287 | 287 | 272 | 276 | 269

`
| id 	| post_date  	| text        	|
|----	|------------	|-------------	|
| 1  	| 2019-11-10 	| xsomething  	|
| 2  	| 2019-11-10 	| ysomething  	|
| 3  	| 2019-11-11 	| ysomething  	|
| 4  	| 2019-11-12 	| ysomething  	|
| 5  	| 2019-11-13 	| xysomething 	|
| 6  	| 2019-01-01 	| xysomething 	|
| 7  	| 2019-01-05 	| xysomething 	|
| 8  	| 2019-01-06 	| ysomething  	|
| 9  	| 2019-01-10 	| xsomething  	|
| 10 	| 2019-01-11 	| ysomething  	|
`
> Table1. posts

The desired results is an array with the following structure:

`Array
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

)`
