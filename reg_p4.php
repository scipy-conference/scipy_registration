<?php
session_start();
?>

<!DOCTYPE html>
<html>
<?php $thisPage="Register"; ?>

<head>

<?php
//force redirect to secure page
if($_SERVER['SERVER_PORT'] != '443') { header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); exit(); }
?>

        <link rel="stylesheet" href="inc/validationEngine.jquery.css" type="text/css"/>
        <!-- <link rel="stylesheet" href="inc/template.css" type="text/css"/> -->
        <script src="inc/jquery-1.6.min.js" type="text/javascript">
        </script>
        <script src="inc/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
        </script>
        <script src="inc/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
        </script>
        <script>
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#formID").validationEngine();
            });
        </script>

<?php include('inc/header.php') ?>

<link rel="shortcut icon" href="http://conference.scipy.org/scipy2013/favicon.ico" />
<?php $thisPage="Register"; ?>
</head>

<body>

<div id="container">

<?php include('inc/page_headers.php') ?>

<section id="sidebar">
  <?php include("inc/sponsors.php") ?>
</section>


<section id="main-content">
<h1>Thank You!</h1>
<p>Thank you for registering for the SciPy 2013 Conference. You have been registered with the following information:</p>
<ul>
	<li>Name: <span class="bold"><?php echo $_GET['FirstName']; ?>  <?php echo $_GET['LastName']; ?></span> </li>
	<li>Email: <span class="bold"><?php echo $_GET['email']; ?></span> </li>
	<li>Rate: <span class="bold"><?php echo $_GET['Rate']; ?></span> </li>
</ul>
<p>Your order number is  <span class="bold"><?php echo $_GET['OrderNumber']; ?></span>. You will receive an email shortly that can serve as your receipt.</p>

<h2>Lodging</h2>
<p>AT&amp;T Executive Conference Center Hotel rooms are sold out. </p>

<p>Other lodging options:</p>

<p><a href="http://doubletree3.hilton.com/en/hotels/texas/doubletree-suites-by-hilton-hotel-austin-AUSFLDT/index.html">DoubleTree by Hilton Hotel Austin</a><br />
303 W. 15th Street<br />
Austin, TX 78701</p>

<p><a href="http://doubletree3.hilton.com/en/hotels/texas/doubletree-by-hilton-hotel-austin-university-area-AUSIMDT/index.html">DoubleTree by Hilton Hotel Austin - University Area</a><br />
1617 IH-35 North<br />
Austin, TX 78702</p>

<p><a href="http://www.starwoodhotels.com/sheraton/property/overview/index.html?propertyID=3079">Sheraton Austin Hotel at the Capitol</a><br />
701 East 11th Street<br />
Austin, TX 78701</p>

<p><a href="http://www.extendedstayamerica.com/property/extended-stay-america-austin-downtown-6th-st-hotel.html">Extended Stay America - Austin - Downtown - 6th St.</a><br />
600 Guadalupe St.<br />
Austin, TX 78701</p>

</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>