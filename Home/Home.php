<?php
    include 'connect.php';
    include 'contact_process.php';
?>

   <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home page</title>
        <link rel="stylesheet" href="home.css">
 
    </head>
    <body>
        <nav class="navigation">

            <div class="triangle_div">
            <img src="Images/Triangle.png" alt="" class="Triangle">
            </div>

        
                <img src="Images/menu1.png" alt="menu" class="menu" id="menu">

                <div class="dropdown_menu" id="dropdown_menu">
                    <li class="nav_AboutUs"><a href="#aboutUs">About us</a></li>
                    <li class="nav_Uses"><a href="#uses">Uses</a></li>
                    <li class="nav_GoToEditor"><a href="../Main.html">Go to Editor</a></li>
                    <li class="nav_ContactUs"><a href="#contactUS">Contact us</a></li>
                    <li class="nav_SignUp"><a href="../Sign up.html">Sign up</a></li>
                </div>
        

            <div class="navigation-links-div">
                <ul class="navigation-links">
                    <li class="nav_AboutUs"><a href="#aboutUs">About us</a></li>
                    <li class="nav_Uses"><a href="#uses">Uses</a></li>
                    <li class="nav_GoToEditor"><a href="../Main.html">Go to Editor</a></li>
                    <li class="nav_ContactUs"><a href="#contactUS">Contact us</a></li>
                    <li class="nav_SignUp"><a href="../Sign up.html">Sign up</a></li>
                </ul>
            </div>

            <div class="icons">
                <a href=""><img src="Images/github.png" alt="github logo"></a>
                <a href=""><img src="Images/discord.png" alt="discord logo"></a>
                <a href=""><img src="Images/twitter.png" alt="twitter logo"></a>
                <a href=""><img src="Images/reddit.png" alt="reddit logo"></a>
            </div>

        </nav>

        <div class="all-main">
            <div class="main1">
                <h1 class="text-ngjyra">A Fast Code Editor</h1>
                <h1 class="text-pa-ngjyra">Editor Name</h1>
                <p class="main-text">Welcome to DevBox, your all-in-one, browser-based code editor designed for coders of every level. Whether you're a beginner learning the ropes or a pro refining your craft, our editor provides a clean, intuitive space to write, test, and perfect your code in HTML, CSS, and JavaScript.</p>
                <section id="aboutUs"></section>
            </div>
               
            <div class="square_circle">
                <img src="Images/square.png" alt="" class="Square">
                <img src="Images/Circle.png" alt="" class="Circle">    
            </div>
                    
            <div class="all-main2"> 
                <div class="about-us">
                    <h2>About Us</h2>
                    <p><?php echo $aboutUsContent; ?></p>
                    
                </div>

                <div class="logo_set1">

                <img src="Images/html-logo.png" alt="" class="logo-h">
                <section id="uses"></section>
                <img src="Images/js-logo.png" alt="" class="logo-j">

                </div>

                <div class="uses">
                    <h2>Uses</h2>
                    <p><?php echo $usesContent; ?></p>
                    
                    <div class="slider-container">
                        <button class="slider-btn prev-btn">&#10094;</button>
                        
                        <div class="slider-wrapper">
                            <div class="slide">
                                <img src="Images/learning.jpg" alt="Learning">
                                <div class="slide-content">
                                    <h3>Learning & Practicing</h3>
                                    <p>Perfect for beginners, offering a simple, distraction-free space to practice HTML, CSS, and JavaScript.</p>
                                </div>
                            </div>

                            <div class="slide">
                                <img src="Images/prototyping.jpg" alt="Prototyping">
                                <div class="slide-content">
                                    <h3>Rapid Prototyping</h3>
                                    <p>Quickly sketch out ideas, test code snippets, and refine them in real-time without setting up a full development environment.</p>
                                </div>
                            </div>

                            <div class="slide">
                                <img src="Images/organising.jpg" alt="Organization">
                                <div class="slide-content">
                                    <h3>Project Organization</h3>
                                    <p>Our lane feature acts as your coding history, allowing you to save, organize, and quickly revisit past snippets or projects.</p>
                                </div>
                            </div>

                            <div class="slide">
                                <img src="Images/webdev.jpg" alt="Development">
                                <div class="slide-content">
                                    <h3>Web Development</h3>
                                    <p>Build and preview web projects with live feedback, making it easy to see changes and troubleshoot code instantly.</p>
                                </div>
                            </div>

                            <div class="slide">
                                <img src="Images/efficientwork.jpg" alt="Workflow">
                                <div class="slide-content">
                                    <h3>Efficient Workflow</h3>
                                    <p>Ideal for managing multiple small projects or coding exercises, with a streamlined interface for saving and retrieving your work.</p>
                                </div>
                            </div>
                        </div>

                        <button class="slider-btn next-btn">&#10095;</button>
                        
                        <div class="slider-dots">
                            <span class="dot active"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                </div>
                
                <div class="logo_set2">

                 <img src="Images/css-logo.png" alt="" class="logo-c">
                 <img src="Images/tool.png" alt="" class="tool">

                </div>

            </div>
            <section id="contactUS"></section> 
          
        </div>

            <footer class="footer">

            <div class="footer-text">
                <h3 class="Contact-color">Phone:</h3>
                <h3>+38344222222   </h3>
                <hr>
                <h3 class="Contact-color">Email:</h3>
                <h3>texteditor@gmail.com    </h3>
                <hr>
                <h3 class="Contact-color">Address:</h3>
                <h3>Rruga Agim ramadani nr.8    </h3>
            </div>

            <div class="footer-form">
                <form action="contact_process.php" method="POST" id="contactForm">

                <h3 class="get-in-contact">GET IN CONTACT</h3>
                <h5>24/7 we will answer your questions and problems</h5>
                <div class="form-all">
                <div class="form-non-message">
                    <div class="form-names">
                        <input type="text" name="firstName" id="firstName" class="name" placeholder="First name">
                        <br><br>
                        <input type="text" name="lastName" id="lastName" class="lastName" placeholder="Last name">
                        <br><br>
                    </div>
                    <input type="tel" name="phoneNumber" id="phoneNumber" class="phoneNr" placeholder="Phone number">
                    <br>
                    <input type="email" name="email" id="email" class="email" placeholder="Email">
                    <br><br>
                </div>
                <div class="message">
                    <textarea name="message" id="message" class="message" placeholder="Message"></textarea>
                </div>
                </div>

                <button type="submit" class="submit">Submit</button>

                </form>

            </div>  
             
            </footer>
                
            <script src="home.js"></script>
    </body>
    </html>
