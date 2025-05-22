<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "techmuseum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pertama definisikan query SQL
$sql = "SELECT name, image, review, rating FROM testimonials WHERE status='approved' ORDER BY id DESC";

// Kemudian eksekusi query
$result = $conn->query($sql);

$reviews = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
$conn->close();
?>

<?php
session_start();
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Tech Museum</title>
    <link rel="icon" href="media/logo.png" type="image/x-icon" />
    <!-- FONTS AND OTHERS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
    <!-- NAVBAR SECTION START -->
    <div class="menu-bar">
      <a href="#" class="logo"><img src="media/logo.png" /></a>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li>
          <a href="#">Project <i class="fas fa-caret-down"></i></a>

          <div class="dropdown-menu">
            <ul>
              <li><a href="informatics.html">Informatics</a></li>
              <li><a href="information-system.html">Information System</a></li>
            </ul>
          </div>
        </li>
        <li>
          <a href="login-admin.php">Admin</a>
          </div>
        </li>
      </ul>
    </div>
    <!-- NAVBAR SECTION FINISH -->

    <!-- HERO SECTION START -->
    <section class="wrapper-hero">
      <div class="hero"></div>
      <div class="content-hero">
        <h1 class="h1--scalingSize" data-text="An awesome title">
          Tech Museum
        </h1>
      </div>
    </section>
    <!-- HERO SECTION FINISH -->

    <!-- ABOUT SECTION START -->
    <div class="about">
      <img src="media/about.png" alt="" />
    </div>
    <!-- ABOUT SECTION FINISH -->
    
    <!-- US SECTION START -->
    <div class="us">
      <img src="media/us.png" alt="" />
    </div>
    <!-- US SECTION FINISH -->

    <!-- MOTIVATION SECTION START -->
<!-- MOTIVATION SECTION START -->
<div class="wrapper">
    <header>Inspirational Quote of the Day</header>
    <div class="content">
        <div class="quote-area">
            <i class="fas fa-quote-left"></i>
            <p class="quote">
                <?php
                // Get approved quotes from database
                $conn = new mysqli("localhost", "root", "", "techmuseum");
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }
                
                $sql = "SELECT quote, author FROM quotes WHERE status='approved' ORDER BY RAND() LIMIT 1";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo '"' . htmlspecialchars($row['quote']) . '"';
                    $author = htmlspecialchars($row['author']);
                } else {
                    echo '"Hardships often prepare ordinary people for an extraordinary destiny."';
                    $author = "C.S. Lewis";
                }
                $conn->close();
                ?>
            </p>
            <i class="fas fa-quote-right"></i>
        </div>
        <div class="author">
            <span class="name"><?php echo $author; ?></span>
        </div>
    </div>
    <div class="buttons">
        <button class="quote-btn" onclick="generateNewQuote()">
            <i class="fas fa-random"></i> Generate New Quote
        </button>
        <button class="quote-btn alt" onclick="showQuoteForm()">
            <i class="fas fa-pen"></i> Submit New Quote
        </button>
    </div>

    <div class="quote-form" id="quoteForm" style="display: none;">
        <input type="text" id="userQuote" placeholder="Enter your inspirational quote" required>
        <input type="text" id="userAuthor" placeholder="Author's Name (optional)">
        <button class="submit-btn" onclick="submitQuote()">Submit Quote</button>
    </div>
</div>
    <style>
      /* MOTIVATION SECTION START */
      .wrapper {
        position: absolute;
        top: 1650px;
        height: 360px;
        width: 900px;
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        
      }

      header {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
        color: #000000;
      }

      .content {
        margin: 30px 0;
      }

      .quote-area {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
      }

      .quote-btn {
  border: none;
  outline: none;
  font-size: 20px;
  color: white;
  border-radius: 30px;
  background: #647acb;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 300px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.quote-btn.alt {
  background: #bdaf95;
}

.quote-btn:hover {
  filter: brightness(1.1);
  transform: scale(1.03);
}

.quote-form {
  margin-top: 80px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  animation: fadeIn 0.3s ease-in-out;
        justify-content: center;
        text-align: center;
}

.quote-form input {
  padding: 10px 15px;
  width: 80%;
  max-width: 400px;
  border: 1px solid #ccc;
  border-radius: 20px;
  font-size: 14px;
  transition: 0.2s ease;
}

