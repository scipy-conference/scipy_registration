<?php
session_start();



?>

<!DOCTYPE html>
<html>
<?php $thisPage="Register"; ?>
<head>

<?php include('inc/force_ssl.php') ?>


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

</head>

<body>

<div id="container">

<?php include('inc/page_headers.php') ?>

<section id="sidebar">
&nbsp;
</section>


<section id="main-content">

<h1>2014 Conference Registration</h1>

<p class="left">Registration for SciPy2013 is now closed. Registration was well above plan this year, and we've reached the limit we can handle at this year's venue.</p>

<p>We're very sorry if you've missed out. We will expand our venue for 2014 and would love to see you there.</p>

<p class="asterisk_text">Refund Policy: 100% refund until Sunday, June 9th.  Effective Monday, June 10th we provide 50% and after Friday, June 21st there are no refunds.</p>

</section>
<div style="clear:both;"></div>
<footer id="page_footer">
<?php include('inc/page_footer.php') ?>
</footer>
</div>
</body>

</html>