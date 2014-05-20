<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Art-murals</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/purchasing.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=base_url(); ?>/manager/logout">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
        <h1 style="text-align: left;">Download image</h1>
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="imageId" class="col-sm-1 control-label">ID image</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="imageId" placeholder="id">
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-success" id="get_image">Get image</button>
                </div>
            </div>
        </form>
        <div class="row purchasing">
            <div class="col-sm-5">
                <img src="" alt="" id="searchImage" class="img-thumbnail">
            </div>
            <div class="col-sm-4 available-format">
                <label>Available formats</label>
                <ul id="available-formats" class="list-unstyled"></ul>
                <label id="currency_amount"></label>
                <div class="col-sm-12">
                    <label for="requiredDimension">Set required dimension size</label>
                    <input type="text" class="form-control" id="requiredDimension" style="display: inline-block">
                </div>
                <div class="col-sm-12" style="margin-top: 10px;">
                    <button type="button" class="btn btn-primary" id="purchase">Purchase</button>
                </div>
                <div class="col-sm-12" id="download-link">
                </div>
            </div>
            
        </div>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bigstock.js"></script>
  </body>
</html>
