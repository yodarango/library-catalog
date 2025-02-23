<?php
session_start();
include_once('config/config.php');
include_once('toolkit/bootstrap.php');
include_once('snippets/logged-in.php');

// Funzione per generare un token CSRF
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}

// Genera un token CSRF se non esiste già
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generate_csrf_token();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo 'Invalid CSRF token.';
        exit;
      }

      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $phone = trim($_POST['phone']);
      $description = trim($_POST['text']);

      // Validate input
      if (empty($name) || empty($description)) {
            echo 'Name and Prayer Request are required.';
            exit;
      }

      // Establish database connection
      $db = new Database(array(
            'type' => 'mysql',
            'host' => $hostname,
            'database' => $database,
            'user' => $username,
            'password' => $password
      ));

      // Insert prayer request into the database
      $insert = $db->table('prayer_requests')
            ->insert(array(
                  'name' => $name,
                  'email' => $email,
                  'phone' => $phone,
                  'description' => $description
            ));

      if ($insert) {
            echo 'Prayer request submitted successfully.';
      } else {
            echo 'Failed to submit prayer request. Please try again.';
      }

      $_SESSION['csrf_token'] = generate_csrf_token();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <title>STWC |Apostolics in the gap </title>
      <meta name="description" content="Official homepage of Spirit and Truth Worship Center. We welcome you!">
      <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1">
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="keywords" content="Apostolic, Apostolic Church, Pentecostal, Apostolic Pentecostal, FAC Knoxville, Expereince Apostolic, Holy Ghost, Speaking in tongues, baptizing in the name of Jesus Christ, church in knoxville">
      <meta name="og:title" content="STWC | What do we, as apostolics believe? ">
      <meta property="og:url" content="https://stwcarthur.org/about-team">
      <meta property="og:image" content="https://res.cloudinary.com/stecarthur-org/image/upload/v1644941899/logo_fwqzfu.png">
      <meta property="og:type" content="website">
      <meta property="og:description" content="Official homepage of Spirit and Truth Worship Center. We welcome you!">
      <meta name="og:site_name" content="FAC Knoxville">
      <meta name="og:region" content="TN">
      <meta name="og:postal-code" content="37912">
      <meta name="og:country-name" content="USA">
      <meta name="blogcatalog">
      <link rel="icon" type="image/png" href="/images/logo.png">
      <meta name="next-head-count" content="17">

      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="/assets/css/home.css">

</head>

