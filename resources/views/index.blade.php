@php
$currentLang = request()->get('lang', 'ar');
app()->setLocale($currentLang);
@endphp
<!DOCTYPE html>
<html dir="{{ $currentLang == 'ar' ? 'rtl' : 'ltr' }}" class="no-js">

<head>
    <meta charset="utf-8">
    <meta content="text/html; charset=windows-1256" http-equiv="Content-Type">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ $setting->site_name ?? 'ميو فلات - تصميم ذي الصفحة الواحدة' }}</title>
    <meta name="viewport" content="width=device-width">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ $setting && $setting->favicon ? asset($setting->favicon) : asset('icon/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('icon/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('icon/apple-touch-icon-57x57.html') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('icon/apple-touch-icon-72x72.html') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('icon/apple-touch-icon-114x114.html') }}" />

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>

    <!-- Base Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" class="alt" href="{{ asset('css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_fixes.css') }}">
    <style>
        #top-banner { width: 100%; display: block; max-height: 150px; overflow: hidden; }
        #top-banner img { width: 100%; height: 150px; object-fit: cover; display: block; }
        #header { position: sticky; top: 0; z-index: 999; background: #fff; }
        
        /* Except top-banner which needs to be full width */
        #top-banner img { width: 100% !important; }
    </style>

</head>

<body>

@if($setting && $setting->top_banner)
<div id="top-banner">
    <img src="{{ asset($setting->top_banner) }}" alt="Banner">
</div>
@endif



<div id="pageloader">
    <div class="loader-item">
        <img src="{{ asset('images/loader-dark.gif') }}" alt='loader' />
    </div>
</div>

<!-- Header -->
<header id="header">
    <!-- Top Bar -->
    <section id="top-bar">&nbsp;</section>
    <!-- Top Bar End -->

    <!-- Logo -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center w-12">
                    <a href="{{ route('login') }}" class="logo"><img style="width: 100px;" src="{{ $setting && $setting->logo ? asset($setting->logo) : asset('images/logo.png') }}" alt="{{ $setting->site_name ?? 'Logo' }}"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Logo End -->

    <!-- Navigation -->
    <div class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="home"><a href="#" class="selected scroll-link" data-id="home">{{ __('menu.home') }}</a></li>
                    <li><a href="#" class="scroll-link" data-id="about">{{ __('menu.about') }}</a></li>
                    <li><a href="#" class="scroll-link" data-id="services">{{ __('menu.services') }}</a></li>
                    <li><a href="#" class="scroll-link" data-id="portoflio">{{ __('menu.portfolio') }}</a></li>
                    <li><a href="#" class="scroll-link" data-id="blog">{{ __('menu.blog') }}</a></li>
                    <li><a href="#" class="scroll-link" data-id="contact">{{ __('menu.contact') }}</a></li>
                    <li><a href="/?lang=ar" onclick="window.location.href='/?lang=ar'; return false;" class="lang-switcher {{ $currentLang == 'ar' ? 'selected' : '' }}">العربية</a></li>
                    <li><a href="/?lang=en" onclick="window.location.href='/?lang=en'; return false;" class="lang-switcher {{ $currentLang == 'en' ? 'selected' : '' }}">English</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <!-- Navigation End -->
</header>

<!-- Header End -->

<!-- News Ticker -->
@if($timelines->count() > 0)
<div class="news-ticker-wrapper" style="overflow: hidden; border-bottom: 3px solid transparent; direction: ltr;">
    <div class="news-ticker" style="white-space: nowrap; display: inline-block; animation: ticker 30s linear infinite; padding-left: 100%;">
        @foreach($timelines as $timeline)
            <span class="news-item" style="display: inline-block; padding: 10px 30px; font-family: 'Cairo', sans-serif, 'Raleway'; font-size: 16px;">
                <a href="#" style="text-decoration: none;">
                    {{ $timeline->year }} - {{ $timeline->title }} <i class="fa fa-newspaper-o" style="margin-left: 5px;"></i>
                </a>
            </span>
        @endforeach
    </div>
