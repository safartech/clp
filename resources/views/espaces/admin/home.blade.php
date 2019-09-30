@extends("default")
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection

@section('js')
@endsection

@section('content')

    <div id="homes">
        <div class="m-t-lg" id="slideBox">
            <div class="slider">
                <ul class="slider-parent">
                    <li class="images-list" data-slider="1">
                        <img src="{{asset('assets/img/new CLP/14.jpg')}}">
                    </li>
                    <li class="images-list" data-slider="2">
                        <img src="{{asset('assets/img/new CLP/14.jpg')}}">
                    </li>
                    <li class="images-list" data-slider="3">
                        <img src="{{asset('assets/img/new CLP/14.jpg')}}">
                    </li>
                </ul>
                <ol class="buttom-circles">
                    <li class="buttom-circles-list slider-active" data-slider="1"><i class="fa fa-circle-thin"></i></li>
                    <li class="buttom-circles-list" data-slider="2"><i class="fa fa-circle-thin"></i></li>
                    <li class="buttom-circles-list" data-slider="3"><i class="fa fa-circle-thin"></i></li>

                </ol>
                {{--<i class="fa fa-chevron-right fa-5x"></i>--}}
                {{--<i class="fa fa-chevron-left fa-5x"></i>--}}
            </div>

        </div>

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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $(function () {
                "use strict";

                var slider          = $('.slider'),
                    sliderUl        = slider.find('.slider-parent'),
                    sliderUlLi      = sliderUl.find('.images-list'),
                    sliderOl        = slider.find('.buttom-circles'),
                    sliderOlLi      = sliderOl.find('.buttom-circles-list'),
                    sliderFaRight   = slider.find('> .fa:first-of-type'),
                    sliderFaLeft    = slider.find('> .fa:last-of-type'),
                    sliderTime      = 1000,
                    sliderWait      = 2000,
                    sliderSetInt,
                    resumeAndPause;

                sliderFaLeft.fadeOut();
                var parents=0
                var profs=0
                var eleves=0

                $('#parents').html(parents)
                $('#profs').html(profs)
                $('#eleves').html(eleves)

                function resetWH() {
                    slider.width(slider.parent().width()).height(slider.parent().width() * 0.5);
                    sliderUl.width(slider.width() * sliderUlLi.length).height(slider.height());
                    sliderUlLi.width(slider.width()).height(slider.height());
                }
                resetWH();

                function runSlider() {
                    if (sliderOlLi.hasClass('slider-active')) {
                        sliderUl.animate({
                            marginLeft: -slider.width() * ($('.slider-active').data('slider') - 1)
                        }, sliderTime);
                    }
                    if ($('.slider-active').is(':first-of-type')) {
                        sliderFaLeft.fadeOut();
                    } else {
                        sliderFaLeft.fadeIn();
                    }
                    if ($('.slider-active').next().is(':last-of-type')) {
                        sliderFaRight.fadeOut();
                    } else {
                        sliderFaRight.fadeIn();
                    }
                }

                function runRight() {
                    slider.each(function () {
                        $('.slider-active').next().addClass('slider-active').siblings().removeClass('slider-active');
                        runSlider();
                    });
                }

                function runLeft() {
                    slider.each(function () {
                        $('.slider-active').prev().addClass('slider-active').siblings().removeClass('slider-active');
                        runSlider();
                    });
                }

                sliderSetInt = function autoRunSlider() {
                    if ($('.slider-active').next().is(':last-of-type')) {
                        sliderUl.animate({
                            marginLeft: -sliderUlLi.width() * $('.slider-active').data('slider')
                        }, sliderTime, function () {
                            sliderUl.css('margin-left', 0);
                            sliderOlLi.first().addClass('slider-active').siblings().removeClass('slider-active');
                        });
                    } else {
                        runRight();
                    }
                };

                resumeAndPause = setInterval(sliderSetInt, sliderWait);


                $(window).on('resize', function () {
                    resetWH();
                });


                slider.each(function () {
                    sliderOlLi.click(function () {
                        $(this).addClass('slider-active').siblings().removeClass('slider-active');
                        runSlider();
                    });
                });

                sliderFaRight.on('click', function () {
                    runRight();
                });
                sliderFaLeft.on('click', function () {
                    runLeft();
                });

                slider.find('.fa').hover(function () {
                    clearInterval(resumeAndPause);
                }, function () {
                    resumeAndPause = setInterval(sliderSetInt, sliderWait);
                });

                var request = $.ajax({
                    url: "/ajax/load_admin_home",
                    type: "GET",
                   // dataType: "html"
                });

                request.done(function(response) {
                    console.log(response)
                    parents=response.parents
                    profs=response.profs
                    eleves=response.eleves

                    $('#parents').html(parents)
                    $('#profs').html(profs)
                    $('#eleves').html(eleves)
                });

                request.fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus );
                });
            });
        });
    </script>

@endsection