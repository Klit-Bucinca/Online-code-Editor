<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'user_database');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        echo "Error: Missing required fields.";
        exit;
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Error: Username and password are required.";
        exit;
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, Username, Password FROM regist WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $dbUsername, $dbPassword);
        $stmt->fetch();

        if (password_verify($password, $dbPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $dbUsername;

            // Set cookies for 7 days
            setcookie("user_id", $id, time() + (7 * 24 * 60 * 60), "/");
            setcookie("username", $dbUsername, time() + (7 * 24 * 60 * 60), "/");
            if ($dbUsername === "Admin") {
                $_SESSION['is_admin'] = true;
                echo "admin";
            } else {
                echo "success";
            }
            exit;
        } else {
            echo "Error: Incorrect password.";
            exit;
        }
    } else {
        echo "Error: Username not found.";
        exit;
    }

    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
         }
           body {
              
                 height: 100vh;
               font-family: 'Poppins', sans-serif;
              background-color: #000;
              color:  #fff;
              overflow: hidden;
              
              
   
           }
           .container {
                position: relative;
                width: 100%;
                height: 100%;
   
   
           }
   
           .shape{
            position: absolute;
            z-index: 0;
            opacity: 0.9;
           }
           
   
           
           
           .triangle {
       top: 0;
       left: 0;
       width: 150px; 
     }
     
     .square {
       top: -50px; 
       right: 50px; 
       width: 300px; 
     }
     
     .circle {
       bottom: -50px; 
       right: -50px;
       width: 250px; 
     }
     
     .half-circle {
       bottom: -30px;
       left: -30px;
       width: 200px; 
     }
   
   .form-container {
      position: absolute;
      z-index: 1;
      top: 40%;
      left: 28%;
      transform: translate(-28%,-50%);
      width: 500px;
      background-color: rgba(0, 0, 0, 0.8);
      padding: 40px 30px;
      border-radius: 10px;
   
      
   }
   
   h1{
      text-align: center;
      font-weight: 600;
      margin-bottom: 25px;
      font-size: 32px;
   }
   .input-group{
      margin-bottom: 25px;
   }
   label{
      display: block;
      margin-bottom: 5px;
      font-size: 16px;
   }
   .input-icon{
      display: flex;
      align-items: center;
      background-color: #222;
      border: 1px solid #fff;
      border-radius: 8px;
      padding: 10px 20px;
   
   
   }
   .input-icon .icon {
      width: 25px;
      margin-right: 15px;
   }
   .input-icon .divider{
      margin:0 10px;
      color: #fff;
      font-weight: 600;
   }
   input{
      flex-grow: 1;
      border: none;
      background: none;
      color: #fff;
      font-size: 16px;
      outline: none;
   }
   input::placeholder {
      color: #888;
   }
   
   
    .input-container {
   align-items: center;
   display: flex;
   border: 1px solid #fff;
   border-radius:  5px;
   padding: 10px;
   background: #1a1a1a;
   
    }
    .input-container .icon {
      margin-right: 10px;
    }
   
    .input-container input {
      width: 100%;
      border: none;
      background: transparent;
      color: #fff;
      outline: none;
    }
   
   input::placeholder {
      color: #ffffffcc;
   }
   
   .btn {
       width: 100%;
       padding: 15px; 
       background-color: #ff007f;
       border: none;
       border-radius: 8px; 
       color: #fff;
       font-size: 18px; 
       cursor: pointer;
       transition: background-color 0.3s;
     }
     
     .btn:hover {
       background-color: #c4005d;
     }
     
   
     .login-link {
       text-align: center;
       margin-top: 20px;
       font-size: 14px;
     }
     
     .login-link a {
       color: #00bfff;
       text-decoration: none;
     }
     
     .login-link a:hover {
       text-decoration: underline;
     }
     
   
   .toggle-password {
       background: none;
       border: none;
       cursor: pointer;
       margin-left: 10px;
       padding: 0;
       display: flex;
       align-items: center;
     }
     
     .eye-icon {
       font-size: 18px; 
       color: #fff; 
       transition: color 0.3s; 
     }
   
   .open-eye::before {
       content: "\f06e"; 
       font-family: "Font Awesome 5 Free";
       font-weight: 900;
     }
     
     .closed-eye::before {
       content: "\f070"; 
       font-family: "Font Awesome 5 Free";
       font-weight: 900;
     }
     
     .toggle-password:hover .eye-icon {
       color: #ff007f; 
     }
   
     
     @media (max-width: 768px) {
       .triangle {
         width: 80px; 
       }
   
       .square {
         top: -30px;
         right: 20px; 
         width: 150px; 
       }
     
       .circle {
         bottom: -20px;
         right: -10px;
         width: 120px; /
       }
     
       .half-circle {
         bottom: 0;
         left: 0;
         width: 100px; 
       }
     
       .form-container {
         width: 95%; 
         left: 50%; 
         transform: translate(-50%, -50%);
         padding: 15px; 
       }
     
       h1 {
         font-size: 20px; 
       }
     
       .btn {
         font-size: 14px; 
       }
     
       .login-link {
         font-size: 12px; 
       }
     
       .input-icon {
         padding: 5px 8px; 
       }
     
       .input {
         font-size: 12px; 
       }
    }
    
     
    </style>

 


    </head>
    <body>
        <div class="container">
            <img src="triangle.png" alt="Triangle" class="shape triangle">
            <img src="Square Topright.png" alt="Square" class="shape square">
            <img src="circle.png" alt="Circle" class="shape circle">
            <img src="Square.png" alt="Half Circle" class="shape half-circle">
    
            <div class="form-container">
                <h1>Log in</h1>
                <form id="logInForm">
                    <div class="input-group">
                        <label for="username">Name</label>
                        <div class="input-icon">
                          <img src="image 1.png" alt="User Icon" class="icon">
                  <span class="divider">|</span>
                            <input type="text" id="username" name="username" placeholder="Username">
                        </div>
                    </div>
    
                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-icon">
                          <img src="Password.png" alt="Password" class="icon">
                          <span class="divider">|</span>
                            <input type="password" id="password" name="password" placeholder=" Password">
                            <button type="button" id="togglePassword" class="toggle-password">
                                <i class="eye-icon closed-eye"></i>
                            </button>
                        </div>
                    </div>
    
                    <button type="submit" class="btn">Log in</button>
                    <p class="login-link">Don't have an account? <a href="Sign up.php">Sign Up</a></p>
                </form>
            </div>
        </div>
    

  <script src="scriptlogin.js"></script>
  

</body>
</html>

