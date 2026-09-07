<?php
$page_title = 'Case Study | Omayma';
require_once __DIR__ . '/includes/db.php';
$contact_email = 'okhelfaoui23@gmail.com';

// Load the requested project (defaults to the most recent one, e.g. the bookstore)
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$project = null;

try {
    if ($slug !== '') {
        $stmt = db()->prepare('SELECT * FROM projects WHERE slug = ?');
        $stmt->execute([$slug]);
        $project = $stmt->fetch();
    }
    if (!$project) {
        $project = db()->query('SELECT * FROM projects ORDER BY created_at DESC LIMIT 1')->fetch();
    }

    // Load images for this project
    $images = [];
    if ($project) {
        $stmt = db()->prepare('SELECT * FROM project_images WHERE project_id = ? ORDER BY sort_order, id');
        $stmt->execute([$project['id']]);
        $images = $stmt->fetchAll();
    }
} catch (Exception $e) {
    // DB not set up yet — fall through with nulls
}

require __DIR__ . '/includes/header.php';
?>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox">
  <img id="lightboxImg" src="" alt="">
  <div class="lightbox-caption" id="lightboxCaption"></div>
</div>

<?php if ($project): ?>

<!-- CASE STUDY HERO -->
<section class="cs-hero">
  <div class="container">
    <span class="section-label">Case Study</span>
    <h1><?php echo htmlspecialchars($project['title']); ?></h1>
    <?php if (!empty($project['short_description'])): ?>
      <p class="cs-meta"><?php echo htmlspecialchars($project['short_description']); ?></p>
    <?php endif; ?>
    <?php if (!empty($project['live_url'])): ?>
      <a href="<?php echo htmlspecialchars($project['live_url']); ?>" target="_blank" rel="noopener" class="btn btn-primary">Visit Live Site <i class="fas fa-external-link-alt" style="margin-left:8px;"></i></a>
    <?php endif; ?>
  </div>
</section>

<section class="cs-layout">
  <div class="container">

    <div class="cs-body">

      <?php if (!empty($images)): ?>
        <div class="cs-gallery">
          <?php foreach ($images as $img): ?>
            <img src="<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($img['caption'] ?: $project['title']); ?>" loading="lazy">
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p style="color:var(--text-muted); font-style:italic;">Screenshots coming soon.</p>
      <?php endif; ?>

      <?php if (!empty($project['full_description'])): ?>
        <?php foreach (preg_split('/\n\s*\n/', trim($project['full_description'])) as $block): ?>
          <p><?php echo nl2br(htmlspecialchars(trim($block))); ?></p>
        <?php endforeach; ?>
      <?php else: ?>
        <h2>The Project</h2>
        <p><?php echo nl2br(htmlspecialchars($project['short_description'])); ?></p>
      <?php endif; ?>

      <p style="margin-top:40px;"><a href="index.php#contact" class="btn btn-primary">Want something like this built? Let's Work <i class="fas fa-arrow-right" style="margin-left:8px;"></i></a></p>

    </div>

    <!-- SIDEBAR -->
    <aside class="cs-sidebar">
      <h3>Project Snapshot</h3>
      <div class="meta-row">
        <div class="meta-label">Type</div>
        <div class="meta-value">Web Development</div>
      </div>
      <?php if (!empty($project['tech_used'])): ?>
        <div class="meta-row">
          <div class="meta-label">Stack</div>
          <div class="meta-value"><?php echo nl2br(htmlspecialchars($project['tech_used'])); ?></div>
        </div>
      <?php endif; ?>
      <?php if (!empty($project['live_url'])): ?>
        <div class="meta-row">
          <div class="meta-label">Live URL</div>
          <div class="meta-value"><a href="<?php echo htmlspecialchars($project['live_url']); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($project['live_url']); ?></a></div>
        </div>
      <?php endif; ?>
      <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($contact_email); ?>" target="_blank" rel="noopener" class="btn btn-primary">Ask Me About This</a>
    </aside>

  </div>
</section>

<?php else: ?>

<section class="cs-hero">
  <div class="container" style="text-align:center; padding:80px 0;">
    <h1>No Projects Yet</h1>
    <p class="cs-meta">Check back soon — I'm building my first case study.</p>
  </div>
</section>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