</div>
<style>
@keyframes ticker {
    0% { transform: translate3d(0, 0, 0); }
    100% { transform: translate3d(-100%, 0, 0); }
}
</style>
<script>
    function syncTickerWithTheme() {
        // Get 'reference' colors from the theme elements
        var topBarColor = window.getComputedStyle(document.querySelector('#top-bar')).backgroundColor;
        var primaryColor = window.getComputedStyle(document.querySelector('.selected') || document.querySelector('a')).color;
        
        // Use the 'primary' color (often Red #e74c3c) for the ticker background to make it stand out like #top-bar
        // Or follow user request: "footer of timeline" -> maybe dark background?
        // But user said "like the rest". #top-bar is background color.
        
        // Let's use #top-bar background color for Ticker Background? 
        // Actually #top-bar is usually the colored strip.
        // Let's use a Dark Background (hardcoded or from footer?) and use the Theme Color for Text/Border.
        // The Footer has background #303030 (Dark).
        
        var footerBg = window.getComputedStyle(document.querySelector('footer .copyright') || document.querySelector('footer')).backgroundColor;
        
        // Apply to Ticker
        var tickerWrapper = document.querySelector('.news-ticker-wrapper');
        if(tickerWrapper) {
            tickerWrapper.style.backgroundColor = 'rgba(30, 30, 30, 0.9)'; // Keep it dark like footer
            tickerWrapper.style.borderBottomColor = topBarColor; // Use theme color for border
            
            var items = document.querySelectorAll('.news-item a');
            items.forEach(function(item) {
                item.style.color = '#fff'; // White text
                var icon = item.querySelector('i');
                if(icon) icon.style.color = topBarColor; // Icon matches theme
            });
        }
    }

    // Run on load and whenever style switcher is clicked
    window.addEventListener('load', syncTickerWithTheme);
    document.addEventListener('DOMContentLoaded', syncTickerWithTheme);
    
    // Observer for style changes (if switcher doesn't trigger event directly)
    // Or just hook into the switcher click if possible.
    // For now, simple interval check or hook into .styleswitcher clicks
    var switchers = document.querySelectorAll('.styleswitcher a');
    if(switchers) {
        for(var i=0; i<switchers.length; i++) {
             switchers[i].addEventListener('click', function() {
                 setTimeout(syncTickerWithTheme, 100); // Wait for CSS swap
             });
        }
    }
</script>
@endif
<!-- News Ticker End -->

<div class="clearfix"></div>
<!-- Slider -->
<section id="home" class="slider-bg">
    <div class="page-slider-wrap">
        <div id="page-slider" >
            <ul>
                @foreach($slides as $slide)
                <!-- SLIDE  -->
                <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >

                    <!-- MAIN IMAGE -->
                    <img src="{{ asset($slide->image) }}"  alt="{{ $slide->title }}"  data-bgfit="scroll" data-bgposition="top center" data-bgrepeat="no-repeat">

                    <!-- LAYER NR. 1 -->
                    @if($slide->title)
                    <div class="tp-caption slider-title customin customout"
                         data-x="center"
                         data-y="30"
                         data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                         data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-speed="1000"
                         data-start="500"
                         data-easing="Back.easeInOut"
                         data-endspeed="300"
                         style="color:#fff;font-family:HelveticaNeueLTW20;">{!! nl2br(e($slide->title)) !!}
                    </div>
                    @endif

                    <!-- LAYER NR. 2 -->
                    @if($slide->foreground_image)
                    <div class="tp-caption slider-sub-title sfl"
                         data-x="center"
                         data-y="120"
                         data-speed="1000"
                         data-start="700"
                         data-easing="Back.easeInOut"
                         data-endspeed="300"
                         style="color:#fff;font-family:HelveticaNeueLTW20;">
                         <img src="{{ asset($slide->foreground_image) }}" alt="">
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
            <div class="tp-bannertimer tp-bottom"></div>
        </div>
    </div>

    <div class="clearfix">&nbsp;</div>
    <div class="container">
        <div class="text-center row">
            <div class="col-md-12 welcome-note">
                <h4>{!! nl2br(e($setting->welcome_title ?? "هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى .\n\nبداية الكثير من اصحاب الاعمال .")) !!}</h4>

                <a href="{{ $setting->welcome_btn_1_link ?? '#' }}" class="btn orange scroll-link" data-id="portoflio">{{ $setting->welcome_btn_1_text ?? 'رؤية الاعمال' }}</a> 
                <a href="{{ $setting->welcome_btn_2_link ?? '#' }}" class="btn black scroll-link" data-id="contact">{{ $setting->welcome_btn_2_text ?? 'اتصل بنا' }}</a>
            </div>
        </div>
    </div>
</section>
<!-- Slider End -->

