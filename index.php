<?php
$page_title = 'Omayma — Freelance Web Developer';
require_once __DIR__ . '/includes/db.php';

// Load editable settings from DB (fall back to defaults if not present)
$settings = [];
try {
    $stmt = db()->query('SELECT setting_key, setting_value FROM site_settings');
    foreach ($stmt->fetchAll() as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {
    // DB not ready yet — use defaults
}

// Load projects from the database for the Work section
$projects = [];
try {
    $projects = db()->query('SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC')->fetchAll();
} catch (Exception $e) {
    // table may not exist yet
}

// Load certificates for the Certificates section
$certificates = [];
try {
    $certificates = db()->query('SELECT * FROM certificates ORDER BY created_at DESC')->fetchAll();
} catch (Exception $e) {
    // table may not exist yet
}

$hero_heading    = isset($settings['hero_heading']) ? $settings['hero_heading'] : 'Welcome, I\'m <span class="highlight">Omayma</span>.';
$hero_subheading = isset($settings['hero_subheading']) ? $settings['hero_subheading'] : 'A Full-Stack Developer combining the precision of backend engineering with the beauty of frontend design. I transform creative ideas into living digital experiences delivered right on time.';
$about_text      = isset($settings['about_text']) ? $settings['about_text'] : 'I build web experiences that help small businesses and individuals turn visitors into customers.';
$contact_email   = isset($settings['contact_email']) ? $settings['contact_email'] : 'okhelfaoui23@gmail.com';

// Contact form handling
$form_status = null;
$form_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $message !== '') {
        $subject = 'Portfolio contact from ' . $name;
        $body = "Name: $name\nEmail: $email\n\n$message";
        $headers = "From: $email\r\nReply-To: $email";
        if (mail($contact_email, $subject, $body, $headers)) {
            $form_status = 'Thanks ' . htmlspecialchars($name) . '! Your message has been sent. I\'ll get back to you soon.';
            $form_type = 'success';
        } else {
            $form_status = 'There was a problem sending your message. Please try the direct email button instead.';
            $form_type = 'error';
        }
    } else {
        $form_status = 'Please fill in all fields with a valid email address.';
        $form_type = 'error';
    }
}

require __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="hero" id="home">
  <div class="container hero-grid">
    <div class="hero-text">
      <span class="hero-kicker">Freelance Web Developer</span>
      <h1><?php echo $hero_heading; ?></h1>
      <p class="hero-sub"><?php echo nl2br(htmlspecialchars($hero_subheading)); ?></p>
      <div class="hero-cta">
        <a href="#contact" class="btn btn-primary">Let's Work</a>
        <a href="#work" class="btn btn-outline">See My Work</a>
      </div>
    </div>

    <div class="hero-visual" aria-hidden="true">
      <!-- CSS 3D Computer Setup -->
      <div class="scene">
        <div class="computer">
          <!-- Monitor stand -->
          <div class="monitor-stand">
            <div class="stand-neck"></div>
            <div class="stand-base"></div>
          </div>
          <!-- Monitor -->
          <div class="monitor">
            <div class="monitor-front">
              <div class="screen">
                <div class="screen-glow"></div>
                <div class="code-line l1"><span class="c-purple">def</span> <span class="c-blue">hello_world</span>():</div>
                <div class="code-line l2">&nbsp;&nbsp;&nbsp;&nbsp;<span class="c-purple">print</span>(<span class="c-green">"hello world"</span>)</div>
                <div class="code-line l3">&nbsp;&nbsp;&nbsp;&nbsp;<span class="c-green"># building</span></div>
                <div class="code-line l3">&nbsp;&nbsp;&nbsp;&nbsp;<span class="c-green"># your idea</span></div>
                <div class="terminal-prompt l4"><span class="c-purple">&gt;&gt;&gt;</span> <span class="c-blink">_</span></div>
              </div>
              <div class="monitor-bar"><span class="dot d1"></span><span class="dot d2"></span><span class="dot d3"></span></div>
            </div>
            <div class="monitor-top"></div>
          </div>
          <!-- Keyboard -->
          <div class="keyboard">
            <div class="keys">
              <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
              <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>
          <!-- Mouse -->
          <div class="mouse">
            <div class="mouse-line"></div>
          </div>
          <!-- Desk -->
          <div class="desk"></div>
          <!-- Glows -->
          <div class="glow glow-purple"></div>
          <div class="glow glow-magenta"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WORK / CASE STUDY PREVIEW -->
