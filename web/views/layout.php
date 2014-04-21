<html lang="ru" class="no-js index" dir="ltr"><!--<![endif]-->
    <head>
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <link href="/assets/bootstrap.css" type="text/css" rel="stylesheet">
        <script src="/assets/jquery.js" type="text/javascript"></script>
        <title><?php echo $this->title;?></title>
        <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon">
    </head>
    <body>
        <div class="navbar navbar-static">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <ul id="yw1" class="pull-right nav">
                        <?php foreach($this->menu() as $item): ?>
                            <li class="">
                                <a href="<?php echo $item['url'];?>"><?php echo $item['title'];?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>    
        <div class="container">
            <div class="text-center page-header">
                <h4><?php echo $this->title;?></h4>
            </div>
            <?php if($this->error): ?>
                <div class="alert"><?php echo $this->error;?></div>
            <?php endif;?>
            <div id="yw0"></div>    
            <div class="ajaxWrapper">
                <?php include_once $this->view; ?>
            </div>
        </div>
    </body>
</html>