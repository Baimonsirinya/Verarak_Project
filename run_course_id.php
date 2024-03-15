<?php
include "connect.php";

$sql = "SELECT MAX(course_id) AS max_course_id FROM course";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$max_course_id = $row['max_course_id'];

if ($max_course_id) {
    $next_course_id = sprintf("%03d", intval($max_course_id) + 1);
    if ($next_course_id == 1000) {
        $next_course_id = "001";
    }
} else {
    $next_course_id = "001";
}

echo $next_course_id;
?>