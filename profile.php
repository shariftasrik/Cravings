<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-container">
        <h1>My Profile</h1>

        <!-- First Name -->
        <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" value="" disabled>
            <div class="button-group">
                <button class="edit-button" onclick="enableEdit('first-name')">Enter</button>
                <button class="save-button" onclick="saveEdit('first-name')" style="display: none;">Save</button>
            </div>
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" value="" disabled>
            <div class="button-group">
                <button class="edit-button" onclick="enableEdit('last-name')">Enter</button>
                <button class="save-button" onclick="saveEdit('last-name')" style="display: none;">Save</button>
            </div>
        </div>

        <!-- Mobile Number -->
        <div class="form-group">
            <label for="mobile-number">Mobile Number</label>
            <input type="text" id="mobile-number" value="" disabled>
            <div class="button-group">
                <button class="edit-button" onclick="enableEdit('mobile-number')">Enter</button>
                <button class="save-button" onclick="saveEdit('mobile-number')" style="display: none;">Save</button>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" value="" disabled>
            <div class="button-group">
                <button class="edit-button" onclick="enableEdit('email')">Enter</button>
                <button class="save-button" onclick="saveEdit('email')" style="display: none;">Save</button>
            </div>
        </div>

        <!-- Password Section -->
        <div class="password-section">
            <h2>Password</h2>
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <div style="position: relative;">
                    <input type="password" id="current-password" placeholder="Enter your current password">
                    <button type="button" class="toggle-password" onclick="togglePassword('current-password')">&#128065;</button>
                </div>
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <div style="position: relative;">
                    <input type="password" id="new-password" placeholder="Enter a new password">
                    <button type="button" class="toggle-password" onclick="togglePassword('new-password')">&#128065;</button>
                </div>
            </div>
            <button class="save-button" style="background-color: #28a745; color: #fff;" onclick="updatePassword()">Save Password</button>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const inputField = document.getElementById(fieldId);
            const button = inputField.nextElementSibling;
            if (inputField.type === 'password') {
                inputField.type = 'text';
                button.innerHTML = '&#128065;'; // Eye icon
            } else {
                inputField.type = 'password';
                button.innerHTML = '&#128065;'; // Eye icon
            }
        }
    </script>
</body>
</html>