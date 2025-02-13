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

        form {
            margin-bottom: 2rem;
        }

        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        form input[type="submit"] {
            background-color: #0078D7;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
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
        }

        .file-links a {
            display: block;
            color: #0078D7;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .file-links a:hover {
            text-decoration: underline;
        }

        .live-preview {
            margin-top: -1rem;
            font-size: 0.9rem;
            color: #0078D7;
            font-style: italic;
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
    </script>
</head>
<body>
    <header>
        <span class="menu" onclick="toggleMenu()">☰</span>
        <h1>ZenPack Lab</h1>
        <p>Create and manage ZenPacks effortlessly</p>
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="index.php">ZenPack Builder</a>
            <a href="upload.php">File Manager</a>
            <a href="zenpacklab.php">ZenPacks</a>
        </div>
    </header>
    <main>
        <!-- Pack Creation Form -->
        <form action="/zenpacklab.php" method="get">
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" placeholder="Enter author name">

            <label for="packname">Pack Name:</label>
            <input type="text" id="packname" name="packname" placeholder="Enter pack name" oninput="updatePackPreview()">
            <div class="live-preview" id="packPreview"></div>

            <label for="version">Version:</label>
            <input type="text" id="version" name="version" placeholder="Enter version">

            <label>
                <input type="checkbox" name="nagios">
                Install Nagios plugins?
            </label>

            <label>
                <input type="checkbox" name="symlink">
                Create symlinks during install? <span class="note">(Don't do this unless you know why)</span>
            </label>

            <input type="submit" value="Create Pack">
        </form>

        <hr>

        <!-- Downloadable Egg Files -->
        <div class="file-links">
            <h2><a href='zenpacklab.php'>Available Files</a></h2>
            <?php
            chdir('CustomScriptBuilder');
            $eggs = glob("*.egg");
            foreach ($eggs as $egg) {
                echo "<a href='CustomScriptBuilder/$egg'>$egg</a>";
            }
            ?>
        </div>
    </main>
</body>
</html>

