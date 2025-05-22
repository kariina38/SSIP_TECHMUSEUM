<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $consent = isset($_POST['consent']) ? $_POST['consent'] : 'no';
    // Here, you can process the data (e.g., save it to a database, send an email, etc.)
    if ($consent == 'agree') {
        $message = "Thank you for agreeing to the submission rules!";
    } else {
        $message = "You must agree to the submission rules to proceed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Informatics Project</title>
    <link rel="icon" href="media/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
      }

      /* NAVBAR SECTION START */
      .menu-bar .logo img {
        width: 60px;
        height: 60px;
      }

      .menu-bar {
        background-color: white;
        box-shadow: 0px 7px 21px 0px rgba(0, 0, 0, 0.27);
        -webkit-box-shadow: 0px 7px 21px 0px rgba(0, 0, 0, 0.27);
        -moz-box-shadow: 0px 7px 21px 0px rgba(0, 0, 0, 0.27);
        height: 60px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%;
        position: fixed;
        z-index: 9999;
        top: 0;
      }

      .menu-bar ul {
        list-style: none;
        display: flex;
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

      .fas {
        float: right;
        margin-left: 10px;
        padding-top: 3px;
      }

      /* dropdown menu style */
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
      /* RULES SECTION */
      .rules-section {
        max-width: 800px;
        margin: 100px auto 50px;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
      }

      .rules-section h2 {
        margin-bottom: 20px;
        text-align: center;
      }

      .rules-section table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
      }

      .rules-section table, .rules-section th, .rules-section td {
        border: 1px solid #ccc;
      }

      .rules-section th, .rules-section td {
        padding: 10px;
        text-align: left;
      }

      .rules-section ol, .rules-section ul {
        margin: 10px 0 20px 20px;
      }

      .agree-disagree {
        text-align: center;
        margin-top: 30px;
      }

      .agree-disagree p {
        margin-bottom: 15px;
        font-size: 18px;
      }

      .agree-disagree .option {
        display: inline-block;
        margin: 0 20px;
        font-size: 16px;
        cursor: pointer;
      }

      .agree-disagree input[type="radio"] {
        margin-right: 8px;
      }

      .agree-disagree button {
        display: block;
        margin: 30px auto 0;
        padding: 10px 30px;
        font-size: 16px;
        background-color: #7d94c5;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .agree-disagree button:hover {
        background-color: #5c78a6;
      }

      /* FOOTER SECTION */
      footer {
        margin-top: 50px;
        padding: 20px 0;
        background-color: white;
        text-align: center;
      }

      .footer-container {
        color: gray;
        text-align: center;
      }

      .footer-container .row {
        width: 100%;
        margin: 10px 0;
      }

      .footer-container .row a {
        text-decoration: none;
        color: gray;
        transition: color 0.3s ease;
      }

      .footer-container .row a:hover {
        color: #7181ad;
      }

      .footer-container .row ul {
        padding: 0;
        margin: 0;
        list-style: none;
      }

      .footer-container .row ul li {
        display: inline-block;
        margin: 0 10px;
      }

      .footer-container .social-links a i {
        font-size: 2em;
        margin: 0 10px;
      }

      .footer-container .copyright {
        font-size: 0.8em;
        color: gray;
      }
    </style>
  </head>

  <body>
    <!-- NAVBAR SECTION -->
    <div class="menu-bar">
      <a href="#" class="logo"><img src="media/logo.png" /></a>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="index.html">About</a></li>
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
          <a href="#">Account <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu">
            <ul>
              <li><a href="account.html">Sign In</a></li>
              <li><a href="account.html">Sign Up</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>

    <!-- RULES SECTION -->
    <div class="rules-section">
      <h2>Tech Museum Submission Rules</h2>

      <table>
        <thead>
          <tr>
            <th>Rule</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Originality</td>
            <td>All submitted works must be original and not plagiarized.</td>
          </tr>
          <tr>
            <td>Relevance</td>
            <td>The work must relate to technology and innovation.</td>
          </tr>
          <tr>
            <td>Format</td>
            <td>All works must adhere to the specified format (e.g., PDF, JPG).</td>
          </tr>
        </tbody>
      </table>

      <ol>
        <li>Submission Deadline: All works must be submitted by the end of the month.</li>
        <li>Eligibility: Open to students aged 15–25 only.</li>
      </ol>

      <ul>
        <li>Ensure the work highlights innovation in technology.</li>
        <li>Provide a detailed description of the project upon submission.</li>
      </ul>

      <ol>
        <li>Contact Details: Include your email and phone number for communication.</li>
        <li>Copyright: Authors retain copyright but grant permission for exhibition.</li>
      </ol>

      <ul>
        <li>No offensive content is allowed in the submissions.</li>
        <li>Submissions will undergo a review process before approval.</li>
      </ul>

      <div class="agree-disagree">
        <p>Do you agree to the submission rules above?</p>
        <form method="POST">
          <label class="option">
            <input type="radio" name="consent" value="agree" required />
            <span>I Agree</span>
          </label>
          <label class="option">
            <input type="radio" name="consent" value="disagree" required />
            <span>I Disagree</span>
          </label>
          <button type="submit">Submit</button>
        </form>
        <?php
          if (isset($message)) {
            echo "<p>$message</p>";
          }
        ?>
      </div>
    </div>

    <!-- FOOTER SECTION -->
    <footer>
      <div class="footer-container">
        <div class="row social-links">
          <a href="https://wa.me/6283835361971" target="_blank"><i class="fa fa-whatsapp"></i></a>
          <a href="https://www.instagram.com/informatics_presuniv" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="row navigation-links">
          <ul>
            <li><a href="https://wa.me/6283835361971" target="_blank">Contact Us</a></li>
          </ul>
        </div>
        <div class="row copyright">
          Tech Museum Copyright © 2024 All rights reserved
        </div>
      </div>
    </footer>
  </body>
</html>
