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
   <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
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

<body class="inner_page contact_page">
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
                           <h2>Show Patient</h2>
                        </div>
                     </div>
                  </div>
                  <!-- row -->
                  <div class="row column1">
                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                           <div class="full graph_head">
                              <div class="heading1 margin_0">
                                 <h2>Patients</h2>
                              </div>
                           </div>
                           <div class="full price_table padding_infor_info">

                              <div class="row">

                                 <!-- column contact -->
                                 <?php
                                 include_once '../api/config/database.php';
                                 include_once '../api/objects/patient.php';
                                 $database = Database::getInstance();
                                 $db = $database->getConnection();
                                 $docs = new Patient($db);
                                 $data = $docs->SelsctAllPatient();

                                 for ($i = 0; $i < count($data); $i++) { ?>

                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 profile_details margin_bottom_30">

                                       <div class="contact_blog">

                                          <div class="contact_inner">
                                             <div class="left">
                                                <h3><?php echo $data[$i]['first_name'];
                                                      echo " ";
                                                      echo $data[$i]['last_name']; ?></h3>
                                                <p><strong>Gender: </strong><?php echo $data[$i]['gender']; ?></p>
                                                <ul class="list-unstyled">
                                                   <li><i class="fa fa-envelope"></i> : <?php echo $data[$i]['email']; ?></li>
                                                   <li><i class="fa fa-phone"></i> : <?php echo $data[$i]['phone_number']; ?></li>
                                                </ul>
                                             </div>
                                             <div class="right">
                                                <!-- <div class="profile_contacts">
                                                   <img class="img-responsive" src="images/layout_img/msg2.png" alt="#" />
                                                </div> -->
                                             </div>
                                             <div class="bottom_list">

                                                <div class="right_button">
                                                   <form action="../api/admin/deletepatient.php" method="POST">
                                                      <input name="delpat" value="<?php echo $data[$i]['id'] ?>" type="text" placeholder=<?php echo $data[$i]['id'] ?> style="display:none">
                                                      <button type="submit" class="btn btn-primary btn-xs">
                                                         <i class="fa fa-user"> </i> Delete
                                                      </button>
                                                </div>

                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 <?php  } ?>
                              </div>
                              <!-- end column contact blog -->


                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end row -->
               </div>
               <!-- footer -->
               <div class="container-fluid">
                  <div class="footer">
                     <p>Copyright © 2023. All rights reserved.<br><br>
                        Distributed By: <a href="#">Kerolus Soliman</a>
                     </p>
                  </div>
               </div>
            </div>
            <!-- end dashboard inner -->
         </div>
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