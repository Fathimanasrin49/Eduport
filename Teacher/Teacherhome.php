<?php 
include("../Assets/Connection/Connection.php");
session_start();
if($_SESSION['tid']==""){
    header('location:../Guest/Login.php');
     
}

 $select="select * from tbl_teacher where teacher_id='".$_SESSION['tid']."'";
       $res = $Conn->query($select);
       $data=$res->fetch_assoc();

?>

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eduport::Teacherhome</title>
</head>

<body>
	<p>WELCOME <br />
      <a href="TeacherProfile.php">My Profile</a></p>
     <p> <a href="ParentList.php">ViewParentList</a></p>
  <p><a href="StudentInfo.php">StudentInformation and AddAttendance</a>
      <p><a href="InternalExam.php">InternalExamHead</a></p>
      <p><a href="MainExam.php">MainExamHead</a></p>
      <p><a href="ViewInternal.php">ViewInternalMark</a></p>
      <p><a href="ViewMain.php">ViewMainExamMark</a></p>
      <p><a href="ViewLeave.php">View Leave</a></p>
      <p><a href="ViewReport.php">View Report</a></p>
      <p>&nbsp;</p>
    </p>
<p>&nbsp;</p>
</body>
</html>-->
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../Assets/Templates/Main/img/favicon.png" type="image/png" />
  <title>Eduport</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../Assets/Templates/Main/css/bootstrap.css" />
  <link rel="stylesheet" href="../Assets/Templates/Main/css/flaticon.css" />
  <link rel="stylesheet" href="../Assets/Templates/Main/css/themify-icons.css" />
  <link rel="stylesheet" href="../Assets/Templates/Main/vendors/owl-carousel/owl.carousel.min.css" />
  <link rel="stylesheet" href="../Assets/Templates/Main/vendors/nice-select/css/nice-select.css" />
  <!-- main css -->
  <link rel="stylesheet" href="../Assets/Templates/Main/css/style.css" />
</head>