<!-- About Us -->
<section id="about" class="content">
    <div class="container">
        <div class="row">
            <!--About Page-->
            <div class="col-md-12 text-center">
                <!--Main Heading-->
                <!--Main Heading-->
                <!--Main Heading-->
                <h2 class="page-head">{{ $setting->about_title ?? __('general.about_title_default') }}</h2>
                <h4>{!! nl2br(e($setting->about_description ?? __('general.about_desc_default'))) !!}</h4>
                <!--Main Heading End-->

                <!--Icon Heading-->
                <div class="icon-head">
                    <i class="fa fa-user"></i>
                </div>
                <!--Icon Heading End-->

                <!--Sub Heading-->
                <!--Sub Heading-->
                <h3>{{ $setting->team_title ?? __('general.team_title_default') }}</h3>
                <h4>{!! nl2br(e($setting->team_description ?? __('general.team_desc_default'))) !!}</h4>
                <!--Sub Heading End-->
                <!--Sub Heading End-->
            </div>
            <!--About Page End-->

            <!--Team Members-->
            @foreach($members as $member)
            <div class="col-sm-3">
                <div class="white-wrap team-wrap">
                    <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                    <h3>{{ $member->name }} <span>{{ $member->job_title }}</span></h3>
                    <div class="social-icons">
                        <ul>
                            @if($member->twitter) <li><a href="{{ $member->twitter }}"><i class="fa fa-twitter"></i></a></li> @endif
                            @if($member->dribbble) <li><a href="{{ $member->dribbble }}"><i class="fa fa-dribbble"></i></a></li> @endif
                            @if($member->google_plus) <li><a href="{{ $member->google_plus }}"><i class="fa fa-google-plus"></i></a></li> @endif
                            @if($member->facebook) <li><a href="{{ $member->facebook }}"><i class="fa fa-facebook"></i></a></li> @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            <!--Team Members End-->
            <div class="clearfix"></div>
            <!--Our Skills-->
            <div class="col-md-12 text-center">
                <!--Icon Heading-->
                <div class="icon-head">
                    <i class="fa fa-code"></i>
                </div>
                <!--Icon Heading End-->

                <!--Sub Heading-->
                <h3>{{ $setting->skills_title ?? __('general.skills_title_default') }}</h3>
                <h4>{!! nl2br(e($setting->skills_description ?? __('general.skills_desc_default'))) !!}</h4>
                <!--Sub Heading End-->
            </div>
            <div class="col-md-12">
                <div class="skillbar-wrap">
                    @foreach($skills as $skill)
                    <div class="col-md-6">
                        <div class="clearfix">
                            <span class="skillbar-title pull-left">{{ $skill->name }}</span>
                            <span class="skill-bar-percent pull-right">{{ $skill->percent }}%</span>
                        </div>
                        <div class="skillbar" data-percent="{{ $skill->percent }}%">
                            <div class="skillbar-bar"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!--Our Skills End-->


        </div>
    </div>

    <!--Page Bottom Spacer-->
    <div class="spacer">&nbsp;</div>
    <!--Page Bottom Spacer End-->
</section>
<!-- About Us End -->

<!-- Services -->
<section id="services" class="content">
    <div class="container">
        <div class="row">
            <!--Services Page-->
            <div class="col-md-12 text-center">
                <!--Main Heading-->
                <h2 class="page-head">{{ $setting->services_title ?? __('general.services_title_default') }}</h2>
                <h4>{!! nl2br(e($setting->services_description ?? __('general.services_desc_default'))) !!}</h4>
                <!--Main Heading End-->

                <!--Icon Heading-->
                <div class="icon-head">
                    <i class="fa fa-briefcase"></i>
                </div>
                <!--Icon Heading End-->

                <!--Sub Heading-->
                <h3>{{ $setting->services_sub_title ?? __('general.services_title_default') }}</h3>
                <h4>{!! nl2br(e($setting->services_sub_description ?? __('general.services_desc_default'))) !!}</h4>
                <!--Sub Heading End-->
            </div>

            <!--Feature Services-->
            @foreach($services as $service)
            <div class="col-sm-4">
                <div class="white-wrap service-wrap">
                    <div class="service-icon">
                        <i class="{{ $service->icon }} fa-2x"></i>
                    </div>
                    <h3>{{ $service->title }}</h3>
                    <p>{!! nl2br(e($service->description)) !!}</p>
                </div>
            </div>
            @endforeach
            <!--Feature Services End-->
            <div class="clearfix"></div>
            <!--Feature Call To Action-->
            <div class="col-md-12 col-lg-12">
                <div class="call-action text-center">
                    <p>{{ $setting->cta_text ?? __('general.contact_desc_default') }}</p>
                    <div>
                        <a href="{{ $setting->cta_button1_link ?? '#' }}" class="btn orange">{{ $setting->cta_button1_text ?? __('general.read_more') }}</a>
                        <a href="{{ $setting->cta_button2_link ?? '#' }}" class="btn white">{{ $setting->cta_button2_text ?? __('general.call_us') }}</a>
                    </div>
                </div>
            </div>
            <!--Feature Call To Action End-->

            <div class="col-md-12 text-center">


                <!--Services Page End-->
            </div>
        </div>

        <!--Page Bottom Spacer-->
        <div class="spacer">&nbsp;</div>
        <!--Page Bottom Spacer End-->
