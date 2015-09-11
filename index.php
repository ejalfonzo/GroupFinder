<!doctype html>
<html>
<head>
    <title>eBabilon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="/js/jquery.mobile-1.4.5.css"/>
    <link rel="stylesheet" type="text/css" href="/js/jquery.mobile.theme-1.4.5.css"/>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.css"/>
</head>
<body>

    <div data-role="page">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">
                <img alt="Brand" src="...">
              </a>
            </div>
          </div>
        </nav>
        <!-- <p class="navbar-text navbar-right">Signed in as <a href="#" class="navbar-link">Mark Otto</a></p> -->
        <div data-role="header" style="text-align: center;">
            <h1 style="text-align: center;">eBabilon</h1>
            <a href="#" data-role="button" data-icon="star" data-theme="a">Button</a>
        </div>

        <div data-role="content">
            <p>Welcome to Alpha 0</p>
            <ul data-role="listview" data-inset="true" data-filter="true">
                <li><a href="#">Acura</a></li>
                <li><a href="#">Audi</a></li>
                <li><a href="#">BMW</a></li>
                <li><a href="#">Cadillac</a></li>
                <li><a href="#">Ferrari</a></li>
            </ul>
            <form>
                <label for="slider-0">Input slider:</label>
                <input type="range" name="slider" id="slider-0" value="25" min="0" max="100" />
            </form>
        </div>

        <div data-role="footer">
            <h4>My Footer</h4>
            <a href="#" data-role="button" data-icon="star">Star button</a>
            <a href="#" data-role="button" data-icon="star">Star button</a>
            <a href="#" data-role="button" data-icon="star">Star button</a>
        </div>

    </div><!-- /page -->
    <script type="text/javascript" src="/js/jquery.mobile-1.4.5.min.js"></script>
    <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/button.js"></script>
    <script type="text/javascript" src="/js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script type="text/javascript" src="/js/bootstrap.min.js"></script> -->
</body>
</html>
