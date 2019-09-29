<!doctype html>
<html lang="en">
<head>
    <title>Whoops!</title>
    <link rel="stylesheet" href="/css/style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>
    <link rel="manifest" href="/favicons/site.webmanifest"/>
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5"/>
    <link rel="shortcut icon" href="/favicons/favicon.ico"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="msapplication-config" content="/favicons/browserconfig.xml"/>
    <meta name="theme-color" content="#ffffff"/>

</head>
<body>
<div class="container">
    <div class="card my-5">
        <div class="card-header">
            <h2>Whoops! It looks like something went wrong.</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <h5>There was an error displaying this page.</h5>
                    <?php if(isset($exception) && $exception instanceof \Throwable) : ?>
                    <hr />
                    <pre>
<?php echo $exception->getMessage(); ?>
                    </pre>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/index.js"></script>
</body>
</html>