<style type="text/css">
    * {
        font-family: Helvetica, Arial, "WenQuanYi ZenHei", "LiHei Pro Medium", "Microsoft Yahei", "微软雅黑", "Microsoft JhengHei", STXihei, "华文细黑", SimHei, sans-serif !important;
    }
    body {
        font-size: 16px;
        color: #282828;
    }
    h1 {
        font-size: 60px;
    }
    h2 {
        font-size: 40px;
    }
    h3 {
        font-size: 32px;
    }
    h4 {
        font-size: 24px;
    }
    h5 {
        font-size: 16px;
    }
    h6 {
        font-size: 12px;
    }
    a, .highlightText{
        color: #98191D;
    }
    a:hover {
        color: #ca1937;
    }
    .subTitle {
        color: #8e8e8e;
    }
    .mtop {
        height: 0;
    }
    .head {
        background-color: transparent;
        box-shadow: none;
        height: 70px;
    }
    .head.showbg {
        background-color: #666;
        box-shadow: 1px 1px 10px 3px;
    }
    .Navbar a, .Navbar span{
        color: #FFF !important;
    }
    .banner-title {
        text-align: left;
        position: absolute;
        width: 90%;
        margin-left: 10%;
        top: 32%;
        color: #FFF;
    }
    .banner-btn {
        color: #98191D !important;
        border: 1px solid #98191D;
        padding: 10px 25px 10px 15px;
        border-radius: 20px;
        line-height: 60px;
        cursor: pointer;
    }
    .banner-btn:hover {
        border: 1px solid #ca1937;
        color: #ca1937 !important;
    }
    .banner .pic img.banner-btn-pic {
        width: 20px;
        margin-top: 19px;
        display: inline-block;
    }
    .banner {
        background: url(/images/img/img_01header.jpg) no-repeat center bottom;
        background-size: cover;
    }
   
</style>
<div class="banner">
    <div class="bannerBox">
        <div class="pic pic1">
            <div class="banner-title" style="">
                <h1>千锤百炼，惠聚于此</h1>
                <h3>We try our best to make every promise come true.</h3>
                <a href="http://keywayfund.com/about/detail" class="banner-btn">了解更多 <img class="banner-btn-pic" src="/images/img/ico_right_arrow.png?v=2"></a>
            </div>
        </div>
    </div>
    <span class="bannerLeft"> </span> <span class="bannerRight"> </span> 
</div>

<script type="text/javascript">
var show_svg = false;
window.onresize = function() {
    $('.banner').height(document.body.clientHeight);
};
$(document).ready(function () {
    $('.banner').height(document.body.clientHeight);
    setTimeout(function() {
        if($(window).scrollTop() - $('.pic1 img').height() > -50) {
            $('.head').addClass('showbg');
        }else {
            if($(window).scrollTop() > 300) {
                $('.head').addClass('showbg');
            }else {
                $('.head').removeClass('showbg');
            }
        }
    },100);
    $('svg').css('visibility','hidden');
    var svgs = {"quantitative-svg":false,"asset-svg":false,"innovation-svg":false,"fintech-svg":false};
    $(window).scroll(function () {
        if($(window).scrollTop() - $(window).height() > -50) {
            $('.head').addClass('showbg');
        }else {
            $('.head').removeClass('showbg');
        }
        if($(window).scrollTop() + $(window).height() - $('#quantitative-svg').offset().top > 200) {
            if(show_svg) {
                return ;
            }
            $('#quantitative-svg').css('visibility','visible');
            show_svg = true;
            new Vivus('quantitative-svg', {type: 'sync', duration: 50}, function() {
                svgs['quantitative-svg'] = true;
                $('#asset-svg').css('visibility','visible');
                new Vivus('asset-svg', {type: 'sync', duration: 50}, function() {
                    svgs['asset-svg'] = true;
                    $('#innovation-svg').css('visibility','visible');
                    new Vivus('innovation-svg', {type: 'sync', duration: 50}, function() {
                        svgs['innovation-svg'] = true;
                        $('#fintech-svg').css('visibility','visible');
                        new Vivus('fintech-svg', {type: 'sync', duration: 50}, function() {
                            svgs['fintech-svg'] = true;
                        })
                    })
                })
            });
        }
    });
    $('.one-detail').bind('mouseover', function(e) {
        var svg_id = $(e.target).closest('.one-detail').find('svg').attr('id');
        if(svgs[svg_id]) {
            svgs[svg_id] = false;
            new Vivus(svg_id, {type: 'sync', duration: 50}, function() {
                svgs[svg_id] = true;
            });
        }
    })
});
</script>