<section class="section" id="work">
  <div class="container">
    <span class="section-label">Featured Work</span>
    <h2>Proof over promises</h2>
    <p class="section-sub">I back the copy with real, finished builds. Each one is documented end to end.</p>

    <?php if (!empty($projects)): ?>
      <?php foreach ($projects as $proj):
        // Grab the first image for the card thumbnail if it exists
        $thumb = null;
        try {
          $stmt = db()->prepare('SELECT image_path FROM project_images WHERE project_id = ? ORDER BY sort_order, id LIMIT 1');
          $stmt->execute([$proj['id']]);
          $thumb = $stmt->fetchColumn();
        } catch (Exception $e) {}
      ?>
      <div class="work-card" style="margin-bottom:32px;">
        <a href="case-study.php?slug=<?php echo urlencode($proj['slug']); ?>" class="work-card-image">
          <?php if ($thumb): ?>
            <img src="<?php echo htmlspecialchars($thumb); ?>" alt="<?php echo htmlspecialchars($proj['title']); ?> preview">
          <?php else: ?>
            <img src="assets/images/placeholder-bookstore.svg" alt="<?php echo htmlspecialchars($proj['title']); ?> preview">
          <?php endif; ?>
        </a>
        <div class="work-card-body">
          <h3><a href="case-study.php?slug=<?php echo urlencode($proj['slug']); ?>"><?php echo htmlspecialchars($proj['title']); ?></a></h3>
          <p><?php echo nl2br(htmlspecialchars($proj['short_description'])); ?></p>
          <?php if (!empty($proj['tech_used'])): ?>
            <div>
              <?php foreach (array_filter(array_map('trim', explode(',', $proj['tech_used']))) as $tech): ?>
                <span class="chip"><?php echo htmlspecialchars($tech); ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <p style="margin-top:16px;"><a href="case-study.php?slug=<?php echo urlencode($proj['slug']); ?>" class="link-arrow">Read the full case study <i class="fas fa-arrow-right"></i></a></p>
        </div>
      </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="work-card">
        <div class="work-card-body" style="text-align:center;">
          <h3>First project coming soon</h3>
          <p>My finished work will be documented here as it ships.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ABOUT / SKILLS -->
<section class="section" id="about">
  <div class="container">
    <span class="section-label">About Me</span>
    <h2>Who's behind the work</h2>

    <div class="about-grid">
      <div class="about-text">
        <p><?php echo nl2br(htmlspecialchars($about_text)); ?></p>
        <p>My focus is web development — building booking, ordering, and business sites that turn a visitor into a customer. I bring UI/UX design and video editing into every project as complementary strengths, so what you get isn't just code, it's a considered experience that looks good on any device.</p>
      </div>

      <div class="skills-list">
        <div class="skill-item">
          <div class="skill-head"><span class="skill-name"><i class="fas fa-code"></i>Web Development</span><span>90%</span></div>
          <div class="skill-bar"><div class="skill-fill" style="width:90%"></div></div>
        </div>
        <div class="skill-item">
          <div class="skill-head"><span class="skill-name"><i class="fas fa-pen-ruler"></i>UI/UX Design</span><span>80%</span></div>
          <div class="skill-bar"><div class="skill-fill" style="width:80%"></div></div>
        </div>
        <div class="skill-item">
          <div class="skill-head"><span class="skill-name"><i class="fas fa-video"></i>Video Editing</span><span>75%</span></div>
          <div class="skill-bar"><div class="skill-fill" style="width:75%"></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CERTIFICATES -->
<?php if (!empty($certificates)): ?>
<section class="section" id="certificates">
  <div class="container">
    <span class="section-label">Credentials</span>
    <h2>Certificates</h2>
    <p class="section-sub">Continuous learning, documented. Click a certificate to view it.</p>

    <div class="cert-grid">
      <?php foreach ($certificates as $cert): ?>
        <a href="<?php echo htmlspecialchars($cert['image_path']); ?>"
           target="_blank" rel="noopener" class="cert-card">
          <div class="cert-icon"><i class="fas fa-award"></i></div>
          <div class="cert-info">
            <h3><?php echo htmlspecialchars($cert['title']); ?></h3>
            <?php if (!empty($cert['issuer'])): ?>
              <p><?php echo htmlspecialchars($cert['issuer']); ?></p>
            <?php endif; ?>
            <?php if (!empty($cert['cert_date'])): ?>
              <span class="cert-date"><?php echo htmlspecialchars($cert['cert_date']); ?></span>
            <?php endif; ?>
          </div>
          <div class="cert-link"><i class="fas fa-external-link-alt"></i></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CONTACT -->
<section class="section" id="contact">
  <div class="container">
    <span class="section-label">Contact</span>
    <h2>Let's Work</h2>
    <p class="section-sub">Tell me what you want built and I'll get back to you with thoughts and a quote. Use the form, or email me directly — whichever's easier.</p>

    <div class="contact-grid">
      <form class="contact-form" method="post" action="index.php#contact">
        <?php if ($form_status): ?>
          <div class="<?php echo $form_type === 'success' ? 'form-success' : 'form-error'; ?>">
            <?php echo $form_status; ?>
          </div>
        <?php endif; ?>

        <div class="form-group">
          <label for="name">Your name</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Your email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="message">What do you want built?</label>
          <textarea id="message" name="message" rows="6" required placeholder="Describe the site or project you have in mind..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>

      <div class="contact-direct">
        <h3>Prefer email directly?</h3>
        <p>Skip the form. This opens Gmail with my address already filled in — just describe your project and hit send.</p>
        <a href="<?php echo 'https://mail.google.com/mail/?view=cm&fs=1&to=' . urlencode($contact_email); ?>"
           target="_blank" rel="noopener" class="btn btn-primary">
          <i class="fas fa-envelope"></i> Email Me Directly
        </a>
        <p style="font-size:0.85rem; opacity:0.8;"><?php echo htmlspecialchars($contact_email); ?></p>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