.quote-form input:focus {
  outline: none;
  border-color: #99a9d3;
  box-shadow: 0 0 5px rgba(153, 169, 211, 0.5);
}

.submit-btn {
  padding: 10px 20px;
  margin-top: 30px;
  border: none;
  background-color: #6a89cc;
  color: white;
  border-radius: 20px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-btn:hover {
  background-color: #3b5998;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.96);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}


      .quote-area i {
        font-size: 18px;
        color: #99a9d3;
      }

      .quote-area i:first-child {
        margin-right: 10px;
      }

      .quote-area i:last-child {
        margin-left: 10px;
      }

      .quote {
        font-size: 20px;
        color: #000000;
        word-wrap: break-word;
        padding: 0 15px;
      }

      .author {
        display: flex;
        justify-content: center;
        font-weight: bold;
        margin-top: 20px;
        font-size: 18px;
        color: #bdaf95;
        font-family: "Courier New", monospace;
      }

      .buttons {
        border-top: 1px solid #99a9d3;
        padding-top: 20px;
        display: flex;
        justify-content: center;
        border-top: 1px solid #99a9d3;
  flex-direction: column; /* tambahkan ini agar tombol vertikal */
  align-items: center;
  gap: 15px; /* jarak antar tombol */
      }

      .buttons button {
        border: none;
        outline: none;
        padding: 12px 20px;
        font-size: 16px;
        color: white;
        border-radius: 30px;
        background: #99a9d3;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .buttons button:hover {
        background: #bdaf95;
      }

      .buttons button.loading {
        opacity: 0.7;
        pointer-events: none;
      }
      /* MOTIVATION SECTION FINISH */
    </style>
    <script>
    // MOTIVATION SECTION START
    const quoteText = document.querySelector(".quote");
    const authorName = document.querySelector(".name");

    function generateNewQuote() {
        // AJAX request to get a new random quote
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "get_random_quote.php", true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                quoteText.innerText = `"${response.quote}"`;
                authorName.innerText = response.author || "Unknown";
            }
        };
        xhr.send();
    }

    function showQuoteForm() {
        const form = document.getElementById('quoteForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function submitQuote() {
        const quote = document.getElementById('userQuote').value;
        const author = document.getElementById('userAuthor').value;

        if (quote.trim() === "") {
            alert("Please enter a quote.");
            return;
        }

        // AJAX request to PHP
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "submit_quote.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Success: hide form and clear inputs
                document.getElementById('quoteForm').style.display = 'none';
                document.getElementById('userQuote').value = "";
                document.getElementById('userAuthor').value = "";
                alert("Quote submitted for approval. Thank you!");
            } else {
                alert("Error submitting quote.");
            }
        };
        xhr.send("quote=" + encodeURIComponent(quote) + "&author=" + encodeURIComponent(author));
    }