<!--banner end-->

<style type="text/css">
    .core-competence {
        min-height: 520px;
        width: 100%;
        padding-left: 75px;
        padding-top: 90px;
        padding-bottom: 50px;
        margin-top: 35px;
    }
    .left-box {
        position: relative;
        width: 40%;
        border: 4px solid #98191D;
        padding: 65px;
        text-align: center;
        background-color: transparent;
        z-index: 2;
    }
    .right-box {
        position: relative;
        width: 60%;
        margin-top: -480px;
        margin-left: 35%;
        height: 550px;
    }
    .right-box img {
        width: 100%;
        max-width: 638px;
        height: 550px;
    }
    .tilt__back, .tilt__front {
        height: 550px;
        background-size: cover;
    }
    .tilt__front {
        margin-top: -550px;
    }
</style>
<div class="auto-padding core-competence">
    <div class="left-box">
        <h2>多元化策略</h2>
        <img src="/images/img/ico_cross.png?v=2">
        <h2 class="highlightText">自主研发量化交易系统</h2>
        <h4 class="subTitle">核心竞争力</h4>
    </div>
    <div class="right-box">
        <img id="test" class="tilt-effect" src="/images/img/img_02slogan.jpg?v=2" alt="grid01" data-tilt-options='{ "opacity" : 0.5, "extraImgs" : 5, "movement": { "perspective" : 1200, "translateX" : -5, "translateY" : -5, "rotateX" : -5, "rotateY" : -5 } }'>
    </div>
</div>

<style type="text/css">
    .core-detail {
        text-align: center;
        z-index: 3;
        position: relative;
        height: 630px;
    }
    .detail-hr {
        border: 2px solid #98191D;
        width: 100px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 15px;
        margin-bottom: -20px;
        position: relative;
    }
    .detail-div {
        padding: 63px;
    }
    .one-detail {
        width: 25%;
        margin: 0;
        float: left;
        padding: 0 12px;
        cursor: pointer;
    }
    .one-detail-div {
        width: 100%;
        height: 315px;
        overflow: hidden;
    }
    .one-detail img {
        width: 100%;
        min-height: 315px;
        -webkit-filter: grayscale(100%) brightness(110%) contrast(105%);
        filter: grayscale(100%) brightness(110%) contrast(105%);
        transition: all 0.3s;
        -webkit-transition: all 0.3s, -webkit-filter 0.3s;
    }
    .one-detail:hover img {
        filter: none;
        min-height: 330px;
        width: 105%;
    }
    .one-detail-title {
        height: 170px;
        background-color: #FFF;
    }
    .one-back {
        background-color: #F8F8F8;
        height: 540px;
        position: absolute;
        width: 100%;
        margin-top: 280px;
    }
</style>
<div class="one-back">
    
