<!-- /*
* Template Name: Snap
* Template Author: Untree.co
* Tempalte URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<?php

$order_success = isset($_GET['order_success']) && $_GET['order_success'] === 'true';
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php if ($order_success): ?>
        // Simulate a click on the button if order_success is true
        document.getElementById('triggerModal').click();
    <?php endif; ?>
    var url = new URL(window.location.href);
        url.searchParams.delete('order_success'); // Remove the order_success parameter
        history.replaceState(null, '', url);
});
</script>
<!-- calendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="" />
  

  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600, 700,900|Oswald:400,700" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/fancybox.min.css">

  <link rel="stylesheet" href="css/style.css">
  <title>dos studios.</title>
  <!-- calendar -->
    <style>
        .datepicker {
            position: absolute !important;
            left: 0 !important;
            z-index: 9999; /* Make sure the calendar appears on top */
        }
    </style>

</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200" style="background-color: #FAF3E6;">




  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <header class="header-bar d-flex d-lg-block align-items-center site-navbar-target" data-aos="fade-right" style="background-color: #fff;">
      <div class="site-logo">
        <a href="index.php">dos.</a>
      </div>

      <div class="d-inline-block d-lg-none ml-md-0 ml-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle "><span class="icon-menu h3"></span></a></div>

      <div class="main-menu">
        <ul class="js-clone-nav">
          <li><a href="#section-home" class="nav-link">Home</a></li>
          <li><a href="#section-photos" class="nav-link">Photos</a></li>
          <li><a href="#section-about" class="nav-link">About</a></li>
          <li><a href="#section-testimonial" class="nav-link">Testimonial</a></li>
          <li><a href="#section-services" class="nav-link">Services</a></li>
          
        </ul>
        <ul class="social js-clone-nav">
          <li><a href="https://www.instagram.com/dos.studiosph/?hl=en" target="_blank"><span class="icon-instagram"></span></a></li>
          <li><a href="https://www.facebook.com/dosstudiosph?mibextid=ZbWKwL"  target="_blank"><span class="icon-facebook"></span></a></li>
          <li><a href="https://www.tiktok.com/@dos.studiosph?_t=8r8O1K6tvJY&_r=1" target="_blank"><i class="fab fa-tiktok"></i></a></li>
        </ul>
      </div>
    </header> 
    <main class="main-content" style="background-color: #fff;">

    <section class="site-section-hero bg-image mb-5" style="background-image: url('images/background.png'); background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;"  data-stellar-background-ratio="0.5" id="section-home">
        <div class="row justify-content-center align-items-center">
          <div class="col-md-7 text-center">
            <h1 class=" heading  text-white" data-aos="fade-up">dos studios.</h1>
            <br>
            <!-- <center><button class="btn btn-primary nav-link text-white" onclick="window.location.href='#section-contact'"  data-aos="fade-up">
    <h1 class="heading">Book Now</h1></center> -->
            </button>
            <!-- <p class="lead text-white mb-4" data-aos="fade-up" data-aos-delay="100">A Free Onepage Bootstrap Template by <a href="https://untree.co/">Untree.co</a>. Under licensed <a href="https://untree.co/license/" taget="_blank">Creative Common Attribution 3.0</a></p> -->
            <p data-aos="fade-up" data-aos-delay="100"><a href="verification.php" class="btn btn-primary btn-md smoothscroll">Book Now</a></p>
          </div>
        </div>
      </section>

      <div class="container-fluid site-section">


      <div class="row mb-3">
          <div class="col-12 text-center">
            <h2 class="heading">Photos</h2>
          </div>
        </div>

        <section class="row align-items-stretch photos" id="section-photos">
          <div class="col-12">
            <div class="row align-items-stretch">

              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up">
                <a href="images/img1.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img1.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img2.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img2.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/img3.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img3.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>

              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up">
                <a href="images/img4.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img4.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img5.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img5.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/img6.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img6.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>

              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up">
                <a href="images/img7.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img7.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img8.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img8.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/img9.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img9.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>


              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up">
                <a href="images/img10.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img10.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img11.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img11.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/img12.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img12.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>

              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up">
                <a href="images/img13.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img13.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img14.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img14.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/img15.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img15.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>

              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up">
                <a href="images/img16.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img16.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img17.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img17.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/img18.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img18.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>

              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img19.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img19.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <a href="images/img20.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/img20.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>
              <div class="col-6 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <a href="images/qty.jpg" class="d-block photo-item" data-fancybox="gallery">
                  <img src="images/qty.jpg" alt="Image" class="img-fluid mb-0">
                  <div class="photo-text-more">
                    <span class="icon icon-eye"></span>
                  </div>
                </a>
              </div>



            </div>

          </div>
        </section> <!-- #section-photos -->

        <section class="site-section" id="section-about">
          <div class="container">
            <div class="row justify-content-center">

              <div class="col-md-8">

                <!-- <h2 class="heading">About</h2> -->

                <img src="images/profile.jpg" alt="Image" class="img-fluid mb-4 w-50 rounded-circle">
              

                <div data-aos="fade-up"  data-aos-delay="100">
                <h2 class="">About Dos Studios</h2>
                      <p>At Dos Studios, we believe in capturing memories that last a lifetime. We are a team of passionate photographers and creative professionals dedicated to delivering high-quality photography services for any occasion. From family portraits to professional headshots and event coverage, our studio offers a versatile range of services designed to bring out the best in every client.</p>
                      <br><h4>Our Mission</h4>
                      <p>We aim to provide an unforgettable experience where every photo session is as unique as the people we capture. Our mission is to blend creativity and professionalism, offering tailored photography sessions that reflect each client’s personality and needs.</p>
                      <br><h4>Our Team</h4>
                      <p>Our talented team combines years of experience and technical expertise to ensure your experience with Dos Studios is both comfortable and rewarding. We take pride in creating a relaxed environment where you feel at ease, enabling us to capture authentic, beautiful moments.</p>
                
                      





                <h3 class=" mt-5">Services</h3>                 
                  <div class="d-block d-md-flex mt-5">
                    <div class="mr-md-auto mr-2">
                      <ul class="ul-check list-unstyled primary">
                        <li>Self-photography sessions</li>
                        <li>Event Self-Photography</li>
                        <li>Themed Sets</li>
                      </ul>
                    </div>
                    <div class="mr-md-auto">
                      <ul class="ul-check list-unstyled primary">
                        <li>Props Rentals</li>
                        <li>Guided Setup Assistance</li>
                        <li>Instant Digital Copies</li>
                      </ul>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
