<!DOCTYPE html>
<html lang="en-gb" dir="ltr">
<head>
    <meta charset="utf-8" />
    <?php echo HTML::style('node_modules/bootstrap/dist/css/bootstrap.css'); ?>
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="container">
        <?php echo $content; ?>
    </div>
</body>