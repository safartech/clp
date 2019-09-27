@extends("default")
@section('css')
<style>

    *{box-sizing:border-box}

    /* Slideshow container */
    .slideshow-container {
        max-width: 1000px;
        /*max-height: 400px !important;*/
        position: relative;
        margin: auto;
    }

    /* Hide the images by default */
    .mySlides {
        display: none;
    }

    /* Next & previous buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
    }

    /* Caption text */
    .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .active, .dot:hover {
        background-color: #717171;
    }

    /* Fading animation */
    .fade {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
        from {opacity: .4}
        to {opacity: 1}
    }

    @keyframes fade {
        from {opacity: .4}
        to {opacity: 1}
    }

    /*.slider .indicators .indicator-item {*/
        /*background-color: #666666;*/
        /*-webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);*/
        /*-moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);*/
        /*box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);*/
    /*}*/
    /*.slider .indicators .indicator-item.active {*/
        /*background-color: #ffffff;*/
    /*}*/
    /*.slider {*/
        /*width: 100%;*/
        /*margin: 0 auto;*/
        /*height: 800px;*/
    /*}*/
    /*.slider .indicators {*/
        /*bottom: 60px;*/
        /*z-index: 100;*/
        /*!* text-align: left; *!*/
    /*}*/

</style>
@endsection

@section('js')
    <script type="text/javascript">
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}
            slides[slideIndex-1].style.display = "block";
            setTimeout(showSlides, 3000); // Change image every 2 seconds
        }
    </script>
    {{--<script type="text/javascript">--}}
        {{--var slideIndex = 1;--}}
        {{--showSlides(slideIndex);--}}

        {{--function plusSlides(n) {--}}
            {{--showSlides(slideIndex += n);--}}
        {{--}--}}

        {{--function currentSlide(n) {--}}
            {{--showSlides(slideIndex = n);--}}
        {{--}--}}

        {{--function showSlides(n) {--}}
            {{--var i;--}}
            {{--var slides = document.getElementsByClassName("mySlides");--}}
            {{--var dots = document.getElementsByClassName("dot");--}}
            {{--if (n > slides.length) {slideIndex = 1}--}}
            {{--if (n < 1) {slideIndex = slides.length}--}}
            {{--for (i = 0; i < slides.length; i++) {--}}
                {{--slides[i].style.display = "none";--}}
            {{--}--}}
            {{--for (i = 0; i < dots.length; i++) {--}}
                {{--dots[i].className = dots[i].className.replace(" active", "");--}}
            {{--}--}}
            {{--slides[slideIndex-1].style.display = "block";--}}
            {{--dots[slideIndex-1].className += " active";--}}
        {{--}--}}
        {{--setTimeout(showSlides, 4000);--}}
    {{--</script>--}}

@endsection

@section('content')

    <div id="homes">
        <div class="m-t-lg">
            <div class="row">

                {{--<div id="slider_container">--}}
                    <!-- Slideshow container -->
                    <div class="slideshow-container">

                        <!-- Full-width images with number and caption text -->
                        <div class="mySlides fade">
                            {{--<div class="numbertext">1 / 3</div>--}}
                            <img src="{{asset('assets/img/new CLP/14.jpg')}}" style="width:100%">
                        </div>

                        <div class="mySlides fade">
                            <img src="{{asset('assets/img/new CLP/11.jpg')}}" style="width:100%">
                        </div>

                        <div class="mySlides fade">
                            <img src="{{asset('assets/img/new CLP/15.jpg')}}" style="width:100%">
                        </div>

                        <!-- Next and previous buttons -->
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <br>

                    <!-- The dots/circles -->
                    <div style="text-align:center">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                    </div>

                </div>

        </div>

        {{--<div class="hidden-xs">--}}
            {{--<img class="img-thumbnail" style="" src="{{asset('images/welcome.jpg')}}"/>--}}
        {{--</div>--}}

        {{--<div class="hidden-lg hidden-md hidden-sm">--}}
            {{--<img class="img-thumbnail" style="" src="{{asset('images/welcomex.jpg')}}"/>--}}
        {{--</div>--}}

        <div class="m-t-lg">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 m-b-md">
                    <div class="inforide">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 rideone">
                                <img class="img-responsive" style="width: 200px" src="{{asset('images/teach.png')}}"/>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 fontsty">
                                <h4>Professeurs</h4>
                                <Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;" id="profs"></h1></strong>
                                {{--<Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;">@{{ profs }}</h1></strong>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 m-b-md">
                    <div class="inforide">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 ridetwo">
                                <img class="img-responsive" style="width: 200px" src="{{asset('images/students.png')}}"/>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 fontsty">
                                <h4>Elèves</h4>
                                <Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;" id="eleves"></h1></strong>
                                {{--<Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;">@{{ eleves }}</h1></strong>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 m-b-md">
                    <div class="inforide">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 ridethree">
                                <img class="img-responsive" style="width: 200px" src="{{asset('images/parents.png')}}"/>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 fontsty">
                                <h4>Parents</h4>
                                <Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;" id="parents"></h1></strong>
                                {{--<Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;">@{{ parents }}</h1></strong>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/vues/admin/home.js')}}"></script>
    {{--<script type="module" src="{{asset('js/vues/admin/home.js')}}"></script>--}}

{{--<home></home>--}}

@endsection