<?php
// index.php — MySQL test page that works whether DB->Query() returns mysqli_result or array
require_once "DB.php";
$DB = new DB();

/* ----------------- Helpers ----------------- */
function safeQuery($DB, $sql)
{
    try {
        return [$DB->Query($sql), null];
    } catch (Throwable $e) {
        return [false, $e->getMessage()];
    }
}

function resultToRows($res)
{
    // If mysqli_result => fetch all rows
    if ($res instanceof mysqli_result) {
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }
    // If already array of rows
    if (is_array($res)) {
        // Normalize: allow [] or [assoc, assoc, ...]
        if (empty($res))
            return [];
        // Some wrappers may return ['data'=>[...]] – try to unwrap
        if (isset($res['data']) && is_array($res['data']))
            return $res['data'];
        // If the first element is an array, assume it's rows
        if (is_array(reset($res)))
            return $res;
        // Single row assoc (rare)
        return [$res];
    }
    // Unknown type
    return [];
}

function firstRow($res)
{
    $rows = resultToRows($res);
    return $rows[0] ?? [];
}

function renderRowsTable(array $rows)
{
    if (empty($rows)) {
        echo '<div class="text-muted">ไม่มีข้อมูล</div>';
        return;
    }
    $headers = array_keys($rows[0]);
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr>';
    foreach ($headers as $h)
        echo '<th>' . htmlspecialchars($h) . '</th>';
    echo '</tr></thead><tbody>';
    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($headers as $h) {
            $val = $row[$h] ?? null;
            echo '<td>' . htmlspecialchars((string) ($val === null ? 'NULL' : $val)) . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
}

/* ----------------- Queries ----------------- */
// 1) ชื่อฐานข้อมูลปัจจุบัน
list($rsDb, $errDb) = safeQuery($DB, "SELECT DATABASE() AS dbname");
$currentDbRow = firstRow($rsDb);
$currentDb = $currentDbRow['dbname'] ?? '(unknown)';

// 2) รายชื่อตารางย่อ (เช็คว่าอยู่ฐานที่ต้องการหรือไม่)
list($rsTables, $errTables) = safeQuery(
    $DB,
    "SELECT TABLE_NAME AS name 
     FROM INFORMATION_SCHEMA.TABLES 
     WHERE TABLE_SCHEMA = DATABASE() 
     ORDER BY TABLE_NAME LIMIT 20"
);
$tables = resultToRows($rsTables);

// 3) โครงสร้างคอลัมน์ของตาราง hello
list($rsCols, $errCols) = safeQuery($DB, "SHOW COLUMNS FROM `hello`");
$cols = resultToRows($rsCols);

// 4) ข้อมูลในตาราง hello (สูงสุด 50 แถว)
list($rsHello, $errHello) = safeQuery($DB, "SELECT * FROM `hello` LIMIT 50");
$helloRows = resultToRows($rsHello);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>DB Test: appdb.hello</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h1 class="mb-3">ทดสอบ DB.php (MySQL) — ตาราง <code>hello</code></h1>

        <div class="mb-3">
            <span class="badge bg-primary">Database: <?= htmlspecialchars($currentDb) ?></span>
        </div>

        <h5>ตารางในฐานข้อมูล (บางส่วน)</h5>
        <?php if ($tables): ?>
            <ul>
                <?php foreach ($tables as $t): ?>
                    <li<?= (isset($t['name']) && $t['name'] === 'hello') ? ' style="font-weight:bold;color:#0d6efd;"' : '' ?>>
                        <?= htmlspecialchars($t['name'] ?? '') ?>
                        </li>
                    <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-warning">
                ไม่สามารถดึงรายชื่อตารางได้<?= $errTables ? ': ' . htmlspecialchars($errTables) : '' ?>
            </div>
        <?php endif; ?>

        <hr>

        <h4 class="mt-4">โครงสร้างตาราง <code>hello</code></h4>
        <?php if ($cols): ?>
            <?php renderRowsTable($cols); ?>
        <?php else: ?>
            <div class="alert alert-danger">
                ไม่พบตาราง <code>hello</code> หรือดึงโครงสร้างไม่ได้<?= $errCols ? ': ' . htmlspecialchars($errCols) : '' ?>
            </div>
        <?php endif; ?>

        <h4 class="mt-4">ข้อมูลจาก <code>hello</code> (สูงสุด 50 แถว)</h4>
        <?php if ($helloRows): ?>
            <?php renderRowsTable($helloRows); ?>
        <?php else: ?>
            <div class="alert alert-info">
                ไม่มีข้อมูลในตาราง หรืออ่านไม่ได้<?= $errHello ? ': ' . htmlspecialchars($errHello) : '' ?>
            </div>
        <?php endif; ?>

        <hr>
        <p class="text-muted small">
            ถ้าต้องการให้หน้าทดสอบนี้ “เพิ่มข้อมูลลงตาราง hello” ได้ด้วย บอกชื่อคอลัมน์ (เช่น <code>id</code>,
            <code>msg</code>, <code>created_at</code>)
            เดี๋ยวผมเพิ่มฟอร์ม Insert/Update ให้ตรงกับสคีมาจริงครับ
        </p>
    </div>
</body>

</html>