<?php
header("HTTP/1.1 200 OK");
header("Connection: close");
header("Content-Type: application/zip");
header("Content-Transfer-Encoding: binary");
header("Content-Length:" . filesize($pathToFile.$filename));
header("Content-Disposition: Attachment; filename={$filename}");

readfile($pathToFile.$filename);

