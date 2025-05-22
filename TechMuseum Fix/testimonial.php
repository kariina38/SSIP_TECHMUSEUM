<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "techmuseum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data testimoni
$sql = "SELECT name, image, review, rating FROM testimonials ORDER BY id DESC";
$result = $conn->query($sql);

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Testimonial Carousel</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 40px 20px;
    }

    h1 {
      text-align: center;
      margin-bottom: 10px;
    }

    .average-rating {
      text-align: center;
      font-size: 18px;
      margin-bottom: 20px;
    }

    .testimonial-carousel {
      position: relative;
      width: 80%;
      margin: 0 auto;
      overflow: hidden;
    }

    .testimonial-list {
      display: flex;
      transition: transform 0.5s ease-in-out;
      gap: 30px;
    }

    .testimonial-card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      min-width: 300px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      margin-bottom: 20px;
    }

    .testimonial-header {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .profile-img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
    }

    .author-info {
      display: flex;
      flex-direction: column;
    }

    .stars {
      color: gold;
      font-size: 18px;
    }

    .testimonial-text {
      font-style: italic;
      font-size: 16px;
      line-height: 1.6;
      margin-top: 10px;
    }

    .carousel-controls {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .prev, .next {
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      padding: 12px;
      border: none;
      cursor: pointer;
      font-size: 24px;
      border-radius: 50%;
    }

    .add-review {
      max-width: 400px;
      margin: 40px auto 0;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .add-review input,
    .add-review textarea,
    .add-review select,
    .add-review button {
      width: 90%;
      margin-bottom: 12px;
      padding: 10px;
      font-size: 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .char-count {
      font-size: 12px;
      text-align: right;
      color: #666;
    }
  </style>
</head>
<body>
  <h1>What they said about us?</h1>
  <div class="average-rating">
    Average Rating: <span id="avg-rating">0</span> ★
  </div>

  <div class="testimonial-carousel" id="testimonial-carousel">
    <div class="testimonial-list" id="testimonial-list">
      <?php foreach ($reviews as $r): ?>
        <div class="testimonial-card">
          <div class="testimonial-header">
            <img class="profile-img" src="<?= htmlspecialchars($r['image']) ?>" alt="<?= htmlspecialchars($r['name']) ?>">
            <div class="author-info">
              <strong><?= htmlspecialchars($r['name']) ?></strong>
              <div class="stars"><?= str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']) ?></div>
            </div>
          </div>
          <div class="testimonial-text"><?= htmlspecialchars($r['review']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="carousel-controls">
      <button class="prev" onclick="moveCarousel('prev')">❮</button>
      <button class="next" onclick="moveCarousel('next')">❯</button>
    </div>
  </div>

  <div class="add-review">
    <h3>Add Your Review</h3>
    <form method="POST" action="submit_review.php" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Your Name" required />
  <input type="file" name="image" accept=".jpg, .jpeg, .png" />

      <label for="rating">Rating:</label>
      <select name="rating" required>
        <option value="">Choose</option>
        <option value="1">1 ★</option>
        <option value="2">2 ★★</option>
        <option value="3">3 ★★★</option>
        <option value="4">4 ★★★★</option>
        <option value="5">5 ★★★★★</option>
      </select>
      <textarea name="review" rows="4" placeholder="Your Review (max 150 chars)" maxlength="150" required></textarea>
      <div class="char-count" id="char-count">0/150</div>
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    let currentIndex = 0;
    const cards = document.querySelectorAll(".testimonial-card");

    function moveCarousel(direction) {
      if (direction === 'next') {
        currentIndex = (currentIndex + 1) % cards.length;
      } else {
        currentIndex = (currentIndex - 1 + cards.length) % cards.length;
      }
      const offset = -currentIndex * 340;
      document.getElementById("testimonial-list").style.transform = `translateX(${offset}px)`;
    }

    // Hitung rata-rata rating
    window.addEventListener('DOMContentLoaded', () => {
      const stars = document.querySelectorAll(".testimonial-card .stars");
      let total = 0;
      stars.forEach(star => {
        total += (star.textContent.match(/★/g) || []).length;
      });
      const avg = stars.length ? (total / stars.length).toFixed(1) : "0";
      document.getElementById("avg-rating").textContent = avg;

      // Hitung karakter review
      document.querySelector("textarea[name='review']").addEventListener("input", (e) => {
        document.getElementById("char-count").textContent = `${e.target.value.length}/150`;
      });
    });
  </script>
</body>
</html>