</div>
<div class="auto-padding core-detail">
    <h2>走在金融科技前端</h2>
    <h4 class="subTitle">结合Fintech技术的交易及投资管理</h4>
    <div class="detail-hr" ></div>
    <div class="detail-div">
        <div class="one-detail">
            <div class="one-detail-div auto-height-img-div-1-2">
                <img src="/images/img/img_0301.jpg">
            </div>
            <div class="one-detail-title">
                <svg id="quantitative-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 80 80" enable-background="new 0 0 80 80" xml:space="preserve">
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M3.404,24.289c0,0,1.621,0.243,4.216-1.864v11.35"/>
                            <ellipse fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="17.349" cy="28.1" rx="3.892" ry="5.675"/>
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M3.404,58.015c0,0,1.621,0.243,4.216-1.864V67.5"/>
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M15.078,41.152c0,0,1.622,0.243,4.216-1.865v11.351"/>
                            <ellipse fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="17.349" cy="61.826" rx="3.892" ry="5.674"/>
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M25.562,58.015c0,0,1.622,0.243,4.216-1.864V67.5"/>
                            <ellipse fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="39.506" cy="61.826" rx="3.891" ry="5.674"/>
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M47.72,58.015c0,0,1.621,0.243,4.216-1.864V67.5"/>
                            <ellipse fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="6.971" cy="44.962" rx="3.891" ry="5.676"/>
                            <circle fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="43.277" cy="34.538" r="16.517"/>
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M75.559,59.563L62.044,46.049c2.062-3.354,3.271-7.286,3.271-11.511c0-12.172-9.866-22.038-22.037-22.038
                            S21.24,22.366,21.24,34.538c0,12.171,9.866,22.037,22.037,22.037c4.579,0,8.832-1.398,12.355-3.789l13.351,13.352
                            c1.816,1.816,4.761,1.816,6.575,0C77.374,64.323,77.374,61.379,75.559,59.563z"/>

                            <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="43.839" y1="22.665" x2="43.839" y2="44.716"/>
                        <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                            M49.828,28.1c0,0-1.288-2.521-6.015-2.521c-2.713,0-6.296,1.259-6.296,4.164c0,4.795,12.01,3.138,12.01,8.25
                            c0,2.006-2.906,3.664-5.714,3.664c-5.133,0-6.586-2.131-6.586-2.131"/>
                </svg>
                <h4>量化分析</h4>
                <h5>Quantitative Analysis</h5>
            </div>
        </div>
        <div class="one-detail">
            <div class="one-detail-div auto-height-img-div-1-2">
                <img src="/images/img/img_0302.jpg">
            </div>
            <div class="one-detail-title">
                <svg id="asset-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 80 80" enable-background="new 0 0 80 80" xml:space="preserve">
                    <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="63.08" y1="40.959" x2="63.08" y2="68.838"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M70.835,47.391c0,0-1.632-3.193-7.622-3.193c-3.437,0-7.978,1.595-7.978,5.276c0,6.076,15.219,3.977,15.219,10.455
                        c0,2.543-3.682,4.643-7.241,4.643c-6.504,0-8.346-2.7-8.346-2.7"/>
                    <polyline fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="
                    68.888,70 15.452,70 15.452,20.049       "/>
                    <polyline fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="
                    9.165,26.14 15.828,19.476 22.495,26.14      "/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                    M15.83,69.419c0,0,36.102-4.211,36.102-53.4"/>
                    <circle fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="62.76" cy="12.644" r="2.643"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                    M70.406,27.693V21.21c0,0-0.065-3.517-3.841-3.517s-6.97,0-6.97,0l-4.211,3.874l-3.28-4.964"/>
                    <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="63.406" y1="17.693" x2="63.406" y2="24.693"/>
                    <polyline fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="
                    67.406,23.693 67.406,27.693 60.406,27.693 60.406,23.693         "/>
                    <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="63.406" y1="27.693" x2="63.406" y2="37.693"/>
                    <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="60.406" y1="27.693" x2="60.406" y2="40.693"/>
                    <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="67.406" y1="27.693" x2="67.406" y2="40.693"/>
                    <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="57.272" y1="40.959" x2="68.888" y2="40.959"/>
                </svg>
                <h4>资产管理</h4>
                <h5>Asset Management</h5>
            </div>
        </div>
        <div class="one-detail">
            <div class="one-detail-div auto-height-img-div-1-2">
                <img src="/images/img/img_0303.jpg">
            </div>
            <div class="one-detail-title">
                <svg id="innovation-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 80 80" enable-background="new 0 0 80 80" xml:space="preserve">

                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M32.945,72.5c0,0,0.808-5.921-1.884-8.209c-2.691-2.288-4.71,0-6.056,0s-3.857-1.705-4.126-2.691
                        c-0.27-0.988-0.18-3.858-0.359-4.396c-0.179-0.539-1.436-0.449-1.346-0.898c0.09-0.448,0.439-3.32-0.005-3.589
                        c-0.443-0.269-3.045-0.358-3.045-1.973c0-1.615,1.48-3.364,2.422-4.307c0.942-0.942,2.153-2.602,2.153-4.666
                        c0-2.063-0.987-6.909,0.089-11.125c1.077-4.216,6.55-11.752,19.649-11.752c13.098,0,20.544,10.856,20.544,19.109
                        c0,8.254-4.396,12.92-5.921,15.342c-1.525,2.423-1.884,6.818-1.884,10.587c0,3.768,0.269,8.567,0.269,8.567"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M42.949,51.91c-1.156,0.154-2.113-1.256-2.985-1.256s-1.68,1.345-2.846,1.256c-1.167-0.09-1.884-2.692-3.23-2.602
                        c-1.346,0.09-3.5-0.449-3.589-0.987c-0.089-0.538-0.089-1.794-1.166-1.884s-2.063-2.872-1.525-3.589
                        c0.539-0.718-1.167-2.421-1.615-2.871c-0.449-0.448,0.897-3.141,1.167-3.589s-1.076-2.332-0.179-3.229
                        c0.896-0.897,2.063-1.256,2.422-1.167c0.358,0.09-0.089-3.151,0.807-3.415c0.897-0.264,3.23-0.174,3.23-1.071
                        s0.808-2.781,2.333-2.332c1.525,0.448,1.704,0.402,2.333-0.069c0.628-0.47,1.974-1.546,2.602-1.099
                        c0.627,0.449,1.077,1.794,1.525,1.794c0.449,0,2.422-1.077,2.961-0.539c0.538,0.539,1.884,3.578,2.153,3.314
                        c0.27-0.264,1.525-0.365,2.063,0c0.538,0.364,1.167,2.518,1.167,3.056s1.436,0.358,1.705,0.987
                        c0.27,0.628,1.346,3.319,0.628,3.947s1.113,3.678,0.243,4.576c-0.871,0.897-1.14,2.602-1.229,3.589s-2.333,1.704-2.781,1.794
                        c-0.449,0.09,0,2.692-0.718,3.14c-0.717,0.449-3.588-0.269-3.678,0.27S44.294,51.73,42.949,51.91z"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M39.181,47.065c0,0-0.539-2.961,0-3.678c0.538-0.718,2.333-3.41,3.14-3.768c0.808-0.359,2.333-0.18,2.961,0
                        c0.627,0.179,3.588,0.124,3.857-0.207c0.269-0.332,1.279-2.955,3.6-2.316"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M46.717,43.746c0,0-3.204,0.719-3.23,4.126c-0.009,1.19-3.248,0.096-3.248,0.096"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M30.252,47.968c0,0,0.854-3.685,2.738-2.787c1.884,0.896,3.333-2.754,5.973-1.019"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M31.465,42.031c0,0,0.27-2.072,0.897-1.957c0.628,0.116,2.068,1.158,2.245-1.623c0,0,2.689-1.166,2.958-2.153
                        c0.27-0.986,0-2.422,0-2.422s3.051,0,3.141-1.704c0,0,3.768,0.538,3.768-1.167c0-1.705,2.414-0.07,2.553-2.682"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M50.575,31.634c0,0-2.692,0.807-2.781,1.346c-0.089,0.539-0.539,2.062-1.077,2.197c-0.539,0.135-2.291,0.853-0.876,4.172"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M38.963,38.632c0,0,2.637-0.575,2.548,1.687"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M32.003,35.492c0,0,2.873,1.649,2.604,2.96"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M35.054,30.378c0,0-0.896,3.582,3.499,3.405"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
                        M38.104,25.106c0,0-0.628,3.656,0.449,4.016c1.077,0.359,3.04,0.989,2.333,2.512"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="40.078" y1="11.975" x2="40.078" y2="7.5"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="49.229" y1="13.421" x2="50.575" y2="9.115"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="57.199" y1="18.433" x2="60.264" y2="15.171"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="62.813" y1="24.688" x2="66.729" y2="22.519"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="30.798" y1="13.421" x2="29.45" y2="9.115"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="22.815" y1="18.433" x2="19.746" y2="15.171"/>

                        <line fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="17.192" y1="24.688" x2="13.271" y2="22.519"/>

                    </svg>
                <h4>研发创新</h4>
                <h5>Innovation</h5>
            </div>
        </div>
        <div class="one-detail">
            <div class="one-detail-div auto-height-img-div-1-2">
                <img src="/images/img/img_0304.jpg">
            </div>
            <div class="one-detail-title">
                <svg id="fintech-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 80 80" enable-background="new 0 0 80 80" xml:space="preserve">

                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M38,10.693V21.5
                        c0,0-8.866,1.5-8.866,8.667c0,7.333,5.15,9.166,8.817,10.333s6.992,3.125,6.992,6c0,1.667-1.837,4.167-5.337,4.167
                        S31.603,47.5,31.603,47.5l-3.01,5.833c0,0,3.407,3.5,8.407,3.167v8.193h-7"/>
                    <path fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M50,14.693h-7v6.474
                        c0,0,5.634,0.832,7.967,3.166L48.118,29.5c0,0-3.509-2.438-7.175-2.438s-4.191,2.937-4.191,4.271
                        c0,2.745,7.852,5.834,10.685,7.167s4.908,4.334,4.908,8.167C52.344,50.5,50,56.5,43,56.5v13.193"/>

                        <circle fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" cx="37.934" cy="7.833" r="2.667"/>

                        <circle fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" cx="52.702" cy="14.5" r="2.667"/>

                        <circle fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" cx="42.85" cy="72.167" r="2.667"/>

                        <circle fill="none" stroke="#98191D" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" cx="27.298" cy="64.5" r="2.667"/>

                    </svg>
                <h4>金融科技</h4>
                <h5>Fintech</h5>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .our-team {
        padding: 75px;
        text-align: left;
        z-index: 3;
        position: relative;
        height: 350px;
    }
    .team-left-box {
        width: 50%;
        float: left;
        overflow: hidden;
        height: 220px;
    }
    .team-right-box {
        float: right;
        margin-top: -170px;
        width: 55%;
        padding: 50px 8%;
        border: 4px solid #98191D;
    }
    .team-left-box img{
        width: 100%;
        min-height: 220px;
    }
