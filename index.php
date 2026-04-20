<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
$info = home();
?>
<html>
	<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$info['name']?></title>
    <link href="/controlPage/css/new.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="/controlPage/file/img/logo.webp">
    <meta name="robots" content="index">
    <meta name="theme-color" content="#08BA92">
    <meta property="og:site_name" content="Bloxtools">
    <meta property="og:type" content="article">
    <meta name="keywords" content="copy games, copy clothes, follow bot, roblox free followers, roblox follow bot, roblox followers, roblox shirt, roblox shirt bot, roblox copy game, roblox download game">
  </head>

<body>
    <header id="navbar" class="active">
      <div class="overlay"></div>
      <div class="container">
        <nav class="navbar navbar-expand-xl navbar-dark">
          <a class="navbar-brand" href="#">
            <img src="/controlPage/file/img/logo.webp" alt="" style="width: 3.5rem;">
          </a>
          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link px-md-2 px-0" href="#home" onclick="change_nav(1)">Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-md-2 px-0" href="#tools" onclick="change_nav(3)">Tools</a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-md-2 px-0" href="#faqs" onclick="change_nav(4)">FAQ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link px-md-2 px-0" href="#contacts" onclick="change_nav(5)">Contact</a>
              </li>
            </ul>
            <div class="d-lg-flex d-block">
          </div>
        </div></nav>
      </div>
    </header>
    <section style="overflow: hidden;" id="landing">
      <div class="overlay-left"></div>
      <div class="overlay-right"></div>
      <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center text-center">
          <div class="col-12">
            <div class="content">
              <span style="font-size: 1.3rem; position:relative; bottom:0.1rem">⭐</span>
              <span class="span-off">Free, high quality Roblox Tools!</span><span class="typed-cursor" aria-hidden="true">|</span>
              <br>
              <br>
              <h1><?=$info['name']?></h1>
              <br><p>Easy to use tools, with detailed 
                instructions on how to use them! These tools consist of a shirt copier, <br>game copier, and a follower botter. We made all this just to make roblox simple again!</p>
              <a href="#tools" onclick="change_nav(3)" class="button rounded-circle">Start <i class="ri-arrow-drop-right-line"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 180">
        <path fill="#121415" fill-opacity="1" d="M0,128L120,138.7C240,149,480,171,720,170.7C960,171,1200,149,1320,138.7L1440,128L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#007acc;"></path>
      </svg>
    </section>
    <section id="tools-faq">
      <div class="overlay-top"></div>
      <div class="overlay-bottom"></div>
      <div class="container">
        <div class="row text-center justify-content-center mb-5">
          <div class="col-12">
            <div class="top-text">
              <h2>Our selection of 
                <span style="color: var(--primary);">tools</span>
              </h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center" style="margin-bottom: 9rem;">
          <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="box">
              <div class="top">
                <h3>Copy Games <small style="color: var(--primary);">(<?=$info['name']?>)</small>
                </h3>
              </div>
              <hr>
              <div class="rbxtool">
                <p>Copy any game super efficiently and with ease!</p>
              </div>
              <hr>
              <div class="checks">
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Advanced game copy AI</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Class A Support</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Frequent Updates</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Multiple working bots</span>
                </div>
                <div class="buy">
                  <div class="rbxinfo">
                    <span>
                       Try it now!
                    </span>
                  </div>
                  <p>Copy Games Tool</p>
                  <center>
                    <a href="<?=$info['directory']?>/copier" class="button rounded-circle"> Try Now <i class="ri-arrow-drop-right-line"></i></a>
                  </center>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-5 col-md-6 mt-md-0 mt-4">
            <div class="box promo">
              <div class="top">
                <h3>Copy Clothes <small style="color: var(--primary);">(<?=$info['name']?>)</small>
                </h3>
              </div>
              <hr>
              <div class="rbxtool">
                <p>Fastest clothing copier! Faster then the competition.</p>
              </div>
              <hr>
              <div class="checks">
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Fast and easy shirt copier</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Class A Support</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Unlimited uses</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Advanced clothing copying bots</span>
                </div>
                <div class="buy">
                  <div class="rbxinfo">
                    <span>
                       Try it now!
                    </span>
                  </div>
                  <p>Copy Clothes Tool</p>
                  <center>
                    <a href="<?=$info['directory']?>/stealer" class="button rounded-circle"> Try Now <i class="ri-arrow-drop-right-line"></i>
                    </a>
                  </center>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-5 col-md-6 mt-md-0 mt-4">
            <div class="box promo">
              <div class="top">
                <h3>Follow Bot <small style="color: var(--primary);">(<?=$info['name']?>)</small>
                </h3>
              </div>
              <hr>
              <div class="rbxtool">
                <p>This tool used to cost money but we made it free!</p>
              </div>
              <hr>
              <div class="checks">
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Thousands of bots ready to follow</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Class A Support</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>Unlimited uses</span>
                </div>
                <div class="check">
                  <i class="ri-check-line"></i>
                  <span>100% uptime to date</span>
                </div>
                <div class="buy">
                  <div class="rbxinfo">
                    <span>
                       Try it now!
                    </span>
                  </div>
                  <p>Follow Bot Tool</p>
                  <center>
                    <a href="<?=$info['directory']?>/followers" class="button rounded-circle"> Try Now <i class="ri-arrow-drop-right-line"></i>
                    </a>
                  </center>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center justify-content-center faq">
          <div class="col-12">
            <div class="top-text">
              <h2>Frequently Asked Questions</h2>
              <p>Here are some common questions people ask us.</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-10">
            <div class="accordion" id="accordionPanelsStayOpen">
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne"> Will I be terminated for using this service? </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne" style="">
                  <div class="accordion-body"> No you will not be banned for using our services
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo"> Does this break the Roblox ToS? </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo" style="">
                  <div class="accordion-body"> Our platform makes sure to not break any Terms of service your safety is our concern </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree"> Is roblox against the use of this platform? </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                  <div class="accordion-body"> Roblox has accepted the use of our services on it's platform, and it does not abide or break the Roblox Terms of service. </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour"> How long does this take? </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                  <div class="accordion-body"> Most of the time the assets load under two minutes if this takes longer please contact support. </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="contact">
      <div class="container">
        <div class="row text-center">
          <div class="col-12">
            <h2>Looking for contact?</h2>
            <p>Check out some ways to contact us</p>
            <a href="https://discord.gg/login" class="button rounded-circle px-5">Discord</a>
            <a href="#contact" class="button rounded-circle px-5">Online</a>
          </div>
        </div>
      </div>
    </section>
    <footer>
      <p class="text-center">Copyright 2025 <?=$info['name']?>. All rights reserved.</p>
    </footer>
    <script src="assets/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
      AOS.init({
        disable: 'mobile',
        once: true,
      });
    </script>
    <script>
      var typed = new Typed('.span-off', {
        strings: ['BloxTools', 'Premium Roblox bots', 'Free, high quality Roblox Tools!'],
        loop: true,
        typeSpeed: 60,
        backSpeed: 30,
      });
    </script><style type="text/css" data-typed-js-css="true">
        .typed-cursor{
          opacity: 1;
        }
        .typed-cursor.typed-cursor--blink{
          animation: typedjsBlink 0.7s infinite;
          -webkit-animation: typedjsBlink 0.7s infinite;
                  animation: typedjsBlink 0.7s infinite;
        }
        @keyframes typedjsBlink{
          50% { opacity: 0.0; }
        }
        @-webkit-keyframes typedjsBlink{
          0% { opacity: 1; }
          50% { opacity: 0.0; }
          100% { opacity: 1; }
        }
      </style>
    <script>var _____WB$wombat$assign$function_____ = function(name) {return (self._wb_wombat && self._wb_wombat.local_init && self._wb_wombat.local_init(name)) || self[name]; };
