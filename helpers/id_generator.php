<?php
/**
 * Prefixed sequential ID generator (e.g., P10, M5, D7, S8, C14, SL_5).
 */

function generate_next_id(mysqli $con, string $table, string $column, string $prefix): string
{
    $allowedTables = [
        'patients' => 'p_id',
        'members' => 'm_id',
        'donor' => 'd_id',
        'sponsors' => 's_id',
        'cancers' => 'num',
        'salons' => 's_id',
    ];

    if (!isset($allowedTables[$table]) || $allowedTables[$table] !== $column) {
        throw new InvalidArgumentException('Unsupported table or column for ID generation.');
    }

    $maxNum = 0;
    $prefixLen = strlen($prefix);

    $res = mysqli_query($con, "SELECT `$column` FROM `$table`");
    if ($res) {
        while ($row = mysqli_fetch_row($res)) {
            $val = (string)$row[0];
            if (strpos($val, $prefix) === 0) {
                $num = (int)substr($val, $prefixLen);
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }
    }

    // For salons, also avoid colliding with existing salon usernames in `login`
    if ($table === 'salons') {
        $loginRes = mysqli_query($con, "SELECT `uname` FROM `login` WHERE `role` = 'salon'");
        if ($loginRes) {
            while ($row = mysqli_fetch_row($loginRes)) {
                $val = (string)$row[0];
                if (strpos($val, $prefix) === 0) {
                    $num = (int)substr($val, $prefixLen);
                    if ($num > $maxNum) {
                        $maxNum = $num;
                    }
                }
            }
        }
    }

    return $prefix . ($maxNum + 1);
}