</style>

<div class="auto-padding our-team">
    <div class="team-left-box">
        <img src="/images/img/img_04slogan.jpg">
    </div>
    <div class="team-right-box">
        <h2><font class="highlightText">稳健</font>高效<font class="highlightText">+</font>经验丰富</h2>
        <h4 class="subTitle">执着于追求卓越的领先团队</h4>
    </div>
</div>

<style type="text/css">
    .our-CEO {
        padding: 75px;
    }
    .CEO-pic{
        width: 35%;
        display: inline-block;
        vertical-align: top;
        height: 425px;
        overflow: hidden;
    }
    .CEO-pic img {
        width: 100%;
        min-height: 425px;
    }
    .CEO-info {
        width: 63%;
        padding-top: 30px;
        padding-left: 30px;
        display: inline-block;
        vertical-align: top;
    }
    .CEO-hr {
        border: 2px solid #98191D;
        width: 70px;
        margin-bottom: 45px;
        margin-top: 20px;
    }
    .CEO-info-body {
        background-color: #f9f9f9;
        padding: 50px;
    }
    .CEO-info-refer img {
        width: 55px;
    }
    .CEO-info-refer-img {
        display: inline-block;
        width: 90px;
        height: 80px;        
        border-right: 4px solid #98191D;
    }
    .CEO-info-refer-content {
        width: 100%;
        padding-right: 100px;
        margin-left: 100px;
        margin-top: -80px;
    }
    .CEO-info-refer-content .subTitle {
        text-align: right;
    }
    .CEO-info-detail {
        margin-top: 60px;
    }
    @media screen and (max-width: 767px) {
        .CEO-info-body {
            padding: 5px;
        }
        .CEO-info-refer img {
            width: 20px;
        }
        .CEO-info-refer-img {
            display: inline-block;
            width: 18px;
            height: 18px; 
            border-right: none;       
        }
        .CEO-info-refer-content {
            width: auto;
            padding: 0;
            margin: 0;
        }
        .one-back {
            display: none;
        }
    }
