<?php
$upload_dir = '/usr/src/zenpacklab-storage/libexec/';
$disallowed_extensions = ['php', 'phar', 'cgi', 'fcgi', 'phtml'];

// Ensure the upload directory exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
}

$feedback_message = ''; // Store feedback message
$humorous_messages = [
    "Why don't you just try uploading all of metasploit next time?",
    "Would you like me to just upload the entire internet?",
    "Perhaps upload a virus while you're at it?",
    "Are you sure this isn't a malicious file? Just checking.",
    "Maybe a small text file would be a good place to start?",
    "No need to upload a 4GB file, we're not running a datacenter here.",
    "The server said no because it didn’t *feel* like it.",
    "Your file was rejected because the system is going through a *phase*. It’ll be back to normal tomorrow.",
    "The file didn’t upload because the server decided to start *acting like a diva* today.",
    "This file was too *dangerous* for the system. It was *way* too edgy.",
    "It seems your file just didn’t *mesh* with the server’s inner zen.",
    "We couldn’t upload your file because the server is on *vacation*. Please try again in a week.",
    "The file didn’t upload because the system is currently being *re-trained*. Check back later for better results.",
    "Your file was rejected because it was just *too ahead of its time*.",
    "Upload failed because the file was too *perfect*—the system couldn’t handle it."
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $file_to_delete = basename($_POST['delete']);
        $file_path = $upload_dir . $file_to_delete;
        if (file_exists($file_path)) {
            unlink($file_path);
            $feedback_message = "File $file_to_delete deleted successfully.";
        } else {
            $feedback_message = "File not found.";
        }
    } elseif (isset($_FILES['fileToUpload'])) {
        $file_name = basename($_FILES['fileToUpload']['name']);
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $target_file = $upload_dir . $file_name;

        // Check for invalid file type
        if (in_array($file_extension, $disallowed_extensions)) {
            $feedback_message = "Invalid file type: $file_extension - " . $humorous_messages[array_rand($humorous_messages)];
	    $error = true;
        } 
        // Check for file size
        elseif ($_FILES['fileToUpload']['size'] > 500000) {
            $feedback_message = "File is too large. " . $humorous_messages[array_rand($humorous_messages)];
	    $eror = true;
        } 
        // Upload the file
        else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                $feedback_message = "File $file_name uploaded successfully.";
            } else {
                $feedback_message = "Error uploading file. " . $humorous_messages[array_rand($humorous_messages)];
            }
        }
    }
}

$files = is_dir($upload_dir) ? array_diff(scandir($upload_dir), array('.', '..')) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenPack Lab - File Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #0078D7;
            color: #fff;
            padding: 1rem;
            text-align: center;
            position: relative;
        }

        .menu {
            position: absolute;
            left: 10px;
            top: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 50px;
            left: 10px;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
        }

        .dropdown-menu a {
            display: block;
            padding: 5px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #f4f4f9;
        }

        main {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
        }

        form label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        form input[type="text"],
        form input[type="file"] {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        form input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        form input[type="submit"] {
            background-color: #0078D7;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        form input[type="submit"]:hover {
            background-color: #005bb5;
        }

        .note {
            font-size: 0.9rem;
            color: #666;
        }

        hr {
            margin: 2rem 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        .file-links {
            margin-top: 2rem;
            list-style: none;
            padding: 0;
        }

        .file-links li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .file-links a {
            display: block;
            color: #0078D7;
            text-decoration: none;
        }

        .file-links a:hover {
            text-decoration: underline;
        }

        .file-links button {
            background-color: #dc3545;
            color: #fff;
            padding: 0.25rem 0.75rem;
            border: none;
            border-radius: 5px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .file-links button:hover {
            background-color: #c82333;
        }

        .live-preview {
            margin-top: -1rem;
            font-size: 0.9rem;
            color: #0078D7;
            font-style: italic;
        }

        .feedback-message {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 5px;
            font-size: 1rem;
            max-width: 80%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .feedback-message.success {
            background-color: #28a745;
        }

        .feedback-message.error {
            background-color: #dc3545;
        }
    </style>
    <script>
        function toggleMenu() {
            var menu = document.getElementById('dropdownMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        function updatePackPreview() {
            const packName = document.getElementById('packname').value;
            const preview = document.getElementById('packPreview');
            preview.textContent = packName ? `ZenPacks.${packName}.CustomScripts` : '';
        }

        // Show feedback message if it exists
        window.onload = function() {
            if (document.getElementById('feedbackMessage')) {
                var feedbackMessage = document.getElementById('feedbackMessage');
                feedbackMessage.style.display = 'block';
                feedbackMessage.style.opacity = 1;
                
                // Hide message after 5 seconds
                setTimeout(function() {
                    feedbackMessage.style.opacity = 0;
                    setTimeout(function() {
                        feedbackMessage.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        };
    </script>
</head>
<body>

    <header>
        <span class="menu" onclick="toggleMenu()">☰</span>
        <h1>ZenPack Lab</h1>
        <p>Manage your scripts and files with ease</p>
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="index.php">ZenPack Builder</a>
            <a href="upload.php">File Manager</a>
            <a href="zenpacklab.php">ZenPacks</a>
        </div>
    </header>

    <main>
        <h2>Upload Script</h2>

        <!-- Feedback message -->
        <?php if ($feedback_message): ?>
            <div class="feedback-message <?php echo $error ? 'error' : 'success'; ?>" id="feedbackMessage">
                <?php echo htmlspecialchars($feedback_message); ?>
            </div>
        <?php endif; ?>

        <!-- Upload Form -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Select a file to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File">
        </form>

        <h2>Existing Scripts</h2>
        <ul class="file-links">
            <?php foreach ($files as $file): ?>
                <li>
                    <span><?= htmlspecialchars($file) ?></span>
                    <form action="upload.php" method="post" class="d-inline">
                        <input type="hidden" name="delete" value="<?= htmlspecialchars($file) ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

</body>
</html>

