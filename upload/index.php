<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php include  $_SERVER['DOCUMENT_ROOT'] . "/modules/head/head.html";?>
<!-- SEO Meta -->
  <title>File Upload Portal</title>
  <meta name="description" content="This is a secure file upload facility"/>
<!-- SEO Meta End -->
</head>
<body class="body">
<header class="header">
</header>
<main class="main">
  <div class="flexbox flexbox-half">
	<div class="content">

	  <?php include  $_SERVER['DOCUMENT_ROOT'] . "/modules/formUpload/formUpload.html";?>
	  <script src="/modules/formUpload/formUpload.js"></script>

	</div>
  </div>
</main>
<footer class="footer">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/modules/footer/footer.html";?>
</footer>
</body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/modules/herringbone/herringbone.html";?>
  <script src="/modules/herringbone/herringbone.js"></script>
</html>