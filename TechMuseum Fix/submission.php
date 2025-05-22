<?php
$conn = new mysqli("localhost", "root", "", "techmuseum");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectName = $_POST['project_name'];
    $submissionDate = $_POST['submission_date'];
    $projectType = $_POST['project_type_details'];
    $description = $_POST['project_description'];
    $projectLink = $_POST['project_Link_details']; // ambil input link
    $supervisor = $_POST['supervisor'] ?? '';
    $creatorType = $_POST['creator_type'] ?? '';
    $name = $_POST['name'];
    $major = $_POST['major'];
    $batch = $_POST['batch'];
    $instagram = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $uploadSuccess = false;
    $targetFile = "";

    // Proses upload file jika ada
    if (isset($_FILES["project_file"]) && $_FILES["project_file"]["error"] == 0) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($_FILES["project_file"]["name"]);
        $targetFile = $uploadDir . time() . "_" . $fileName;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['zip', 'rar', 'pdf', 'docx', 'png', 'jpg', 'jpeg'];

        if (!in_array($fileType, $allowedTypes)) {
            $successMessage = "Hanya file dengan format: " . implode(", ", $allowedTypes) . " yang diperbolehkan.";
        } else {
            if (move_uploaded_file($_FILES["project_file"]["tmp_name"], $targetFile)) {
                $uploadSuccess = true;
            } else {
                $successMessage = "Gagal meng-upload file.";
            }
        }
    } else {
        // Jika tidak upload file, tetap lanjutkan tapi dengan targetFile kosong
        $uploadSuccess = true;
    }

    if ($uploadSuccess) {
        $stmt = $conn->prepare("INSERT INTO project_submissions (
    project_name, submission_date, project_type_details, project_description,
    project_link, supervisor, creator_type, name, major, batch,
    instagram, linkedin, phone, email, file_path
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssssssssss", 
  $projectName, $submissionDate, $projectType, $description,
  $projectLink, $supervisor, $creatorType, $name, $major, $batch, 
  $instagram, $linkedin, $phone, $email, $targetFile
);


        if ($stmt->execute()) {
            $successMessage = "Your project has been successfully submitted! We’ll get in touch with you soon with all the details. Thanks for sharing your work!";
        } else {
            $successMessage = "Gagal menyimpan ke database: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Submit Your Project</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 100px 40px 40px 40px;
      background-color: #f5f7fa;
      color: #333;
    }

    /* NAVBAR */
    .menu-bar {
      background-color: white;
      box-shadow: 0px 7px 21px rgba(0, 0, 0, 0.27);
      height: 60px;
      width: 90%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 5%;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 9999;
    }

    .menu-bar .logo img {
      width: 60px;
      height: 60px;
    }

    .menu-bar ul {
      list-style: none;
      display: flex;
      margin: 0;
      padding: 0;
    }

    .menu-bar ul li {
      padding: 10px 30px;
      position: relative;
    }

    .menu-bar ul li a {
      font-size: 17px;
      color: black;
      text-decoration: none;
      transition: all 0.3s;
    }

    .menu-bar ul li a:hover {
      color: #7d94c5;
    }

    .dropdown-menu {
  display: none;
}

.menu-bar ul li:hover .dropdown-menu {
  display: block;
  position: absolute;
  left: 0;
  top: 49px;
  background-color: white;
  box-shadow: 0px 7px 21px 0px rgba(0, 0, 0, 0.27);
        -webkit-box-shadow: 0px 7px 21px 0px rgba(0, 0, 0, 0.27);
        -moz-box-shadow: 0px 7px 21px 0px rgba(0, 0, 0, 0.27);
}

.menu-bar ul li:hover .dropdown-menu ul {
  display: block;
  margin: 10px;
}

.menu-bar ul li:hover .dropdown-menu ul li {
  width: 150px;
  padding: 10px;
}

.dropdown-menu-1 {
  display: none;
}

.dropdown-menu ul li:hover .dropdown-menu-1 {
  display: block;
  position: absolute;
  left: 150px;
  top: 0;
  background-color: black;
}

.menu-bar.scrolled {
  background-color: white !important;
  transition: background-color 0.3s ease;
}

    h1 {
      text-align: center;
      margin-bottom: 40px;
    }

    form {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"],
        textarea,
    select {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }

     h1 {
      text-align: center;
      margin-bottom: 40px;
    }

    form {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    legend {
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"],
    textarea,
    select {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    fieldset {
      border: none;
      margin-bottom: 20px;
      padding: 0;
    }

    .radio-group {
      margin-bottom: 10px;
    }


    a {
      color: #99a9d3;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .button-container {
      text-align: center;
  margin: 50px 0;
    }

    .submit-project-button {
      font-size: 1rem;
      color: #ffffff;
      background-color: #99a9d3;
      border: none;
      border-radius: 24px;
      padding: 10px 20px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .submit-project-button:hover {
      background-color: #bdaf95;
    }

    .drag-area {
      border: 2px dashed #999;
      padding: 30px;
      text-align: center;
      border-radius: 10px;
      margin-bottom: 20px;
      background-color: #fafafa;
      cursor: pointer;
      transition: border-color 0.3s ease;
    }

    .drag-area.active {
      border-color: #99a9d3;
      background-color: #f0f8ff;
    }

    .drag-area .icon {
      font-size: 50px;
      color: #99a9d3;
      margin-bottom: 10px;
    }

    .drag-area header {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .drag-area span {
      display: block;
      margin-bottom: 10px;
      color: #888;
    }

    .drag-area button {
      background-color: #99a9d3;
      border: none;
      padding: 10px 20px;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }

    .drag-area button:hover {
      background-color: #0056b3;
    }

    .button-container {
      text-align: center;
      margin-top: 40px;
    }

    .submit-project-button {
      font-size: 1rem;
      color: #ffffff;
      background-color: #99a9d3;
      border: none;
      border-radius: 24px;
      padding: 10px 20px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .submit-project-button:hover {
      background-color: #bdaf95;
    }
  </style>
</head>
<body>
  <!-- NAVBAR SECTION -->
  <div class="menu-bar">
    <a href="index.php" class="logo"><img src="media/logo.png" alt="Logo" /></a>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php">About</a></li>
      <li>
        <a href="#">Project <i class="fas fa-caret-down"></i></a>
        <div class="dropdown-menu">
          <ul>
            <li><a href="informatics.html">Informatics</a></li>
            <li><a href="information-system.html">Information System</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>

  <h1>Submit your project here!</h1>
  <?php if (!empty($successMessage)) echo "<p style='color: green; text-align:center;'>$successMessage</p>"; ?>

  <form method="POST" enctype="multipart/form-data">
    <legend>Project name:</legend>
    <input type="text" name="project_name" placeholder="Project Name" required />

    <legend>Date created:</legend>
    <input type="date" name="submission_date" required />

    <legend>Type of project:</legend>
    <input type="text" name="project_type_details" placeholder="Website/Application/Game/Etc" required />
    
    <legend>Description:</legend>
    <textarea name="project_description" rows="4" placeholder="Tell us about your project" required></textarea>
    
    <legend>Project Link:</legend>
    <input type="text" name="project_Link_details" placeholder="Google Drive Link" required />


    <fieldset>
      <legend>Creator Identity:</legend>
      <div class="radio-group">
        <input type="radio" id="personal" name="creator_type" value="personal" />
        <label for="personal">Personal</label><br />
        <input type="radio" id="group" name="creator_type" value="group" />
        <label for="group">Group</label>
      </div>
      <label for="name">Name:</label>
      <input type="text" name="name" placeholder="Creator Name" />
      <label for="major">Major:</label>
      <select name="major">
        <option value="informatics">Informatics</option>
        <option value="information system">Information System</option>
      </select>
      <label for="batch">Batch:</label>
      <input type="text" name="batch" placeholder="Batch" />
    </fieldset>

    <fieldset>
      <legend>Contact Person:</legend>
      <label for="instagram">Instagram:</label>
      <input type="text" name="instagram" placeholder="@username" />
      <label for="linkedin">LinkedIn:</label>
      <input type="text" name="linkedin" placeholder="LinkedIn Profile" />
      <label for="phone">Phone Number:</label>
      <input type="tel" name="phone" placeholder="Phone Number" />
      <label for="email">Email:</label>
      <input type="email" name="email" placeholder="Email Address" required />
    </fieldset>

    <div style="display: flex; align-items: center; gap: 10px;">
      <input type="checkbox" id="terms" name="terms" required style="width: 18px; height: 18px;" />
      <label for="terms">
        <a href="agree-disagree.php" style="text-decoration: none; color: #007BFF;">Agree to the terms and conditions</a>
      </label>
    </div>

    <div class="button-container">
      <button type="submit" class="submit-project-button">Submit</button>
    </div>
  </form>

  <script>
    const dragArea = document.querySelector(".drag-area");
    const fileInput = dragArea.querySelector("input[type='file']");
    const browseBtn = dragArea.querySelector(".browse-button");

    browseBtn.addEventListener("click", () => fileInput.click());

    dragArea.addEventListener("dragover", (e) => {
      e.preventDefault();
      dragArea.classList.add("active");
    });

    dragArea.addEventListener("dragleave", () => {
      dragArea.classList.remove("active");
    });

    dragArea.addEventListener("drop", (e) => {
      e.preventDefault();
      dragArea.classList.remove("active");
      fileInput.files = e.dataTransfer.files;
      if (fileInput.files.length > 0) {
        dragArea.querySelector("header").textContent = "Selected: " + fileInput.files[0].name;
      }
    });

    fileInput.addEventListener("change", () => {
      if (fileInput.files.length > 0) {
        dragArea.querySelector("header").textContent = "Selected: " + fileInput.files[0].name;
      }
    });
  </script>
</body>
</html>