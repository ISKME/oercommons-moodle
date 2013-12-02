<?php
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
$json = required_param('data', PARAM_RAW);

require_login();

$info = json_decode($json);

$url = '';
if (isset($info->url)) {
    $url = s(clean_param($info->url, PARAM_URL));
}

$filename = '';
if (isset($info->name)) {
    $filename  = s(clean_param($info->name, PARAM_FILE));
}

$thumbnail = '';
if (isset($info->thumbnail)) {
    $thumbnail = s(clean_param($info->thumbnail, PARAM_URL));
}

$author = '';
if (isset($info->owner)) {
    $author = s(clean_param($info->owner, PARAM_NOTAGS));
}

$license = '';
if (isset($info->license)) {
    $license = s(clean_param($info->license, PARAM_ALPHAEXT));
}

$js =<<<EOD
<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
    window.onload = function() {
        var resource = {};
        resource.title = "$filename";
        resource.source = "$url";
        resource.thumbnail = "$thumbnail";
        resource.author = "$author";
        resource.license = "$license";
        parent.M.core_filepicker.select_file(resource);
    }
    </script>
</head>
<body><noscript></noscript></body>
</html>
EOD;

header('Content-Type: text/html; charset=utf-8');
die($js);
