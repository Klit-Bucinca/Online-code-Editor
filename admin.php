<?php
session_start();

// If session is not set, check if cookies exist
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
}

// If neither session nor cookie exists, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit;
}

// Ensure only "Admin" user can access this page
if ($_SESSION['username'] !== "Admin") {
    header("Location: Main.html");
    exit;
}

include('connectadmin.php');

// Fetch all users
$sql = "SELECT * FROM regist";
$result = $conn->query($sql);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch all contact form messages
$sql = "SELECT * FROM contact_form ORDER BY submitted_at DESC";
$result = $conn->query($sql);
$contacts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #121212;
    color: #fff;
    margin: 0;
    display: flex;
}


.sidebar {
    width: 250px;
    background-color: #1c1c1c;
    padding: 20px 10px;
    position: fixed;
    height: 100vh;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}

.sidebar h2 {
    color: #d4155b;
    margin-bottom: 30px;
    text-align: center;
    font-size: 24px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 20px;
}

.sidebar a {
    text-decoration: none;
    color: #d4155b;
    font-size: 18px;
    display: block;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-align: center;
}

.sidebar a:hover {
    background-color: #2a2a2a;
}


.sign-out {
    margin-top: auto;
    text-align: center;
    padding-bottom: 20px;
}

.sign-out a {
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    background-color: #d4155b;
    padding: 10px 20px;
    border-radius: 8px;
    display: inline-block;
    width: 80%;
    text-align: center;
}

.sign-out a:hover {
    background-color: #ff85c4;
}


.main-content {
    margin-left: 270px;
    padding: 40px;
    width: calc(100% - 270px);
    transition: width 0.3s ease, margin-left 0.3s ease;
}

h2 {
    font-size: 28px;
    color: #d4155b;
    margin-bottom: 20px;
}


table {
    width: 95%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #1c1c1c;
    color: #fff;
    border-radius: 10px;
    text-align: left;
}


table th {
    background-color: #2a2a2a;
    color: #d4155b;
    padding: 15px;
    text-align: left;
}


table td {
    border-bottom: 1px solid #333;
    padding: 15px;
    text-align: left;
    vertical-align: middle;
}


table td:first-child {
    text-align: center;
    width: 50px;
}


table td:last-child {
    text-align: center;
    width: 150px;
}


.action-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
}

button {
    background-color: #d4155b;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

button:hover {
    background-color: #c4005d;
}


.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    background: #1c1c1c;
    color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal .close {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #d4155b;
    font-size: 20px;
    cursor: pointer;
}

.modal input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #444;
    border-radius: 5px;
    background: #222;
    color: #fff;
    font-size: 14px;
}

.modal button {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}



@media (max-width: 1200px) {
    .main-content {
        margin-left: 250px;
        width: calc(100% - 250px);
        padding: 30px;
    }

    .sidebar {
        width: 220px;
    }

    table {
        width: 100%;
    }
}


@media (max-width: 768px) {
    body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 10px;
        text-align: center;
    }

    .sidebar ul {
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 15px;
    }

    .sidebar h2 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .main-content {
        margin-left: 0;
        width: 100%;
        padding: 20px;
    }

    table {
        width: 100%;
        display: block;
        overflow-x: auto;
    }

    .modal {
        width: 90%;
    }
}


@media (max-width: 480px) {
    .sidebar ul {
        flex-direction: column;
        gap: 5px;
    }

    .sidebar a {
        font-size: 16px;
        padding: 8px;
    }

    button {
        font-size: 12px;
        padding: 6px 10px;
    }

    .modal {
        width: 95%;
        padding: 20px;
    }
}

.hidden {
    display: none;
}

.admin-section {
    display: none;
}

#welcome {
    display: block;
}



    </style>
    <script>
        function showSection(sectionId) {
    if (sectionId === 'adminmain') {
        window.location.href = 'Admin Editor/main.php';
        return;
    }

    document.querySelectorAll('.admin-section').forEach(section => {
        section.style.display = 'none';
    });

    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}




        function saveUserChanges() {
            const id = document.getElementById('edit-user-modal').dataset.userId;
            const username = document.getElementById('edit-username').value;
            const email = document.getElementById('edit-email').value;

            fetch('edit_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, username, email })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`delete_user.php?id=${userId}`, { method: 'GET' })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function editUserPopup(id, username, email) {
            const modal = document.getElementById('edit-user-modal');
            modal.style.display = 'block';


            modal.dataset.userId = id;

            document.getElementById('edit-username').value = username;
            document.getElementById('edit-email').value = email;
    }
        
    </script>
</head>
<body>
    <nav class="sidebar">
        <h2>Welcome, Admin</h2>
        <ul>
            <li><a href="javascript:void(0)" onclick="showSection('welcome')">Welcome</a></li>
            <li><a href="javascript:void(0)" onclick="showSection('users')">All Users</a></li>
            <li><a href="javascript:void(0)" onclick="showSection('adminmain')">Admin Editor</a></li>
            <li><a href="Home/Home.php">Manage Slider</a></li>
            <li><a href="javascript:void(0)" onclick="showSection('contact_messages')">Contact Messages</a></li>
        </ul>

        <div class="sign-out">
            <a href="logout.php">Sign Out</a>
        </div>
    </nav>

    <div class="main-content">
    <section id="welcome" class="admin-section">
    <h2>Welcome, <?= $_SESSION['username'] ?>!</h2>
    <p>👋 This is your admin panel. Use the navigation bar to manage users and messages.</p>
</section>

<section id="users" class="admin-section hidden">
    <h2>All Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['Username']) ?></td>
                    <td><?= htmlspecialchars($user['Email']) ?></td>
                    <td>
                        <button onclick="editUserPopup(<?= $user['id'] ?>, '<?= htmlspecialchars($user['Username']) ?>', '<?= htmlspecialchars($user['Email']) ?>')">Edit</button>
                        <button onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<section id="contact_messages" class="admin-section hidden">
    <h2>Contact Messages</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $contact['id'] ?></td>
                    <td><?= htmlspecialchars($contact['first_name']) ?></td>
                    <td><?= htmlspecialchars($contact['last_name']) ?></td>
                    <td><?= htmlspecialchars($contact['phone_number']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['message']) ?></td>
                    <td><?= $contact['submitted_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


    </div>

    <div id="edit-user-modal" class="modal">
        <span class="close" onclick="document.getElementById('edit-user-modal').style.display='none'">&times;</span>
        <h3>Edit User</h3>
        <input type="text" id="edit-username" placeholder="Username">
        <input type="email" id="edit-email" placeholder="Email">
        <button onclick="saveUserChanges()">Save Changes</button>
    </div>
</body>
</html>