</style>
<div class="auto-padding our-CEO">
    <div class="CEO-pic auto-height-img-div-1-2">
        <img src="/images/img/img_04.jpg">
    </div>
    <div class="CEO-info">
        <div class="CEO-info-title">
            <h3>走进千惠</h3>
            <div class="CEO-hr"></div>
        </div>
        <div class="CEO-info-body">
            <div class="CEO-info-refer">
                <div class="CEO-info-refer-img">
                    <img src="/images/img/ico_quote.png?v=2">
                </div>
                <div class="CEO-info-refer-content">
                    调研、分析、测试、运行、调试……我们不介意重复，也不介意枯燥，仅想为每一位客户提供完美的投资方案。
                    <div class="subTitle">投资总监</div>
                </div>
            </div>
            <div class="CEO-info-detail">
                千惠的投资总监硕士毕业于新加坡南阳理工大学。曾就职于国际知名投资银行任职约15年，曾分别任职两家国内资本管理公司高层，花旗集团担任副主席，渣打银行、德意志银行重要部门。
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    protected {
        padding: 75px;
        background-color: #F8F8F8;
        height: 1060px;
    }
    protected-div {
        width: 100%;
    }
    .one-company-info {
        width: 33%;
        float: left;
        cursor: pointer;
        margin-bottom: 60px;
    }
    .one-company-info-left{
        padding-right: 3%;
    }
    .one-company-info-middle {
       padding-right: 1.5%;
       padding-left: 1.5%;
    }
    .one-company-info-right {
        padding-left: 3%;
    }
    .one-company-info-img {
        width: 100%;
        overflow: hidden;
        height: 270px;
    }
    .one-company-info-img img {
        width: 100%;
        min-height: 270px;
        background-size: cover;
        -webkit-filter: grayscale(100%) brightness(110%) contrast(105%);
        filter: grayscale(100%) brightness(110%) contrast(105%);
        transition: all 0.3s;
        -webkit-transition: all 0.3s, -webkit-filter 0.3s;
    }
    .one-company-info:hover img {
        filter: none;
        width: 105%;
        min-height: 300px !important;
    }
    .one-company-info-hr {
        border:2px solid #98191D;
        width: 50px;
        margin-bottom: 20px;
    }
    .one-company-info-subtitle {
        margin-bottom: 20px;
        height: 50px;
    }
