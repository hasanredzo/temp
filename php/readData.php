<?php
print "date,close\n";
$db = new SQLite3('/www/temp/control4.db') or die('Unable to open database');
$statement = $db->prepare('SELECT count(*) FROM temp');
$result = $statement->execute();
$row = $result->fetchArray();
$total = $row[0];

$statement = $db->prepare('SELECT * FROM temp LIMIT 50 OFFSET ?-50');
$statement->bindValue(1, $total, SQLITE3_INTEGER);
$result = $statement->execute();

while ($row = $result->fetchArray()) {
    $subtime = explode(' ',  $row['t']);
    print $subtime[1].",".($row['v']/1000)."\n";
}
$db->close();
?>