<body>
  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <div class="search_input" id="search_input_box">
        <div class="container">
          <form class="d-flex justify-content-between" method="" action="">
            <input type="text" class="form-control" id="search_input" placeholder="Search Here" />
            <button type="submit" class="btn"></button>
            <span class="ti-close" id="close_search" title="Close Search"></span>
          </form>
        </div>
      </div>

      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <!-- Logo with text under it -->
          <a href="index.html" class="navbar-brand logo_h">
            <div class="logo-container">
              <img src="../Assets/Templates/Main/img/NewLogo.jpeg" alt="Eduport Logo" width="100" />
              <span class="logo-text">Eduport</span>
            </div>
          </a>

          <!-- CSS -->
          <style>
            .logo-container {
              display: flex;
              flex-direction: column;
              /* Stack image and text vertically */
              align-items: center;
              /* Center horizontally */
              text-align: center;
            }

            .logo-container img {
              display: block;
              margin-bottom: 5px;
              /* Space between image and text */
            }

            .logo-text {
              font-size: 18px;
              font-weight: bold;
              color: #1a1a2e;
              /* Dark blue, change as needed */
              font-family: 'Poppins', sans-serif;
              letter-spacing: 1px;
            }
          </style>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span> <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto" style="width:1200px">
              <li class="nav-item active">
                <a class="nav-link" href="Teacherhome.php">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="StudentInfo.php">Child Info</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="ViewReport.php">Report</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="InternalExam.php">Internal Exam</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="MainExam.php">Main Exam</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="ViewInternal.php">View Internal</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="ViewMain.php">View MainExam</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="ViewLeave.php">View Leave</a>
              </li>
               <div class="d-flex align-items-center ml-3">
        <img src="../Assets/Files/Teacherimage/<?php echo $data['teacher_photo'] ?>" 
             alt="Teacher Photo" 
             class="rounded-circle" 
             width="50" height="50">
        <span class="ml-2 font-weight-bold"><?php echo $data["teacher_name"] ?></span>
        <a href="../Guest/Logout.php" class="btn btn-sm btn-danger ml-3">Logout</a>
      </div>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!--================ End Header Menu Area =================-->

  <!--================ Start Home Banner Area =================-->
  <section class="home_banner_area">
    <div class="banner_inner">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="banner_content text-center">
              <p class="text-uppercase">
                Best online education service In the world
              </p>
              <h2 class="text-uppercase mt-4 mb-5">
                WHERE EDUCATION MEETS PATNERSHIP
              </h2>
              <div>

                <a href="TeacherProfile.php" class="primary-btn ml-sm-3 ml-0">PROFILE</a>
                <a href="Parent.php" class="primary-btn2 mb-3 mb-sm-0">ADD PARENT</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End Home Banner Area =================-->

  <!--================ Start Feature Area =================-->
  <section class="feature_area section_gap_top">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="main_title">
            <h2 class="mb-3">Awesome Feature</h2>
            <p>
              Replenish man have thing gathering lights yielding shall you
            </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="single_feature">
            <div class="icon"><span class="flaticon-student"></span></div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Scholarship Facility</h4>
              <p>
                One make creepeth, man bearing theira firmament won't great
                heaven
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="single_feature">
            <div class="icon"><span class="flaticon-book"></span></div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Sell Online Course</h4>
              <p>
                One make creepeth, man bearing theira firmament won't great
                heaven
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="single_feature">
            <div class="icon"><span class="flaticon-earth"></span></div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Global Certification</h4>
              <p>
                One make creepeth, man bearing theira firmament won't great
                heaven
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End Feature Area =================-->

  <!--================ Start Popular Courses Area =================-->
  <!-- <div class="popular_courses"> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="main_title">
              <h2 class="mb-3">Our Popular Courses</h2>
              <p>
                Replenish man have thing gathering lights yielding shall you
              </p>
            </div>
          </div>
        </div>
         <div class="row"> -->
  <!-- single course 
          <div class="col-lg-12">
            <div class="owl-carousel active_course">
              <div class="single_course">
                <div class="course_head">
                  <img class="img-fluid" src="../Assets/Templates/Main/img/courses/c1.jpg" alt="" />
                </div>
                <div class="course_content">
                  <span class="price">$25</span>
                  <span class="tag mb-4 d-inline-block">design</span>
                  <h4 class="mb-3">
                    <a href="course-details.html">Custom Product Design</a>
                  </h4>
                  <p>
                    One make creepeth man bearing their one firmament won't fowl
                    meat over sea
                  </p>
                  <div
                    class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4"
                  >
                    <div class="authr_meta">
                      <img src="../Assets/Templates/Main/img/courses/author1.png" alt="" />
                      <span class="d-inline-block ml-2">Cameron</span>
                    </div>
                    <div class="mt-lg-0 mt-3">
                      <span class="meta_info mr-4">
                        <a href="#"> <i class="ti-user mr-2"></i>25 </a>
                      </span>
                      <span class="meta_info"
                        ><a href="#"> <i class="ti-heart mr-2"></i>35 </a></span
                      >
                    </div>
                  </div>
                </div>
              </div>

              <div class="single_course">
                <div class="course_head">
                  <img class="img-fluid" src="../Assets/Templates/Main/img/courses/c2.jpg" alt="" />
                </div>
                <div class="course_content">
                  <span class="price">$25</span>
                  <span class="tag mb-4 d-inline-block">design</span>
                  <h4 class="mb-3">
                    <a href="course-details.html">Social Media Network</a>
                  </h4>
                  <p>
                    One make creepeth man bearing their one firmament won't fowl
                    meat over sea
                  </p>
                  <div
                    class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4"
                  >
                    <div class="authr_meta">
                      <img src="../Assets/Templates/Main/img/courses/author2.png" alt="" />
                      <span class="d-inline-block ml-2">Cameron</span>
                    </div>
                    <div class="mt-lg-0 mt-3">
                      <span class="meta_info mr-4">
                        <a href="#"> <i class="ti-user mr-2"></i>25 </a>
                      </span>
                      <span class="meta_info"
                        ><a href="#"> <i class="ti-heart mr-2"></i>35 </a></span
                      >
                    </div>
                  </div>
                </div>
              </div> -->

  <!-- <div class="single_course"> 
                <div class="course_head">
                  <img class="img-fluid" src="../Assets/Templates/Main/img/courses/c3.jpg" alt="" />
                </div>
                <div class="course_content">
                  <span class="price">$25</span>
                  <span class="tag mb-4 d-inline-block">design</span>
                  <h4 class="mb-3">
                    <a href="course-details.html">Computer Engineering</a>
                  </h4>
                  <p>
                    One make creepeth man bearing their one firmament won't fowl
                    meat over sea
                  </p>
                  <div
                    class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4"
                  >
                    <div class="authr_meta">
                      <img src="../Assets/Templates/Main/img/courses/author3.png" alt="" />
                      <span class="d-inline-block ml-2">Cameron</span>
                    </div>
                    <div class="mt-lg-0 mt-3">
                      <span class="meta_info mr-4">
                        <a href="#"> <i class="ti-user mr-2"></i>25 </a>
                      </span>
                      <span class="meta_info"
                        ><a href="#"> <i class="ti-heart mr-2"></i>35 </a></span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     </div> -->
  <!--================ End Popular Courses Area =================-->

  <!--================ Start Registration Area =================-->
  <!-- <div class="section_gap registration_area"> 
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <div class="row clock_sec clockdiv" id="clockdiv">
              <div class="col-lg-12">
                <h1 class="mb-3">Register Now</h1>
                <p>
                  There is a moment in the life of any aspiring astronomer that
                  it is time to buy that first telescope. It’s exciting to think
                  about setting up your own viewing station.
                </p>
              </div>
              <div class="col clockinner1 clockinner">
                <h1 class="days">150</h1>
                <span class="smalltext">Days</span>
              </div>
              <div class="col clockinner clockinner1">
                <h1 class="hours">23</h1>
                <span class="smalltext">Hours</span>
              </div>
              <div class="col clockinner clockinner1">
                <h1 class="minutes">47</h1>
                <span class="smalltext">Mins</span>
              </div>
              <div class="col clockinner clockinner1">
                <h1 class="seconds">59</h1>
                <span class="smalltext">Secs</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 offset-lg-1">
            <div class="register_form">
              <h3>Courses for Free</h3>
              <p>It is high time for learning</p>
              <form
                class="form_area"
                id="myForm"
                action="mail.html"
                method="post"
              >
                <div class="row">
                  <div class="col-lg-12 form_group">
                    <input
                      name="name"
                      placeholder="Your Name"
                      required=""
                      type="text"
                    />
                    <input
                      name="name"
                      placeholder="Your Phone Number"
                      required=""
                      type="tel"
                    />
                    <input
                      name="email"
                      placeholder="Your Email Address"
                      pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                      required=""
                      type="email"
                    />
                  </div>
                  <div class="col-lg-12 text-center">
                    <button class="primary-btn">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
     </div> -->
  <!--================ End Registration Area =================-->

  <!--================ Start Trainers Area =================-->
  <!-- <section class="trainer_area section_gap_top"> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="main_title">
              <h2 class="mb-3">Our Expert Trainers</h2>
              <p>
                Replenish man have thing gathering lights yielding shall you
              </p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center d-flex align-items-center">
          <div class="col-lg-3 col-md-6 col-sm-12 single-trainer">
            <div class="thumb d-flex justify-content-sm-center">
              <img class="img-fluid" src="../Assets/Templates/Main/img/trainer/t1.jpg" alt="" />
            </div>
            <div class="meta-text text-sm-center">
              <h4>Mated Nithan</h4>
              <p class="designation">Sr. web designer</p>
              <div class="mb-4">
                <p>
                  If you are looking at blank cassettes on the web, you may be
                  very confused at the.
                </p>
              </div>
              <div class="align-items-center justify-content-center d-flex">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-pinterest"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12 single-trainer">
            <div class="thumb d-flex justify-content-sm-center">
              <img class="img-fluid" src="../Assets/Templates/Main/img/trainer/t2.jpg" alt="" />
            </div>
            <div class="meta-text text-sm-center">
              <h4>David Cameron</h4>
              <p class="designation">Sr. web designer</p>
              <div class="mb-4">
                <p>
                  If you are looking at blank cassettes on the web, you may be
                  very confused at the.
                </p>
              </div>
              <div class="align-items-center justify-content-center d-flex">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-pinterest"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12 single-trainer">
            <div class="thumb d-flex justify-content-sm-center">
              <img class="img-fluid" src="../Assets/Templates/Main/img/trainer/t3.jpg" alt="" />
            </div>
            <div class="meta-text text-sm-center">
              <h4>Jain Redmel</h4>
              <p class="designation">Sr. Faculty Data Science</p>
              <div class="mb-4">
                <p>
                  If you are looking at blank cassettes on the web, you may be
                  very confused at the.
                </p>
              </div>
              <div class="align-items-center justify-content-center d-flex">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-pinterest"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12 single-trainer">
            <div class="thumb d-flex justify-content-sm-center">
              <img class="img-fluid" src="../Assets/Templates/Main/img/trainer/t4.jpg" alt="" />
            </div>
            <div class="meta-text text-sm-center">
              <h4>Nathan Macken</h4>
              <p class="designation">Sr. web designer</p>
              <div class="mb-4">
                <p>
                  If you are looking at blank cassettes on the web, you may be
                  very confused at the.
                </p>
              </div>
              <div class="align-items-center justify-content-center d-flex">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-pinterest"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
     </section> -->
  <!--================ End Trainers Area =================-->

  <!--================ Start Events Area =================-->
  <!-- <div class="events_area"> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="main_title">
              <h2 class="mb-3 text-white">Upcoming Events</h2>
              <p>
                Replenish man have thing gathering lights yielding shall you
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="single_event position-relative">
              <div class="event_thumb">
                <img src="../Assets/Templates/Main/img/event/e1.jpg" alt="" />
              </div>
              <div class="event_details">
                <div class="d-flex mb-4">
                  <div class="date"><span>15</span> Jun</div>

                  <div class="time-location">
                    <p>
                      <span class="ti-time mr-2"></span> 12:00 AM - 12:30 AM
                    </p>
                    <p>
                      <span class="ti-location-pin mr-2"></span> Hilton Quebec
                    </p>
                  </div>
                </div>
                <p>
                  One make creepeth man for so bearing their firmament won't
                  fowl meat over seas great
                </p>
                <a href="#" class="primary-btn rounded-0 mt-3">View Details</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="single_event position-relative">
              <div class="event_thumb">
                <img src="../Assets/Templates/Main/img/event/e2.jpg" alt="" />
              </div>
              <div class="event_details">
                <div class="d-flex mb-4">
                  <div class="date"><span>15</span> Jun</div>

                  <div class="time-location">
                    <p>
                      <span class="ti-time mr-2"></span> 12:00 AM - 12:30 AM
                    </p>
                    <p>
                      <span class="ti-location-pin mr-2"></span> Hilton Quebec
                    </p>
                  </div>
                </div>
                <p>
                  One make creepeth man for so bearing their firmament won't
                  fowl meat over seas great
                </p>
                <a href="#" class="primary-btn rounded-0 mt-3">View Details</a>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="text-center pt-lg-5 pt-3">
              <a href="#" class="event-link">
                View All Event <img src="../Assets/Templates/Main/img/next.png" alt="" />
              </a>
            </div>
          </div>
        </div>
      </div>
     </div> -->
  <!--================ End Events Area =================-->

  <!--================ Start Testimonial Area =================-->
  <!-- <div class="testimonial_area section_gap"> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="main_title">
              <h2 class="mb-3">Client say about me</h2>
              <p>
                Replenish man have thing gathering lights yielding shall you
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="testi_slider owl-carousel">
            <div class="testi_item">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <img src="../Assets/Templates/Main/img/testimonials/t1.jpg" alt="" />
                </div>
                <div class="col-lg-8">
                  <div class="testi_text">
                    <h4>Elite Martin</h4>
                    <p>
                      Him, made can't called over won't there on divide there
                      male fish beast own his day third seed sixth seas unto.
                      Saw from
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testi_item">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <img src="../Assets/Templates/Main/img/testimonials/t2.jpg" alt="" />
                </div>
                <div class="col-lg-8">
                  <div class="testi_text">
                    <h4>Davil Saden</h4>
                    <p>
                      Him, made can't called over won't there on divide there
                      male fish beast own his day third seed sixth seas unto.
                      Saw from
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testi_item">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <img src="../Assets/Templates/Main/img/testimonials/t1.jpg" alt="" />
                </div>
                <div class="col-lg-8">
                  <div class="testi_text">
                    <h4>Elite Martin</h4>
                    <p>
                      Him, made can't called over won't there on divide there
                      male fish beast own his day third seed sixth seas unto.
                      Saw from
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testi_item">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <img src="../Assets/Templates/Main/img/testimonials/t2.jpg" alt="" />
                </div>
                <div class="col-lg-8">
                  <div class="testi_text">
                    <h4>Davil Saden</h4>
                    <p>
                      Him, made can't called over won't there on divide there
                      male fish beast own his day third seed sixth seas unto.
                      Saw from
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testi_item">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <img src="../Assets/Templates/Main/img/testimonials/t1.jpg" alt="" />
                </div>
                <div class="col-lg-8">
                  <div class="testi_text">
                    <h4>Elite Martin</h4>
                    <p>
                      Him, made can't called over won't there on divide there
                      male fish beast own his day third seed sixth seas unto.
                      Saw from
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="testi_item">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <img src="../Assets/Templates/Main/img/testimonials/t2.jpg" alt="" />
                </div>
                <div class="col-lg-8">
                  <div class="testi_text">
                    <h4>Davil Saden</h4>
                    <p>
                      Him, made can't called over won't there on divide there
                      male fish beast own his day third seed sixth seas unto.
                      Saw from
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--================ End Testimonial Area =================-->

  <!--================ Start footer Area  =================-->
   <footer class="footer-area section_gap" style="background:#0b1c39; color:white; padding:40px 0;">
  <div class="container">
    <div class="row text-center mb-4">
      <div class="col-12">
        <!-- Logo & Name -->
        <img src="../Assets/Templates/Main/img/NewLogo.jpeg" alt="Eduport Logo" style="height:60px";>
        <h2 class="mt-2">Eduport</h2>
        <p>"Education is the passport to the future,<br>
        for tomorrow belongs to those who prepare for it today."</p>
      </div>
    </div>

    <div class="row text-left">
      <!-- Quick Links -->
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Courses</a></li>
          <li><a href="#">Admissions</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Careers</a></li>
        </ul>
      </div>

      <!-- Resources -->
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Resources</h4>
        <ul>
          <li><a href="#">Articles</a></li>
          <li><a href="#">Research</a></li>
          <li><a href="#">E-books</a></li>
          <li><a href="#">Student Stories</a></li>
          <li><a href="#">Alumni Network</a></li>
        </ul>
      </div>

      <!-- Contact Us -->
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Contact Us</h4>
        <p>📍 Address: Ilahia College of Arts and Science </p>
        <p>📞 Phone: +91-1234567890</p>
        <p>✉ Email: info@eduport.com</p>
        <p>🔗 Socials: 
          <a href="#"><i class="ti-facebook"></i></a>
          <a href="#"><i class="ti-twitter"></i></a>
          <a href="#"><i class="ti-linkedin"></i></a>
          <a href="#"><i class="ti-instagram"></i></a>
        </p>
      </div>
    </div>

    <hr style="background:white;">

    <div class="row text-left">
      <!-- Student Support -->
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Student Support</h4>
        <ul>
          <li><a href="#">FAQs</a></li>
          <li><a href="#">Scholarships</a></li>
          <li><a href="#">Study Material</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Newsletter</h4>
        <p>Stay updated with our latest news and offers.</p>
        <form action="#" method="post" class="form-inline">
          <input
            class="form-control"
            name="EMAIL"
            placeholder="Your Email Address"
            required
            type="email"
          />
          <button class="click-btn btn btn-default" style="background:gold; color:black; padding:5px 15px; margin-left:5px;">
            Subscribe
          </button>
        </form>
      </div>

      <!-- Social Media -->
      <div class="col-lg-4 col-md-6 single-footer-widget">
        <h4>Social Media</h4>
        <div class="footer-social">
          <a href="#"><i class="ti-facebook"></i></a>
          <a href="#"><i class="ti-twitter"></i></a>
          <a href="#"><i class="ti-dribbble"></i></a>
          <a href="#"><i class="ti-linkedin"></i></a>
        </div>
      </div>
    </div>

    <div class="row mt-4 text-center">
      <div class="col-12">
        <p>"The beautiful thing about learning is that no one<br>
        can take it away from you." – B.B. King</p>
        <p>© 2025 Eduport. All rights reserved</p>
        <p><small>Created by <b>Alfiya Bawa</b> & <b>Fathima Nasrin</b></small></p>
      </div>
    </div>
  </div>
</footer>
  <!--================ End footer Area  =================-->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../Assets/Templates/Main/js/jquery-3.2.1.min.js"></script>
  <script src="../Assets/Templates/Main/js/popper.js"></script>
  <script src="../Assets/Templates/Main/js/bootstrap.min.js"></script>
  <script src="../Assets/Templates/Main/vendors/nice-select/js/jquery.nice-select.min.js"></script>
  <script src="../Assets/Templates/Main/vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="../Assets/Templates/Main/js/owl-carousel-thumb.min.js"></script>
  <script src="../Assets/Templates/Main/js/jquery.ajaxchimp.min.js"></script>
  <script src="../Assets/Templates/Main/js/mail-script.js"></script>
  <!--gmaps Js-->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEYCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
  <script src="../Assets/Templates/Main/js/gmaps.min.js"></script>
  <script src="../Assets/Templates/Main/js/theme.js"></script>
</body>

</html>