</section>
<!-- Services End -->

<!-- Portoflio -->
<section id="portoflio" class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <!--Main Heading-->
                <h2 class="page-head">{{ $setting->portfolio_title ?? __('general.portfolio_title_default') }}</h2>
                <h4>{!! nl2br(e($setting->portfolio_description ?? __('general.portfolio_desc_default'))) !!}</h4>
                <!--Main Heading End-->
            </div>
        </div>
    </div>


    <section id="portfolio-grid">
        <div class="container">
            <div class="row">
                <div class="wrapper wf">
                    <div class="col-md-12">
                        <ul class="unstyled" id="filters">
                            <li class="filter" data-filter="all" data-role="button"><a href="javascript:void(0)">{{ __('general.all') }}</a></li>
                            @foreach($categories as $category)
                            <li class="filter" data-filter="{{ $category->slug }}" data-role="button"><a href="javascript:void(0)">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <ul id="Grid" class="unstyled">
                        @foreach($portfolios as $portfolio)
                        <li class="mix col-sm-3 {{ $portfolio->category->slug ?? '' }}" data-sort="data-name">
                            <div class="white-wrap">
                                <div class="image-holder">
                                    <a href="{{ $portfolio->image ? asset($portfolio->image) : asset('images/portfolio/default.jpg') }}" class="fancybox" data-fancybox-group="gallery" title="{{ $portfolio->title }}">
                                        <span class="item-on-hover"><span class="hover-image"><i class="fa fa-search fa-2x"></i></span></span>
                                        <img src="{{ $portfolio->image ? asset($portfolio->image) : asset('images/portfolio/default.jpg') }}" alt="{{ $portfolio->title }}">
                                    </a>
                                </div>
                                <div class="text-holder">
                                    <i class="fa fa-picture-o"></i>
                                    <h3>{{ $portfolio->title }}</h3>
                                    <p>{{ $portfolio->description }}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- END DEMO WRAPPER -->
    <!--Page Bottom Spacer-->
    <div class="spacer">&nbsp;</div>
    <!--Page Bottom Spacer End-->
</section>
<!-- Portoflio End -->

