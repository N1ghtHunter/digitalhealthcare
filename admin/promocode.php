<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Admin Generate promocode</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="images/fevicon.png" type="image/png" />
   <!-- bootstrap css -->
   <link rel="stylesheet" href="css/bootstrap.min.css" />
   <!-- site css -->
   <link rel="stylesheet" href="css/style2.css" />
   <!-- responsive css -->
   <link rel="stylesheet" href="css/responsive.css" />
   <!-- color css -->
   <link rel="stylesheet" href="css/colors.css" />
   <!-- select bootstrap -->
   <link rel="stylesheet" href="css/bootstrap-select.css" />
   <!-- scrollbar css -->
   <link rel="stylesheet" href="css/perfect-scrollbar.css" />
   <!-- custom css -->
   <link rel="stylesheet" href="css/custom.css" />
   <!-- calendar file css -->
   <link rel="stylesheet" href="js/semantic.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body class="inner_page widgets">
   <div class="full_container">
      <div class="inner_container">
         <!-- Sidebar  -->
         <nav id="sidebar">
            <div class="sidebar_blog_1">
               <div class="sidebar-header">
                  <div class="logo_section">
                     <a href="index.html"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
                  </div>
               </div>
               <div class="sidebar_user_info">
                  <div class="icon_setting"></div>
                  <div class="user_profle_side">
                     <!-- <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div> -->
                     <div class="user_info">
                        <h6>John David</h6>

                     </div>
                  </div>
               </div>
            </div>
            <div class="sidebar_blog_2">
               <h4>General</h4>
               <ul class="list-unstyled components">
                  <li class="active">
                     <a href="home.php"><i class="fa fa-home white_color"></i> <span>Home</span></a>
                  </li>
                  <li><a href="request.php"><i class="fa fa-clock orange_color"></i> <span>Requests</span></a></li>

                  <li><a href="promocode.php"><i class="fa fa-table purple_color2"></i> <span>Promo Code</span></a></li>

                  <li>
                     <a href="showdoctors.php">
                        <i class="fa fa-users red_color"></i> <span>Doctors</span></a>
                  </li>
                  <li>
                     <a href="showpatient.php">
                        <i class="fa fa-users green_color"></i> <span>Patients</span></a>
                  </li>
               </ul>
            </div>
         </nav>
         <!-- end sidebar -->
         <!-- right content -->
         <div id="content">
            <!-- topbar -->
            <div class="topbar">
               <nav class="navbar navbar-expand-lg navbar-light">
                  <div class="full">
                     <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                     <div class="logo_section">
                        <a href="index.html"><img class="img-responsive" src="../image/logo1.png" alt="#" /></a>
                     </div>
                     <div class="right_topbar">
                        <div class="icon_info">

                           <form action="../api/admin/logout.php" method="POST">
                              <button type="submit" class="btn btn-secondary py-2 px-4 ms-3">Logout</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </nav>
            </div>
            <!-- end topbar -->
            <!-- dashboard inner -->
            <div class="midde_cont">
               <div class="container-fluid">
                  <div class="row column_title">
                     <div class="col-md-12">
                        <div class="page_title">
                           <h2>Generate Promo Code</h2>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="formbold-main-wrapper">
               <!-- Author: FormBold Team -->
               <!-- Learn More: https://formbold.com -->
               <div class="formbold-form-wrapper">
                  <form action="../api/promocode/promocodes.php" method="POST" id="formpromo">
                     <?php

                     function generate_promo_code()
                     {
                        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        $promo_code = '';
                        for ($i = 0; $i < 8; $i++) {
                           $promo_code .= $chars[rand(0, strlen($chars) - 1)];
                        }
                        return $promo_code;
                     }

                     ?>
                     <div class="formbold-input-flex">
                        <div>
                           <label for="promocode" class="formbold-form-label"> Promo Code </label>
                           <input type="text" id="promo-code" name="promo_code" placeholder="promo_code" value="<?php echo generate_promo_code(); ?>" readonly class="formbold-form-input" />
                        </div>
                        <div>
                           <label for="Discount" class="formbold-form-label"> Discount </label>
                           <input type="number" id="discount" name="discount" min="10" max="100" step="5" required class="formbold-form-input" />
                        </div>
                     </div>

                     <div class="formbold-input-flex">
                        <div>
                           <label for="Expiration Date" class="formbold-form-label"> Expiration Date </label>
                           <input type="date" id="expiration-date" name="expiration_date" required class="formbold-form-input" />
                        </div>
                     </div>
                     <button type="submit" class="formbold-btn">
                        Generate
                     </button>
                  </form>
               </div>
            </div>
            <!-- footer -->
            <div class="container-fluid">
               <div class="footer">
                  <p>Copyright © 2023. All rights reserved.</p>
               </div>
            </div>
         </div>
         <!-- end dashboard inner -->
      </div>
   </div>
   </div>
   <!-- jQuery -->
   <script src="js/jquery.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <!-- wow animation -->
   <script src="js/animate.js"></script>
   <!-- select country -->
   <script src="js/bootstrap-select.js"></script>
   <!-- owl carousel -->
   <script src="js/owl.carousel.js"></script>
   <!-- chart js -->
   <script src="js/Chart.min.js"></script>
   <script src="js/Chart.bundle.min.js"></script>
   <script src="js/utils.js"></script>
   <script src="js/analyser.js"></script>
   <!-- nice scrollbar -->
   <script src="js/perfect-scrollbar.min.js"></script>
   <script>
      var ps = new PerfectScrollbar('#sidebar');
   </script>
   <!-- custom js -->
   <script src="js/custom.js"></script>
   <!-- calendar file css -->
   <script src="js/semantic.min.js"></script>
   <script></script>
</body>

</html>