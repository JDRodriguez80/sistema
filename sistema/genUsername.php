<?php
session_start();
    $fullName=$_GET['name'];

    $removedMultispace = preg_replace('/\s+/', ' ', $fullName);

    $sanitized = preg_replace('/[^A-Za-z0-9\ ]/', '', $removedMultispace);

    $lowercased = strtolower($sanitized);

    $splitted = explode(" ", $lowercased);

    if (count($splitted) == 1) {
        $username = substr($splitted[0], 0, rand(3, 6)) . rand(111111, 999999);
    } else {
        $username = $splitted[0] . substr($splitted[1], 0, rand(0, 4)) . rand(11111, 99999);
    }

    return $username;

?>
<input  value="<?php echo $username?>">
