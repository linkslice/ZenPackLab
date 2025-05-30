<?php
$author = isset($_GET["author"]) ? $_GET["author"] : '';
$packname = isset($_GET["packname"]) ? $_GET["packname"] : '';
$version = isset($_GET["version"]) ? $_GET["version"] : '';
$symlink = isset($_GET["symlink"]) ? $_GET["symlink"] : '';

// Feedback message setup
$feedback_message = ''; // Placeholder for feedback
$error = false; // Flag for error messages

// Handle file deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    $fileToDelete = $_POST['file_to_delete'];
    $filePath = 'CustomScriptBuilder/' . $fileToDelete;

    if (file_exists($filePath)) {
        unlink($filePath);
        $feedback_message = "File '$fileToDelete' deleted successfully.";
    } else {
        $feedback_message = "Error: File not found.";
        $error = true;
    }
}

// Example of feedback logic based on user input or errors
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Add your custom feedback based on conditions, like success or failure.
    if (empty($author) || empty($packname) || empty($version)) {
        //$feedback_message = "Please make sure all fields (author, packname, version) are filled!";
        $error = false;
    } else {
        $feedback_message = "ZenPack $packname by $author ($version) is being generated...";
	// Check for Nagios condition and execute shell command accordingly
	if (!empty($_GET["nagios"])) {
    	    $command = "/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p";
    	        if ($_GET["symlink"]) {
        	    $command .= " -s";  // Add symlink flag
    	        }
        } else {
            $command = "/bin/bash makepack.sh -a '".$author."' -n $packname -v $version";
            if ($_GET["symlink"]) {
                $command .= " -s";  // Add symlink flag
            }
	}
        
    }
}

chdir('CustomScriptBuilder');

/*
// Check for Nagios condition and execute shell command accordingly
if (!empty($_GET["nagios"])) {
    $command = "/bin/bash makepack.sh -a '".$author."' -n $packname -v $version -p";
    if ($_GET["symlink"]) {
        $command .= " -s";  // Add symlink flag
    }
} else {
    $command = "/bin/bash makepack.sh -a '".$author."' -n $packname -v $version";
    if ($_GET["symlink"]) {
        $command .= " -s";  // Add symlink flag
    }
}
*/


// Execute the command
if ($command) { 
    $makepack_out = shell_exec($command);

    // Check for any error in command execution
    if (!$makepack_out) {
        $feedback_message = "There was an issue generating the ZenPack. Please check your inputs and try again.";
        $error = true;
    } else {
        $feedback_message = "ZenPack $packname by $author ($version) has been successfully generated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenPack Lab</title>
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

        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .delete-button:focus {
            outline: none;
        }

        .delete-button:active {
            background-color: #bd2130;
        }

        .file-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function toggleMenu() {
            var menu = document.getElementById('dropdownMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        window.onload = function() {
            if (document.getElementById('feedbackMessage')) {
                var feedbackMessage = document.getElementById('feedbackMessage');
                feedbackMessage.style.display = 'block';
                feedbackMessage.style.opacity = 1;
                
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
        <p>Manage your ZenPacks with ease</p>
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="index.php">ZenPack Builder</a>
            <a href="upload.php">File Manager</a>
            <a href="zenpacklab.php">ZenPacks</a>
        </div>
    </header>

    <main>
        <h2>ZenPack Setup</h2>

        <!-- Feedback message -->
        <?php if ($feedback_message): ?>
            <div class="feedback-message <?php echo $error ? 'error' : 'success'; ?>" id="feedbackMessage">
                <?php echo htmlspecialchars($feedback_message); ?>
            </div>
        <?php endif; ?>

	<?php if ($command): ?>
          <h3>ZenPack Generation</h3>
          <?php if ($error): ?>
            <p>There was an issue generating the ZenPack. Please check your inputs.</p>
          <?php else: ?>
            <p>Your ZenPack <?php echo htmlspecialchars($packname); ?> by <?php echo htmlspecialchars($author); ?> is being generated.</p>
	  <?php endif; ?>
        <?php endif; ?>

        <hr>

        <h3>Generated Files:</h3>
        <p>Click to download your ZenPack eggs:</p>
        <?php
	chdir('..');
        if (is_dir('CustomScriptBuilder') && ($eggs = glob("CustomScriptBuilder/*.egg"))) {
            foreach ($eggs as $egg) {
                $egg_name = basename($egg);
                echo "<div class='file-container'>";
                echo "<p><a href='CustomScriptBuilder/$egg_name'>$egg_name</a></p>";
                echo "<form method='POST' style='display:inline;' action='zenpacklab.php'>
                        <input type='hidden' name='file_to_delete' value='$egg_name'>
                        <input type='submit' name='delete_file' value='Delete' class='delete-button'>
                      </form>";
                echo "</div>";
            }
        }
        ?>

        <br>
        <a href='/'>Start Again</a>
    </main>

</body>
</html>