</style>
<div class="auto-padding our-company">
    <div class="our-company-div">
        <div class="one-company-info one-company-info-left" onclick="window.location.pathname = 'about/detail'">
            <div class="one-company-info-title">
                <h4>公司概况</h4>
                <h5>Company Overview</h5>
                <div class="one-company-info-hr"></div>
                <div class="one-company-info-subtitle subTitle">
                    拥有领先的管理观念与国际视野，专注于量化投资领域。
                </div>
            </div>
            <div class="one-company-info-img auto-height-img-div-1-1">
                <img src="/images/img/img_0501.jpg">
            </div>
        </div>
        <div class="one-company-info one-company-info-middle" onclick="window.location.pathname = 'about/detail'">
            <div class="one-company-info-title">
                <h4>商业准则</h4>
                <h5>Business Principle</h5>
                <div class="one-company-info-hr"></div>
                <div class="one-company-info-subtitle subTitle">
                    只有致力于为客户创造价值，才能分享财富。
                </div>
            </div>
            <div class="one-company-info-img auto-height-img-div-1-1">
                <img src="/images/img/img_0502.jpg">
            </div>
        </div>
        <div class="one-company-info one-company-info-right" onclick="window.location.pathname = 'about/team'">
            <div class="one-company-info-title">
                <h4>基金经理</h4>
                <h5>Fund Manager</h5>
                <div class="one-company-info-hr"></div>
                <div class="one-company-info-subtitle subTitle">
                    任职世界知名投行多年，对资产运营、策略开发等各个方面，拥有丰富经验。
                </div>
            </div>
            <div class="one-company-info-img auto-height-img-div-1-1">
                <img src="/images/img/img_0503.jpg">
            </div>
        </div>
        <div class="one-company-info one-company-info-left" onclick="window.location.pathname = 'about/idea'">
            <div class="one-company-info-title">
                <h4>投资理念</h4>
                <h5>Investment Philosophy</h5>
                <div class="one-company-info-hr"></div>
                <div class="one-company-info-subtitle subTitle">
                    尊重客户，保护客户的利益是我们一直所坚持的理念。
                </div>
            </div>
            <div class="one-company-info-img auto-height-img-div-1-1">
                <img src="/images/img/img_0505.jpg">
            </div>
        </div>
        <div class="one-company-info one-company-info-middle" onclick="window.location.pathname = 'about/points'">
            <div class="one-company-info-title">
                <h4>社会责任</h4>
                <h5>Social Responsibility</h5>
                <div class="one-company-info-hr"></div>
                <div class="one-company-info-subtitle subTitle">
                    我们做的不只是财富增值，对社会，我们也承担着自己的责任。
                </div>
            </div>
            <div class="one-company-info-img auto-height-img-div-1-1">
                <img src="/images/img/img_0506b.jpg">
            </div>
        </div>
        <div class="one-company-info one-company-info-right"  onclick="window.location.pathname = 'contact/address'">
            <div class="one-company-info-title">
                <h4>联系我们</h4>
                <h5>Contact Us</h5>
                <div class="one-company-info-hr"></div>
                <div class="one-company-info-subtitle subTitle">
                    期待与你的联系。
                </div>
            </div>
            <div class="one-company-info-img auto-height-img-div-1-1">
                <img src="/images/img/img_0506.jpg">
            </div>
        </div>
    </div>