<br>
<br>
<section class="site-section" id="section-testimonial">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8 text-center">
                <h2 class="heading">Testimonial</h2>

                <div class="row justify-content-center">
                  <div class="col-md-12">

                    <div class="owl-carousel slide-one-item home-slider">

                      <div class="testimony text-center px-md-4">
                        <figure class="mx-auto d-inline-block">
                          <img src="images/profile5.jpg" alt="Free Template by Untree.co" class="mx-auto img-fluid w-25 rounded-circle">
                        </figure>
                        <p class="text-black"><strong>Audrey Pamiloza</strong></p>
                        <blockquote>
                          <p>&ldquo;The shots are very nice!! Very pro yung shotss!! Will definitely come back!!
                          Add ko lang, napaka- accommodating ng staffs and superr ganda ng ambience ng place. WORTH EVERY PENNY!!!🫶🏻🫶🏻🫶🏻🫶🏻🫶🏻🫶🏻🫶🏻🫶🏻🫶🏻 🥳&rdquo;</p>
                        </blockquote>
                      </div>

                      <div class="testimony text-center px-md-4">
                        <figure class="mx-auto d-inline-block">
                          <img src="images/profile6.jpg" alt="Free Template by Untree.co" class="mx-auto img-fluid w-25 rounded-circle">
                        </figure>
                        <p class="text-black"><strong>Monse Daeng</strong></p>
                        <blockquote>
                          <p>&ldquo;I love the vibes super enjoyed and very accomodating staff! super lovely studio! most recommend!&rdquo;</p>
                        </blockquote>
                      </div>

                      <div class="testimony text-center px-md-4">
                        <figure class="mx-auto d-inline-block">
                          <img src="images/profile1.jpg" alt="Free Template by Untree.co" class="mx-auto img-fluid w-25 rounded-circle">
                        </figure>
                        <p class="text-black"><strong>Bernadette Adzuara</strong></p>
                        <blockquote>
                          <p>&ldquo;The studio’s staff are friendly and welcoming, and they accept walk-ins without any hassle. What stands out the most is the high photo quality and affordability, along with the receiving all the raw image for free. This was our third time here, and the service is consistent. Thank you, Dos Studios! ❤️
                          &rdquo;</p>
                        </blockquote>
                      </div>

                      <div class="testimony text-center px-md-4">
                        <figure class="mx-auto d-inline-block">
                          <img src="images/profile3.jpg" alt="Free Template by Untree.co" class="mx-auto img-fluid w-25 rounded-circle">
                        </figure>
                        <p class="text-black"><strong>Patrick Larraquel</strong></p>
                        <blockquote>
                          <p>&ldquo;The environment inside is very welcome and the place looks very aesthetic, the studio has all the equipments used for a self-studio and also all the staff are very kind and approachable. Will definitely come back to take some more pictures 🫶🏻
                          &rdquo;</p>
                        </blockquote>
                      </div>

                      <div class="testimony text-center px-md-4">
                        <figure class="mx-auto d-inline-block">
                          <img src="images/profile4.jpg" alt="Free Template by Untree.co" class="mx-auto img-fluid w-25 rounded-circle">
                        </figure>
                        <p class="text-black"><strong>Robert Soliman</strong></p>
                        <blockquote>
                          <p>&ldquo;Staff are accommodating. Studio is well lit and fully equipped. The ambience is giving also. I can say that this is one of the best self-shoot studio here in the Metro! Sad lang na di available yung violet backdrop HAHA para Speak Now vibes sana haha but still, a good studio overall.&rdquo;</p>
                        </blockquote>
                      </div>

                      <div class="testimony text-center px-md-4">
                        <figure class="mx-auto d-inline-block">
                          <img src="images/profile2.jpg" alt="Free Template by Untree.co" class="mx-auto img-fluid w-25 rounded-circle">
                        </figure>
                        <p class="text-black"><strong>Daniela Portes</strong></p>
                        <blockquote>
                          <p>&ldquo;nice place to experience self studio photoshoot! 💗 very student friendly ☺️ &rdquo;</p>
                        </blockquote>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="site-section" id="section-services">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <div class="row">
                  <h2 class="heading"  data-aos="fade-up">Services</h2>
                  <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"><img src="images/self-photography.jpg" alt="Image" class="img-fluid mb-0"></div>
                      <div>
                        <h2 class="mt-0 mb-2">Self-Photography Sessions</h2>
                        
                        <p>Customers take their own photos using remote controls and professional studio equipment.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"><img src="images/self-photography-event.jpg" alt="Image" class="img-fluid mb-0"></div>
                      <div>
                        <h2 class="mt-0 mb-2">Event Self-Photography</h2>
                        
                        <p>Self-photography setups for events like birthdays or small gatherings, where guests can capture their own memories.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"><img src="images/themed-sets.jpg" alt="Image" class="img-fluid mb-0"></div>
                      <div>
                        <h2 class="mt-0 mb-2">Themed Sets</h2>
                        
                        <p>Pre-designed and customizable themes for different occasions, such as holiday sets, retro themes, or seasonal backdrops.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"><img src="images/prop-rentals.jpg" alt="Image" class="img-fluid mb-0"></div>
                      <div>
                        <h2 class="mt-0 mb-2">Prop Rentals</h2>
                        
                        <p>Access to various props that customers can use during their sessions to personalize their photos.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"><img src="images/guided-setup.jpg" alt="Image" class="img-fluid mb-0"></div>
                      <div>
                        <h2 class="mt-0 mb-2">Guided Setup Assistance</h2>
                        
                        <p>Staff support to help customers with equipment, poses, and tips for capturing the best shots.</p>
                      </div>
                    </div>
                  </div>  
                  <div class="col-md-12 mb-4" data-aos="fade-up">
                    <div class="d-md-flex d-block blog-entry align-items-start">
                      <div class="mr-0 mr-md-5 mb-3 img-wrap"><img src="images/digital-copies.jpg" alt="Image" class="img-fluid mb-0"></div>
                      <div>
                        <h2 class="mt-0 mb-2">Digital Copies</h2>
                       
                        <p>Providing customers with quick digital access to their photos for easy sharing and downloading.</p>
                      </div>
                    </div>
                  </div>    
                    
                  <div class="col-12 text-center">