<body>
      <div id="toast" class="toast"></div>
      <section class="landing">
            <video autoplay="" loop="" muted="" playsinline="" class="Home_videoBkg__1Q7hZ">
                  <source src="https://res.cloudinary.com/stecarthur-org/video/upload/v1644933485/video-intro-stwc_2_xdllo3.mp4">
            </video>
            <!-- Header -->
            <header class="header">
                  <div>
                        <a href="/" class="logo-container">
                              <div class="logo"></div>
                        </a>
                        <button class="menu-button">
                              <i class="fa fa-bars"></i>
                        </button>
                  </div>
            </header>
            <!-- Nav -->
            <nav class="drawer" id="drawer">
                  <button class="close-button" aria-label="Close Menu">
                        <i class="fa fa-times"></i>
                  </button>
                  <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/library">Library</a></li>
                        <li><a href="/coffeeshop">Coffeeshop</a></li>
                        <li><a href="/ministers-office">Minister's Office</a></li>
                        <?php if (is_admin()) { ?>
                              <li><a href="/admin-prayer">Admin</a></li>
                        <?php } ?>
                        <?php if (logged_in()) { ?>
                              <li><a href="/logout"><button class="logout-in-button">Logout</button></a></li>
                        <?php } ?>
                        <?php if (!logged_in()) { ?>
                              <li><a href="/login"><button class="logout-in-button">Login</button></a></li>
                        <?php } ?>
                        <li><button id="open-modal-button" class="open-modal-button">Prayer request</button></li>
                  </ul>
            </nav>
            <script>
                  console.log(<?= json_encode($_SESSION) ?>);
            </script>
            <!-- modal -->
            <div id="modal" class="modal">
                  <div class="modal-content">
                        <button class="close-button-modal">
                              <i class="fa fa-times"></i>
                        </button>
                        <h4>Submit Prayer Request</h4>
                        <form id="prayerRequestForm">
                               <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                              <label for="name">Name:</label>
                              <input type="text" id="name" name="name" required maxlength="50">
                              <!-- <label for="phone">Phone:</label>
                              <input type="tel" id="phone" name="phone" maxlength="20"> -->
                              <label for="email">Email: (optional)</label>
                              <input type="email" id="email" name="email" maxlength="50">
                              <label for=" text">Prayer Request:</label>
                              <textarea id="text" name="text" required maxlength="1000"></textarea>
                              <button type=" submit">Submit</button>
                        </form>
                  </div>
            </div>
            <h1 class="fade-in-upt">Apostolics in the Gap</h1>
      </section>

      <!-- About the pastoral team -->
      <section class="info-container">
            <div>
                  <div class="info-container__images fade-in-up"><img src="assets/images/the_miracles.webp" alt="The Miracles" /></div>
                  <div class="info-container__info fade-in-up">
                        <h3>Pastoral Team</h3>
                        <p>Christ Apostolic Church of Arthur, Tennessee was established in 1983 by a body of believers who desired to equip the saints and reach the lost. Since that time, it has grown from a small group meeting in a family home to a community with the common goals to love God and love people with all of our heart, mind, soul and strength.</p>
                        <p> In the early 1990’s the doing business name of the church was changed to Spirit and Truth Worship Center, in a desire to reaffirm the idea that we are the temple of the Holy Ghost and that this building is to worship God and educate the body of Christ.</p>
                        <p> “God is a Spirit: and they that worship him must worship him in spirit and in truth.” John 4:24.</p>
                        <p> Spirit and Truth Worship Center is a family of believers living each day in worship, filled with the Spirit, and sharing the truth of the Gospel of Jesus Christ. Our motto is “Apostolics in the Gap.” “And I sought for a man among them, that should make up the hedge, and stand in the gap…” Ezekiel 22:30.</p>
                  </div>
            </div>
      </section>

      <!-- Bible verse -->
      <section class="Bible-verse-container">
            <div class="Bible-verse-content fade-in-up">
                  <p>
                        "And I sought for a man among them, that should make up the hedge, and <b>stand in the gap...</b>"
                  </p>
                  <h2>Ezekiel 22:30</h2>
            </div>
      </section>

      <!-- About the church -->
      <section class="info-container reversed our-story">
            <div>
                  <div class="info-container__images fade-in-up"><img src="assets/images/plant.png" class="our-story-image" /></div>
                  <div class="info-container__info fade-in-up">
                        <h3>Our Story</h3>
                        <p>Christ Apostolic Church of Arthur, Tennessee was established in 1983 by a body of believers who desired to equip the saints and reach the lost. Since that time, it has grown from a small group meeting in a family home to a community with the common goals to love God and love people with all of our heart, mind, soul and strength.</p>
                        <p>In the early 1990’s the doing business name of the church was changed to Spirit and Truth Worship Center, in a desire to reaffirm the idea that we are the temple of the Holy Ghost and that this building is to worship God and educate the body of Christ.</p>
                        <p>“God is a Spirit: and they that worship him must worship him in spirit and in truth.” John 4:24.</p>
                        <p> Spirit and Truth Worship Center is a family of believers living each day in worship, filled with the Spirit, and sharing the truth of the Gospel of Jesus Christ. Our motto is “Apostolics in the Gap.” “And I sought for a man among them, that should make up the hedge, and stand in the gap…” Ezekiel 22:30.</p>
                  </div>
            </div>
      </section>

      <section class="info-container full-width our-beliefs">
            <div class="beliefs">
                  <div class="fade-in-up">
                        <div class="fa fa-book"></div>
                        <div>
                              <h4>About the Bible</h4>
                              <p>The Bible is the infallible Word of God and the authority for salvation and Christian living. (See II Timothy 3:15-17.)</p>
                        </div>
                  </div>
                  <div class="fade-in-up">
                        <div class="fa fa-user"></div>
                        <div>
                              <h4>About God</h4>
                              <p>There is one God, who has revealed Himself as our Father, in His Son Jesus Christ, and as the Holy Spirit. Jesus Christ is God manifested in flesh. He is both God and man. (See Deuteronomy 6:4; Ephesians 4:4-6; Colossians 2:9; I Timothy 3:16.)</p>
                        </div>
                  </div>
                  <div class="fade-in-up">
                        <div class="fa fa-heart"></div>
                        <div>
                              <h4>About Sin and Salvation</h4>
                              <p>Everyone has sinned and needs salvation. Salvation comes by grace through faith based on the atoning sacrifice of Jesus Christ. (See Romans 3:23-25; 6:23; Ephesians 2:8-9.)</p>
                        </div>
                  </div>
                  <div class="fade-in-up">
                        <div class="fa fa-globe"></div>
                        <div>
                              <h4>About the Gospel</h4>
                              <p>The saving gospel is the good news that Jesus died for our sins, was buried, and rose again. We obey the gospel (II Thessalonians 1:8; I Peter 4:17) by repentance (death to sin), water baptism in the name of Jesus Christ (burial), and the baptism of the Holy Spirit with the initial sign of speaking in tongues as the Spirit gives the utterance (resurrection). (See I Corinthians 15:1-4; Acts 2:4, 37-39; Romans 6:3-4.)</p>
                        </div>
                  </div>
                  <div class="fade-in-up">
                        <div class="fa fa-life-ring"></div>
                        <div>
                              <h4>About Christian Living</h4>
                              <p>As Christians we are to love God and others. We should live a holy life inwardly and outwardly, and worship God joyfully. The supernatural gifts of the Spirit, including healing, are for the church today. (See Mark 12:28-31; II Corinthians 7:1; Hebrews 12:14; I Corinthians 12:8-10.)</p>
                        </div>
                  </div>
                  <div class="fade-in-up">
                        <div class="fa fa-arrow-right"></div>
                        <div>
                              <h4>About the Future</h4>
                              <p>Jesus Christ is coming again to catch away His church. In the end will be the final resurrection and the final judgment. The righteous will inherit eternal life, and the unrighteous eternal death. (See I Thessalonians 4:16-17; Revelation 20:11-15.)</p>
                        </div>
                  </div>
            </div>
      </section>

      <section class="info-container tsca">
            <h2 class="tsca__title fade-in-up">Why consider Tri-state Christian Academy</h2>
            <img src="assets/images/tsca_logo.webp" alt="Logo for a school" class="fade-in-up">

            <div class="info-container__cards">
                  <div class="card fade-in-up">
                        <div class="card-inner">
                              <div class="card-front">
                                    <div>
                                          <img src="assets/images/wisdom.png" alt="Integrity Image" class="card-image">
                                          <h3>Wisdom</h3>
                                    </div>
                              </div>
                              <div class="card-back">
                                    <p>At Tri-State Christian Academy we believe in the biblical principle, "Train up a child in the way he should go: and when he is old, he will not depart from it." (Proverbs 22:6) Therefore we strive to instill in them biblical values as well as high quality education that will aid them in their growing and for the rest of their lives.</p>
                              </div>
                        </div>
                  </div>

                  <div class="card fade-in-up">
                        <div class="card-inner">
                              <div class="card-front">
                                    <div>
                                          <img src="assets/images/integrity.png" alt="Integrity Image" class="card-image">
                                          <h3>Integrity</h3>
                                    </div>
                              </div>
                              <div class="card-back">
                                    <p>At Tri-State Christian Academy we believe in the biblical principle, "Train up a child in the way he should go: and when he is old, he will not depart from it." (Proverbs 22:6) Therefore we strive to instill in them biblical values as well as high quality education that will aid them in their growing and for the rest of their lives.</p>
                              </div>
                        </div>
                  </div>

                  <div class="card fade-in-up">
                        <div class="card-inner">
                              <div class="card-front">
                                    <div>
                                          <img src="assets/images/excellence.png" alt="Integrity Image" class="card-image">
                                          <h3>Excellence</h3>
                                    </div>
                              </div>
                              <div class="card-back">
                                    <p>It is our goal at TSCA to do everything "... as for the Lord" (Colossians 3:23). With this in mind we continue to improve on the things we have been doing and prepare to adopt the ones we have not. Not only is our focus that our students receive a good education, but that they receive an excellent education.</p>
                              </div>
                        </div>
                  </div>
            </div>
      </section>

      <!-- Footer -->
      <footer class="footer">
            <div class="container">
                  <ul class="icons">
                        <li>
                              <a href="#" class="fa fa-youtube"></a>
                        </li>
                        <li>
                              <a href="#" class=" fa fa-facebook"></a>
                        </li>
                        <li>
                              <a href="#" class=" fa fa-instagram"></a>
                        </li>
                  </ul>
            </div>
      </footer>
      <script src="assets/js/home.js"></script>
</body>

</html>