</div>

<style type="text/css">
     @media screen and (max-width: 1024px) {
        h1 {
            font-size: 32px;
        }
        h2 {
            font-size: 28px;
        }
        h3 {
            font-size: 21px;
        }
        h4 {
            font-size: 18px;
        }
        * {
            font-size: 14px;
        }
        .mobileBox {
            background-color: #000;
            color: #FFF;
            padding: 50px 10px;
            position: fixed;
        }
        .navMobile dd a:hover, .navMobile dd a.cur {
            background-color: #000;
            border-left: 4px solid #FFF;
        }
        .head.showbg {
            background-color:#000;
            height: 55px;
            filter:alpha(Opacity=80);-moz-opacity:0.8;opacity: 0.8;
        }
        .navMobile dd a {
            font-size: 22px;
            color: #FFF;
            border-left: 4px solid #000;
        }
        .logo{
            margin: 16px 0px 0px 20px;
            width: 240px;
        }
        .banner-title {
            margin-left: 50px;
        }
        .core-competence {
            padding: 40px 50px;
            margin: 0;
            margin-bottom: -20px;
        }
        .left-box {
            width: 100%;
            padding: 30px;
            margin-bottom: 40px;
        }
        .right-box{
            display: none;
            width: 100%;
            margin: 0;
        }
        .one-detail {
            width: 100%;
            margin-bottom: 30px;
        }
        .one-back {
            height: 980px;
        }
        .team-left-box {
            width: 100%;
            height: auto;
        }
        .team-right-box {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }
        .CEO-pic {
            display: none;
        }
        .CEO-info {
            width: 100%;
            padding: 0;
            margin-top: 20px;
        }
        .our-CEO, .our-team, .our-company {
            padding:40px 50px;
        }
        .detail-div {
            padding: 40px;
            padding-top: 60px;
        }
        .our-company {
            height: 3350px;
        }
        .one-company-info {
            width: 100%;
            padding: 0 !important;
        }
        .one-company-info-img {
            overflow: hidden;
            height: 400px;
        }
        .one-company-info:hover img {
            min-height: 410px;
        }
        .one-company-info img {
            min-height: 400px;
        }
        .foot {
            height:120px;
            font-size: 11px;
        }
        .foot .article-block {
            padding-left: 50px;
            width: 100%;
        }
        .foot .foot-btns {
            float: left;
            margin-left: 50px;
            margin-top: 10px;
            width: 100%;
        }
        .team-left-box img{
            width: 100%;
            min-height: 120px;
        }
        .animsition {
            width: 100%;
            overflow: hidden;
        }
        .one-detail-div {
            height: auto;
        }
        .one-detail img {
            height: auto;
            min-height: 100px;
        }
        .one-detail:hover img {
            height: auto;
            min-height: 100px;
            width: 100%;
            filter: none;
        }
    }
</style>
<script src="/js/bootstrap.min.js"></script> 
<script src="/js/vivus.min.js"></script>
<script src="/js/tiltfx.js"></script>