<!--                     <div class="custom-pagination">
                      <span>1</span>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <span>...</span>
                      <a href="#">7</a>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>


        <div class="row justify-content-center">
          <div class="col-md-12 text-center py-5">
            <!-- <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a>
            </p> -->
          </div>
        </div>
      </div>
    </main>

  </div> <!-- .site-wrap -->


<!-- Verification modal -->

















  <script>
    function changeValue(input, delta) {
        input.value = Math.max(0, parseInt(input.value) + delta);
        updateTotalPrice();
        updatePackageList();
    }

    function updateTotalPrice() {
        let totalPrice = 0;

        document.querySelectorAll('.package-quantity').forEach(input => {
            const quantity = parseInt(input.value);
            const price = parseFloat(input.dataset.price);

            totalPrice += price * quantity;
        });

        // Update both visible and hidden total price fields
        document.getElementById('txtTotalPrice').value = totalPrice.toFixed(2);
        document.getElementById('hiddenTotalPrice').value = totalPrice.toFixed(2);
    }

    // Automatically update hidden total price field before submitting
    function updateHiddenTotalPrice() {
        document.getElementById('hiddenTotalPrice').value = document.getElementById('txtTotalPrice').value;
    }

    // Event listeners to update the price
    document.querySelectorAll('.package-quantity').forEach(input => {
        input.addEventListener('input', updateTotalPrice);
    });
    function updateHiddenPackageList() {
    const packageList = [];
    
    // Loop through each package and get its name if the quantity is more than 0
    document.querySelectorAll('.package-quantity').forEach((input) => {
        const quantity = parseInt(input.value);
        if (quantity > 0) {
            const packageName = input.closest('div').previousElementSibling.querySelector('h2').dataset.packageName;
            packageList.push(`${packageName} x ${quantity}`);
        }
    });

    // Join the package names with '|'
    document.getElementById('hiddenpackagelist').value = packageList.join(' | ');
}
function updatePackageList() {
    // Get all package quantity inputs
    const quantityInputs = document.querySelectorAll('.package-quantity');
    let packageList = [];

    quantityInputs.forEach(input => {
        // Get the current value and check if it's greater than 0
        const quantity = parseInt(input.value, 10);
        if (quantity > 0) {
            // Get the corresponding package name and add it to the list
            const packageName = input.getAttribute('data-name');
            packageList.push(packageName);
        }
    });

    // Concatenate package names with '|'
    const concatenatedPackages = packageList.join(' | ');

    // Set the value of the hidden input
    document.getElementById('hiddenpackagelist').value = concatenatedPackages;
}

// Add event listener to all quantity inputs to call updatePackageList when they change
document.querySelectorAll('.package-quantity').forEach(input => {
    input.addEventListener('input', updatePackageList);
  });
   
    // Initialize the total price on page load
    updateTotalPrice();




</script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/lozad.min.js"></script>
  

  <script src="js/jquery.fancybox.min.js"></script>

  <script src="js/main.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  </body>
</html>
