<!DOCTYPE html>
<html>

<head>
    <title>UNIMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('client/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/responsive.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div id="site">
        <div id="container">

            @include('client.components.header')
            <div id="main-content-wp" class="home-page clearfix">
                <div class="wp-inner">
                    @yield('content')
                </div>
            </div>
            @include('client.components.footer')
        </div>
        <div id="btn-top"><img src="public/client/images/icon-to-top.png" alt="" /></div>
        <div id="fb-root"></div>
    </div>
    <script src="{{ asset('client/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client/js/app.js') }}" type="text/javascript"></script>
  
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    {{-- //popup --}}
    {{-- <script>
        function showAddToCartModal() {
            $('#addToCartModal').modal('show');
            setTimeout(function() {
                $('#addToCartModal').modal('hide');
            }, 10000);
        }

        // document.getElementById("addToCartButton").addEventListener("click", function() {
        //     $('#addToCartModal').modal('show');
        // });
    </script> --}}
    <script>
       
       

        //cuộn content của detail product
        $(document).ready(function() {

            let product_wp = $('#post-product-wp').offset().top;
            $(".button-see").click(function() {
                //alert('ok');
                $(this).text($(this).text() == 'Xem thêm' ? 'Thu gọn' : 'Xem thêm');
                $(this).parent().toggleClass('active');
                if ($(this).text() == 'Xem thêm') {
                    $('html,body').animate({
                        scrollTop: product_wp
                    }, 500);
                }
            })

        
        });

        
    </script>
    @yield('address')
    
    
</body>

</html>
