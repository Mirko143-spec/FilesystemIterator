<?php
$sum_not_to_show = 0;

header("Content-type: text/html; charset=utf-8");
echo <<<STARTHTML
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filvisare</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { color: blue; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Filvisare</h1>
    <table>
        <tr>
            <th>Filnamn</th>
            <th>Storlek (bytes)</th>
            <th>Senast ändrad</th>
        </tr>
STARTHTML;

$it = new FilesystemIterator(dirname(__FILE__));

foreach ($it as $fileinfo) {
    $fname = $fileinfo->getFilename();
    $suffix = pathinfo($fname, PATHINFO_EXTENSION);

    if (!in_array($suffix, ["php", "html", "htm"])) {
        $sum_not_to_show++;
        continue;
    }

    $mtime = date("Y-m-d H:i:s", $fileinfo->getMTime());
    echo <<<ROW
        <tr>
            <td><a href="{$fname}">{$fname}</a></td>
            <td>{$fileinfo->getSize()}</td>
            <td>{$mtime}</td>
        </tr>
ROW;
}

echo <<<ENDHTML
    </table>
    <h2>Antal överhoppade filer</h2>
    <p>Antalet övriga filer i katalogen är {$sum_not_to_show}.</p>
</body>
</html>
ENDHTML;
?>