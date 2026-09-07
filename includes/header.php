<?php
// Get optional page title passed from the including page
$page_title = isset($page_title) ? $page_title : 'Omayma — Freelance Web Developer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <meta name="description" content="Omayma builds websites and web experiences for small businesses and individuals. Web development with a UI/UX eye and video editing as a complement.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <a href="index.php" class="brand">Omayma<span class="brand-dot">.</span></a>
    <button class="nav-toggle" id="navToggle" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
    <nav class="site-nav" id="siteNav">
      <a href="index.php#home" class="nav-link">Home</a>
      <a href="index.php#work" class="nav-link">Work</a>
      <a href="index.php#about" class="nav-link">About</a>
      <a href="index.php#certificates" class="nav-link">Certificates</a>
      <a href="index.php#contact" class="nav-link">Contact</a>
      <a href="case-study.php" class="nav-link nav-link-accent">Case Study</a>
    </nav>
  </div>
</header>
<main>
