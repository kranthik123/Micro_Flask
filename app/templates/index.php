<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Umbrella Delivery Services</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    </head>
    <style type="text/css">
        body{
        font-family: 'Nunito', sans-serif;
        }
        .bg-light {
        background-color: transparent;
        }
        #mainNav {
        border-color: rgba(34, 34, 34, .05);
        background-color: #fff;
        transition: all .35s;
        }
        #mainNav .navbar-nav>li>a {
        letter-spacing: 2px;
        /*color: #fff;*/
        }
        .navbar .nav-link {
        color: #fff;
        text-transform: uppercase;
        }
        .navbar-shrink .nav-link {
        color: #000 !important;
        }
        section{
        padding: 80px 0;
        }
        .logo {
        max-width: 100px;
        }
        .bg-primary{
        background: #7eba28 !important;
        }
        .max-450{
        max-width:450px;
        margin:auto;
        }
        @media screen and (min-width: 992px) {
        header.masthead {
        height: 100vh;
        padding-top: 0;
        padding-bottom: 0;
        }
        /*#mainNav {
        border-color: transparent;
        background-color: transparent;
        }*/
        #mainNav.navbar-shrink {
        border-color: rgba(34, 34, 34, .1);
        background-color: #fff;
        }
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
        }
        .animated {
        -webkit-animation-duration: 1s;
        animation-duration: 10s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        }
        @keyframes fadeIn {
        0% {
        opacity: 0;
        }
        100% {
        opacity: 1;
        }
        }
        .fadeIn {
        -webkit-animation-name: fadeIn;
        animation-name: fadeIn;
        }
        .errror_messagess{
        	display: none;
        }
        .errror_messagess span{
        	display: block;
        	font-size: 12px;
        	color: red;
        }
        #order{
        	display: none;
        }
        
    </style>
    <body id="page-top">
        <nav class="navbar navbar-expand-md navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href=""><img class="logo" src="./static/LOGO-TTC.png"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href=""><i class="fas fa-user"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="masthead">
            <div class="overlay"></div>
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-md-8 offset-md-2 my-auto">
                        <div class="text-center">
                            <h1 class="display-3 mt-4 animated fadeIn">Terrific Transport Corporation</h1>
                        </div>
                        <form class="my-4 max-450">
                            <div class="form-group">
                                <input type="text" class="form-control" name="address" id="address" placeholder="Current location: 5400 Airport Blvd, Boulder, CO 80301" value="Current location: 5400 Airport Blvd, Boulder, CO 80301" required>
                            </div>
                            <div class="form-group">
                                <select class="custom-select form-control form-control-lg" id="productselect" required>
                                    <option value="default">Select a product</option>
                                </select>
                                <div class="errror_messagess select_product_error">
                                	<span>Select Product</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="custom-select form-control form-control-lg" id="payinfo" required>
                                    <option value="default">Select Payment info</option>
                                    <option value="Card ending in 5678">Card ending in 5678</option>
                                    <option value="Add a new card">Add a new card</option>
                                </select>
                                <div class="errror_messagess select_payment_error">
                                	<span>Select Payment info</span>
                                </div>
                            </div>
                            <div class="text-center"> <a class="btn btn-primary js-scroll-trigger" id="test" href="">Request</a> </div>
                        </form>
                        <p id="infos"></p>
                    </div>
                </div>
            </div>
        </header>
        <section id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="text-center mb-4">
                            <h1 class="mb-4 animated fadeIn">About Umbrella Delivery!</h1>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe width="560" height="315" class="video" id="iummb" src="https://player.vimeo.com/video/317362936?autoplay=1" frameborder="0" allowfullscreen="allowfullscreen" class="video"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="order">
            <div class="container text-center">
                <h1 class="mb-4 animated fadeIn">My Order</h1>
                <img src="./static/process.png" class="img-fluid">
            </div>
        </section>
        <section id="contact">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="mb-4 animated fadeIn">Contact Us</h1>
                        <form class="description_form" onsubmit="alert('Case created');">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" id="description" name="text" required placeholder="Enter the description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <div class="text-center"><p>© Scaled Agile, Inc.  & © International Business Consultants LLC</p></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="./static/custom.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
        <script type="text/javascript">
            $("#test").click(function(e){
                e.preventDefault();
                if($("#productselect").val() != "default" && $("#payinfo").val() != "default"){
                    $("#test").attr("href", "#order");
                    $("#order").css({"display":"block","padding-top":"100px"});
                    $('html, body').animate({
		                scrollTop: $("#order").offset().top
		            }, 1000);
                }
                else{
                	if($("#productselect").val() == "default"){
                		$('.select_product_error').show()
                	}
                	if($("#payinfo").val() == "default"){
                		$('.select_payment_error').show()
                	}	
                }
            });
            $("#productselect" ).change(function() {
			  	if($(this).val() == "default"){
            		$('.select_product_error').show()
            	}
            	else{
            		$('.select_product_error').hide()	
            	}
			});
			$("#payinfo" ).change(function() {
			  	if($(this).val() == "default"){
            		$('.select_payment_error').show()
            	}
            	else{
            		$('.select_payment_error').hide()	
            	}
			});
        </script>
        <script type="text/javascript">
            $.getJSON("http://34.68.115.152/", function(data) {
                $.each( data, function( key, val ) {
                    $("#productselect").append("<option data-index='"+key+"' value='"+val+"'>"+val+"</option>")
                });
            });
        </script>
    </body>
</html>