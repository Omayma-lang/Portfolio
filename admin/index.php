<?php
$page_title = 'Admin — Add New Project | Omayma';
require_once __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/header.php';

// Note: header.php uses relative paths (assets/...) which resolve
// incorrectly from the admin/ subfolder. Override the base path.
// We'll just render a minimal separate layout here instead.

$added = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title             = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description  = trim($_POST['full_description'] ?? '');
    $tech_used         = trim($_POST['tech_used'] ?? '');
    $live_url          = trim($_POST['live_url'] ?? '');

    if ($title === '' || $short_description === '') {
        $error = 'Title and short description are required.';
    } else {
        // Build a slug from the title for clean URLs / folders
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($title)), '-'));
        if ($slug === '') $slug = 'project-' . time();
        // Make slug unique
        $base = $slug; $i = 1;
        $stmt = db()->prepare('SELECT id FROM projects WHERE slug = ?');
        while (true) {
            $stmt->execute([$slug]);
            if (!$stmt->fetch()) break;
            $slug = $base . '-' . ($i++);
        }

        // Insert project
        $stmt = db()->prepare(
            'INSERT INTO projects (title, slug, short_description, full_description, tech_used, live_url)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$title, $slug, $short_description, $full_description, $tech_used, $live_url]);
        $project_id = db()->lastInsertId();

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $dir = __DIR__ . '/../assets/images/projects/' . $slug;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $files = $_FILES['images'];
            $count = count($files['name']);

            // Parse comma-separated captions into an array aligned with the upload order
            $captions = trim($_POST['captions'] ?? '');
            $captions = $captions !== '' ? array_map('trim', explode(',', $captions)) : [];

            $order = 0;
            for ($i = 0; $i < $count; $i++) {
                if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                $tmp = $files['tmp_name'][$i];
                $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array($ext, $allowed)) continue;

                $filename = time() . '-' . $i . '.' . $ext;
                $dest = $dir . '/' . $filename;
                if (move_uploaded_file($tmp, $dest)) {
                    $web_path = 'assets/images/projects/' . $slug . '/' . $filename;
                    $caption = $captions[$order] ?? '';
                    $stmt = db()->prepare(
                        'INSERT INTO project_images (project_id, image_path, caption, sort_order) VALUES (?, ?, ?, ?)'
                    );
                    $stmt->execute([$project_id, $web_path, $caption, $order]);
                    $order++;
                }
            }
        }

        $added = true;
    }
}

// List existing projects for reference
$projects = [];
try {
    $projects = db()->query('SELECT id, title, slug, created_at FROM projects ORDER BY created_at DESC')->fetchAll();
} catch (Exception $e) {
    // table may not exist yet
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Add New Project</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="padding-top:20px;">
<div class="container admin-wrap">
  <div class="admin-head">
    <h1>Admin Panel</h1>
    <p>Add a new project or site. It will appear on the portfolio automatically.</p>
  </div>

  <nav style="margin-bottom:28px;">
    <a href="../index.php" class="btn btn-outline" style="padding:9px 20px;">← View Site</a>
    <a href="index.php" class="btn btn-primary" style="padding:9px 20px;">Add New Project</a>
  </nav>

  <?php if ($error): ?>
    <div class="form-error" style="margin-bottom:20px;"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if ($added): ?>
    <div class="form-success" style="margin-bottom:20px;">
      Project added successfully! <a href="../case-study.php" style="text-decoration:underline;">View the site</a> or add another.
    </div>
  <?php endif; ?>

  <form class="admin-form" method="post" action="index.php" enctype="multipart/form-data">
    <div>
      <label>Project / Site Title *</label>
      <input type="text" name="title" required placeholder="e.g. Bakery Ordering Site">
    </div>

    <div>
      <label>Short Description *</label>
      <textarea name="short_description" rows="3" required placeholder="One or two lines shown on the home page card."></textarea>
    </div>

    <div>
      <label>Full Description (case study body)</label>
      <textarea name="full_description" rows="8" placeholder="Problem, approach, design decisions, tech used, what you'd improve. Use blank lines between paragraphs."></textarea>
    </div>

    <div>
      <label>Tech Used (comma separated, e.g. PHP, MySQL, JavaScript)</label>
      <input type="text" name="tech_used" placeholder="PHP, MySQL, JavaScript">
    </div>

    <div>
      <label>Live URL</label>
      <input type="text" name="live_url" placeholder="https://your-site.com">
    </div>

    <div>
      <label>Screenshots (select multiple)</label>
      <input type="file" name="images[]" id="images" accept="image/*" multiple class="file-input">
      <div class="image-preview-list" id="imagePreview"></div>
    </div>

    <div>
      <label>Image captions (optional — one per screenshot, comma separated, in order)</label>
      <input type="text" name="captions" placeholder="Homepage, Product page, Admin panel">
    </div>

    <button type="submit" class="btn btn-primary">Add Project</button>
  </form>

  <?php if (!empty($projects)): ?>
    <div style="margin-top:50px;">
      <h3 style="font-family:var(--font-display); margin-bottom:14px;">Existing Projects</h3>
      <table style="width:100%; border-collapse:collapse; font-size:0.95rem;">
        <thead>
          <tr style="color:var(--text-muted); text-align:left;">
            <th style="padding:10px; border-bottom:1px solid var(--border);">Title</th>
            <th style="padding:10px; border-bottom:1px solid var(--border);">Slug</th>
            <th style="padding:10px; border-bottom:1px solid var(--border);">Added</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($projects as $p): ?>
            <tr>
              <td style="padding:10px; border-bottom:1px solid var(--border);"><?php echo htmlspecialchars($p['title']); ?></td>
              <td style="padding:10px; border-bottom:1px solid var(--border);"><?php echo htmlspecialchars($p['slug']); ?></td>
              <td style="padding:10px; border-bottom:1px solid var(--border);"><?php echo htmlspecialchars($p['created_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
