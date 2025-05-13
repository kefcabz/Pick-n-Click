<?php
session_start();
require '../dbconnect.php';

$successMessage = '';
$errorMessage = '';
$redirect = false;

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $platform = $_POST['platform'] ? implode(', ', $_POST['platform']) : '';
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $author = $_POST['author'];
    $release_date = $_POST['release_date'];

    $sql = "INSERT INTO games (title, category, platform, price, image_url, author, release_date)
            VALUES ('$title', '$category', '$platform', '$price', '$image_url', '$author', '$release_date')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Game added successfully! Redirecting...";
        $redirect = true;
    } else {
        $errorMessage = "Error adding game: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Game - PickNClick</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">
    <style>
        body {
            /* Keep body styles minimal to avoid broad interference */
            font-family: sans-serif;
            margin: 0;
            padding-bottom: 50px;
        }

        main.container {
            background-color: #f9ed69; /* Yellowish background for the main container */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
            margin-bottom: 30px;
        }

        main h2.text-center {
            color: #d62828; /* Red heading */
            margin-bottom: 30px;
            text-shadow: 1px 1px #ffe599;
        }

        main form {
            background-color: #ffe599; /* Light yellow for the form */
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #d62828;
            margin-bottom: 30px;
        }

        main .form-label {
            font-weight: bold;
            color: #d62828;
        }

        main .form-control {
            border: 1px solid #d62828;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            background-color: #fff8dc; /* Light beige input fields */
            color: #d62828;
        }

        main .form-control::placeholder {
            color: #ffb300; /* Orange placeholder text */
        }

        main #platform-container {
            border: 2px solid #d62828;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            background-color: #fff8dc;
        }

        main .platform-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: calc(100% - 30px);
            padding: 10px 15px;
            background-color: #fff;
            border: none;
            border-bottom: 1px solid #ffb300;
            text-align: left;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 8px;
            transition: background-color 0.3s ease;
        }

        main .platform-option:last-child {
            border-bottom: none;
        }

        main .platform-option:hover {
            background-color: #ffb300; /* Orange hover */
            color: #fff;
        }

        main .indicator {
            margin-left: 15px;
            font-size: 1.2em;
        }

        main .check {
            color: green;
        }

        main .cross {
            color: red;
        }

        main .btn-success {
            background-color: #28a745; /* Green button */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        main .btn-success:hover {
            background-color: #218838;
        }

        main .text-center {
            margin-top: 30px;
        }

        main .form-text {
            color: #777;
            font-size: 0.95em;
            margin-top: 8px;
        }

        /* Styling for the fixed, centered message overlay */
        #message-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            display: flex; justify-content: center; align-items: center;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9999;
        }

        #message-box {
            background-color: #ffb300; /* Orange message box */
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .success-message {
            color: green;
            font-size: 1.3em;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-size: 1.3em;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include '../Components/header.php'; ?>

<main class="container mt-5">
    <h2 class="text-center">Add New Game</h2>
    <form method="POST" action="add_game.php">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter game title">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" required placeholder="e.g., Action, RPG">
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Platform</label>
            <div id="platform-container">
                <input type="hidden" name="platform[]" id="selected-platforms">
                <button type="button" class="platform-option" data-value="PC">PC <span class="indicator"></span></button>
                <button type="button" class="platform-option" data-value="Xbox">Xbox <span class="indicator"></span></button>
                <button type="button" class="platform-option" data-value="PlayStation">PlayStation <span class="indicator"></span></button>
                <button type="button" class="platform-option" data-value="Switch">Nintendo Switch <span class="indicator"></span></button>
            </div>
            <small class="form-text text-muted">Click to select/deselect platforms.</small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" class="form-control" id="price" name="price" required step="0.01" placeholder="e.g., 29.99">
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Cover Image URL (Google Image Search)</label>
            <input type="url" class="form-control" id="image_url" name="image_url" placeholder="Paste Image URL here" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="Enter the author's name">
        </div>

        <div class="mb-3">
            <label for="release_date" class="form-label">Release Date</label>
            <input type="date" class="form-control" id="release_date" name="release_date">
        </div>

        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-success">Add Game</button>
        </div>
    </form>
</main>

<?php if ($successMessage || $errorMessage): ?>
    <div id="message-overlay">
        <div id="message-box">
            <?php if ($successMessage): ?>
                <p class="success-message"><?= $successMessage ?></p>
            <?php else: ?>
                <p class="error-message"><?= $errorMessage ?></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const messageOverlay = document.getElementById('message-overlay');
        const redirect = <?php echo $redirect ? 'true' : 'false'; ?>;

        setTimeout(function() {
            messageOverlay.style.display = 'none';
            if (redirect) {
                window.location.href = '../explore.php';
            }
        }, 2000);
    </script>
<?php endif; ?>

<script>
    const platformContainer = document.getElementById('platform-container');
    const platformOptions = document.querySelectorAll('.platform-option');
    const selectedPlatformsInput = document.getElementById('selected-platforms');
    const selectedValues = new Set();

    platformOptions.forEach(optionButton => {
        const indicatorSpan = optionButton.querySelector('.indicator');
        const value = optionButton.getAttribute('data-value');

        // Initialize with a cross
        indicatorSpan.textContent = '✕';
        indicatorSpan.classList.add('cross');

        optionButton.addEventListener('click', function() {
            if (selectedValues.has(value)) {
                selectedValues.delete(value);
                indicatorSpan.textContent = '✕';
                indicatorSpan.classList.remove('check');
                indicatorSpan.classList.add('cross');
                this.classList.remove('active');
            } else {
                selectedValues.add(value);
                indicatorSpan.textContent = '✓';
                indicatorSpan.classList.remove('cross');
                indicatorSpan.classList.add('check');
                this.classList.add('active');
            }

            // Update the hidden input field for form submission
            selectedPlatformsInput.value = Array.from(selectedValues).join(',');
        });
    });
</script>

<?php include '../Components/footer.php'; ?>

</body>
</html>