</script>
    <!-- MOTIVATION SECTION FINISH -->

    <!-- INFORMATICS SECTION START -->
    <div class="tittle-it">
      <h1>Informatics Project</h1>
    </div>
    <div class="project-it">
       <!-- Card 1 -->
    <div class="article-card">
      <div class="content">
        <a href="projectIT1.html">
        <p class="type">Application</p>
        <p class="title">Stay Healthy</p>
      </div>
      <img src="media/projectIT1.png" alt="Project 1" />
    </div>
    <!-- Card 2 -->
    <div class="article-card">
      <div class="content">
        <a href="projectIT2.html">
        <p class="type">Website</p>
        <p class="title">Cake Shop</p>
      </div>
      <img src="media/projectIT2.png" alt="Project 2" />
    </div>
    <!-- Card 3 -->
    <div class="article-card">
      <div class="content">
        <a href="projectIT3.html">
        <p class="type">Website</p>
        <p class="title">Reality999</p>
      </div>
      <img src="media/projectIT3.png" alt="Project 3" />
    </div>
         <!-- "More Project" Button -->
        <div class="button-container">
          <a href="informatics.html" class="more-project-button">More Project</a>
        </div>
      </div>
  </div>
    <!-- INFORMATICS SECTION FINISH -->

    <!-- IS SECTION START -->
     <div class="tittle-is">
      <h1>Information System Project</h1>
    </div>
    <div class="project-is">
       <!-- Card 1 -->
    <div class="article-card">
      <div class="content">
        <a href="projectIS1.html">
        <p class="type">Application</p>
        <p class="title">Application for PUMA IS</p>
      </div>
      <img src="media/projectIS1.png" alt="Project 1" />
    </div>
    <!-- Card 2 -->
    <div class="article-card">
      <div class="content">
        <a href="projectIS2.html">
        <p class="type">Website</p>
        <p class="title">Harmoni rasa Bandung</p>
      </div>
      <img src="media/Harmoni Bandung mini.png" alt="Project 2" />
    </div>
    <!-- Card 3 -->
    <div class="article-card">
      <div class="content">
        <a href="projectIS3.html">
        <p class="type">Website</p>
        <p class="title">Jewlery and Gift</p>
      </div>
      <img src="media/jewelque.jpg" alt="Project 3" />
    </div>
         <!-- "More Project" Button -->
        <div class="button-container">
          <a href="information-system.html" class="more-project-button">More Project</a>
        </div>
      </div>
  </div>
    <!-- IS SECTION FINISH -->

    <!-- TESTIMONIALS SECTION START -->
    
      <style>
  .tittle-testimonial h1 {
  position: absolute;
  top: 3250px;
  margin-bottom: 20px;
  transform: translate(-50%, -50%);
  justify-content: center;
  align-items: center;
  display: flex;
  text-align: center;
  margin-top: 80px;
  font-size: 32px;
}

    .average-rating {
      text-align: center;
      font-size: 18px;
      margin-bottom: 20px;
      display: flex;
  align-items: center;
  gap: 35px;
  padding: 30px;
  position: absolute;
  top: 3300px;
  justify-content: center;
  margin: 20px 0;
}

.testimonial-carousel {
      top: 3400px;
      position: absolute;
      width: 80%;
  overflow: hidden;
  padding: 20px 0;
  position: absolute;
  
    }
    
    .testimonial-list {
  display: flex;
  gap: 30px;
  transition: transform 0.5s ease-in-out;

}

.container-testimonial {
  display: flex;
  justify-content: center;
}

.carousel-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  margin-top: 20px;
  width: 100%;
}

.carousel-controls .prev,
.carousel-controls .next {
  color: #000000;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  padding: 10px 20px;
  font-size: 24px;
  cursor: pointer;
  background-color: #fff;
}



.carousel-controls .prev:active,
.carousel-controls .next:active {
  transform: scale(0.95);
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

.add-review {
  margin: 60px auto;
  padding: 20px;
  max-width: 600px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
  top: 3600px;

  position: absolute;
        
}

.add-review h2 {
  text-align: center;
  margin-bottom: 20px;
}

.add-review form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.add-review input,
.add-review textarea,
.add-review select {
  padding: 12px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  width: 100%;
  box-sizing: border-box;
}

.add-review button {
  background-color: #99a9d3;
  color: white;
  border: none;
  padding: 12px;
  cursor: pointer;
}

.add-review button:hover {
  background-color: #bdaf95;
}

.char-count {
  font-size: 12px;
  text-align: right;
  color: #666;
}
  </style>

  <div class="tittle-testimonial">
      <h1>What they said about us?</h1>
    </div>
  <div class="average-rating">
    Average Rating: <span id="avg-rating">0</span> ★
  </div>
  <div class="container-testimonial"> 
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

  <footer>
        <div class="footer-container">
            <!-- Social Media Links -->
            <div class="row social-links">
                <a href="https://wa.me/6283835361971" target="_blank"><i class="fa fa-whatsapp"></i></a>
                <a href="https://www.instagram.com/informatics_presuniv?igsh=NWVsdnN4dmpkZm5k" target="_blank"><i class="fa fa-instagram"></i></a>
            </div>
    
            <!-- Navigation Links -->
            <div class="row navigation-links">
                <ul>
                    <li><a href="https://wa.me/6283835361971" target="_blank">Contact Us</a></li>
                </ul>
            </div>
    
            <!-- Copyright Info -->
            <div class="row copyright">
                Tech Museum Copyright © 2024 All rights reserved
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION FINISH -->

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

    <!-- TESTIMONIALS SECTION FINISH -->
  </body>
 
</html>