<!-- Our Blog -->
<section id="blog" class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <!--Main Heading-->
                <h2 class="page-head">{{ $setting->blog_title ?? __('general.blog_title_default') }}</h2>
                <h4>{!! nl2br(e($setting->blog_description ?? __('general.blog_desc_default'))) !!}</h4>
                <!--Main Heading End-->
            </div>
            <div class="col-md-12">
                <div id="bloglist" class="bloglist blog-grid">

                    <!-- loop starts here -->
                    @foreach($posts as $post)
                    <div class="blog-entry">
                        <div class="white-wrap">
                            <div class="image-holder">
                                <a href="#" class="fancybox" title="{{ $post->title }}">
                                    <span class="item-on-hover"><span class="hover-image"><i class="fa fa-search fa-2x"></i></span></span>
                                    <img src="{{ $post->image ? asset($post->image) : asset('images/blog/default.jpg') }}" alt="{{ $post->title }}">
                                </a>
                            </div>
                            <div class="text-holder">
                                <i class="fa fa-picture-o"></i>
                                <div class="meta">
                                    <span> {{ $post->published_at ? $post->published_at->format('M Y') : '' }} / {{ __('general.articles') }} </span>
                                </div>
                                <h3><a href="#">{{ $post->title }}</a></h3>
                                <div>{!! Str::limit(strip_tags($post->content), 150) !!}</div>
                                <a href="#" class="btn black">{{ __('general.read_more') }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- loop ends here  -->

                </div>
            </div>

            <div class="col-sm-12">
                <a href="#" id="load-more">{{ __('general.load_more') }}</a>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <!--Page Bottom Spacer-->
    <div class="spacer">&nbsp;</div>
    <!--Page Bottom Spacer End-->
</section>
<!-- Our Blog End -->

<!-- Contact Us -->
<section id="contact" class="content last">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <!--Main Heading-->
                <!--Main Heading-->
                <h2 class="page-head">{{ $setting->contact_title ?? __('general.contact_title_default') }}</h2>
                <h4>{!! nl2br(e($setting->contact_description ?? __('general.contact_desc_default'))) !!}</h4>                <!--Main Heading End-->
            </div>
        </div>
    </div>

    <div class="parallax-area parallax-image" data-stellar-background-ratio="0.1" id="contacr-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="white-wrap">
                        <div class="text-holder">
                            <i class="fa fa-map-marker"></i>
                            <h3>{{ __('general.address') }}</h3>
                            <div>{{ $setting->address }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="white-wrap">
                        <div class="text-holder">
                            <i class="fa fa-phone"></i>
                            <h3>{{ __('general.call_us') }}</h3>
                            <div>{{ $setting->phone }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="white-wrap">
                        <div class="text-holder">
                            <i class="fa fa-envelope"></i>
                            <h3>{{ __('general.send_email') }}</h3>
                            <div><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="form-div">
                    <div class="col-sm-12">
                        <div id="sucessmessage"> </div>
                    </div>
                    <form id="contact_form" method="post" action="#" />
                    <div class="col-sm-4">
                        <input type="text" placeholder="{{ __('general.full_name') }}" name="الاسم" id="name" class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="email" placeholder="{{ __('general.email') }}" id="email" class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="phone" placeholder="{{ __('general.phone') }}" id="phone" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <textarea name="comment" id="comment" placeholder="{{ __('general.message') }}" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-default" value="{{ __('general.submit') }}" id="submit" />
                    </div>
                    <div class="col-sm-6 text-right">
                        <h5>{{ __('general.response_message') }}</h5>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="text-center">
                <div class="social-icons">
                    <ul>
                        <li><a href="{{ $setting->twitter ?? '#' }}"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="{{ $setting->facebook ?? '#' }}"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="{{ $setting->linkedin ?? '#' }}"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-windows"></i></a></li>
                        <li><a href="#"><i class="fa fa-skype"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright text-center">
            © {{ date('Y') }} <span>{{ $setting->site_name }}</span>  : <a href="#">{{ __('general.and_mobile_apps') }}</a>
        </div>
    </footer>
</section>
<!-- Contact Us End -->

<div id="back-top">
    <a  class="scroll-link" data-id="home" href="#">
        <i class="fa fa-angle-up"></i>
    </a>
</div>

<div class="styleswitcher" style="left: 0px;">
    <div class="arrow-box"><a class="switch-button open"><i class="fa fa-gear fa-2x"></i></a> </div>
    <h6>{{ __('general.your_color') }}</h6>
    <ul class="color-scheme">
        <li><a class="blue-theme" rel="{{ asset('css/theme-blue.css') }}" href="#"></a></li>
        <li><a class="cherry-theme" rel="{{ asset('css/theme-cherry.css') }}" href="#"></a></li>
        <li><a class="teal-theme" rel="{{ asset('css/theme-teal.css') }}" href="#"></a></li>
        <li><a class="red-theme" rel="{{ asset('css/theme-red.css') }}" href="#"></a></li>
        <li><a class="pink-theme" rel="{{ asset('css/theme-pink.css') }}" href="#"></a></li>
        <li><a class="green-theme" rel="{{ asset('css/theme-green.css') }}" href="#"></a></li>
        <li><a class="orchid-theme" rel="{{ asset('css/theme-orchid.css') }}" href="#"></a></li>
        <li><a class="jade-theme" rel="{{ asset('css/theme-jade.css') }}" href="#"></a></li>
        <li><a class="skyblue-theme" rel="{{ asset('css/theme-skyblue.css') }}" href="#"></a></li>
        <li><a class="orange-theme" rel="{{ asset('css/theme-orange.css') }}" href="#"></a></li>
        <li><a class="yellow-theme" rel="{{ asset('css/theme-yellow.css') }}" href="#"></a></li>
        <li><a class="blue2-theme" rel="{{ asset('css/theme-blue2.css') }}" href="#"></a></li>

    </ul>
</div>

<!-- jQuery & Helper library -->
<script type="text/javascript" src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.appear.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/modernizr-latest.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/jquery.fitvids.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/retina.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.pack8cbb.js?v=2.1.5') }}"></script>
<script type='text/javascript' src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.mixitup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.flexslider-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/stellar.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.themepunch.plugins.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
<script type="text/javascript" src="{{ asset('js/jquery.gmap.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/map-icons.css') }}" />
<script src="{{ asset('js/map-icons.js') }}"></script>

<!--scripts for current page -->
<script type="text/javascript" src="{{ asset('js/theme-custom.js') }}"></script>
</body>
</html>