if (!self.__WB_pmw) { self.__WB_pmw = function(obj) { this.__WB_source = obj; return this; } }
{
let window = _____WB$wombat$assign$function_____("window");
let globalThis = _____WB$wombat$assign$function_____("globalThis");
let self = _____WB$wombat$assign$function_____("self");
let document = _____WB$wombat$assign$function_____("document");
let location = _____WB$wombat$assign$function_____("location");
let top = _____WB$wombat$assign$function_____("top");
let parent = _____WB$wombat$assign$function_____("parent");
let frames = _____WB$wombat$assign$function_____("frames");
let opener = _____WB$wombat$assign$function_____("opener");
{
function remove_hash() {
        setTimeout(() => {
          history.replaceState({}, document.title, ".");
        }, 5);
      }
      var scroll = $(window).scrollTop();
      if (scroll > 70) {
        $("#navbar").addClass("active");
      } else {
        $("#navbar").removeClass("active");
      }

      function change_nav(tab) {
        remove_hash();
        if (tab == 1) {
          $(window).scrollTop(0);
        } else if (tab == 2) {
          $(window).scrollTop($("#why-choose").offset().top - 200);
        } else if (tab == 3) {
          $(window).scrollTop($("#tools-faq").offset().top - 100);
        } else if (tab == 4) {
          $(window).scrollTop($("#tools-faq .faq").offset().top - 300);
        } else if (tab == 5) {
          $(window).scrollTop($("body").height());
        }
      }
      $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > 70) {
          $("#navbar").addClass("active");
        } else {
          $("#navbar").removeClass("active");
        }
      });

}}</script>
  

<!--
playback timings (ms):
  captures_list: 274.61
  exclusion.robots: 0.192
  exclusion.robots.policy: 0.181
  cdx.remote: 0.06
  esindex: 0.01
  LoadShardBlock: 236.371 (3)
  PetaboxLoader3.datanode: 172.128 (4)
  load_resource: 1106.088
  PetaboxLoader3.resolve: 105.487
--><style>.qc-cmp-showing { visibility: hidden !important; } body.didomi-popup-open { overflow: auto !important; } #didomi-host { visibility: hidden !important; }</style></body>