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

// Enable editing for the input field
function enableEdit(fieldId) {
    const inputField = document.getElementById(fieldId);
    const saveButton = inputField.parentElement.querySelector('.save-button');
    const editButton = inputField.parentElement.querySelector('.edit-button');

    inputField.disabled = false; // Enable the input
    inputField.focus(); // Focus on the input
    editButton.style.display = 'none'; // Hide the edit button
    saveButton.style.display = 'inline-block'; // Show the save button
}

// Save the edited field, disable it again, and store it in localStorage
function saveEdit(fieldId) {
    const inputField = document.getElementById(fieldId);
    const saveButton = inputField.parentElement.querySelector('.save-button');
    const editButton = inputField.parentElement.querySelector('.edit-button');

    // Save the field value in localStorage
    const fieldValue = inputField.value;
    localStorage.setItem(fieldId, fieldValue);

    // Add the 'saved' class to change the text color to black
    inputField.classList.add('saved');

    alert(fieldId.replace('-', ' ') + " updated successfully!");

    inputField.disabled = true; // Disable the input
    saveButton.style.display = 'none'; // Hide the save button
    editButton.style.display = 'inline-block'; // Show the edit button
}

// Update password and save to localStorage
function updatePassword() {
    const currentPasswordField = document.getElementById('current-password');
    const newPasswordField = document.getElementById('new-password');
    
    const currentPassword = currentPasswordField.value;
    const newPassword = newPasswordField.value;

    if (currentPassword === '' || newPassword === '') {
        alert('Please fill in both the current and new password fields.');
        return;
    }

    // Check if the password is being saved for the first time or if the current password exists in localStorage
    const savedPassword = localStorage.getItem('password');

    // If no password is saved, allow the user to save the new password directly
    if (savedPassword === null) {
        // Save the new password to localStorage
        localStorage.setItem('password', newPassword);
        alert('Password set successfully!');

        // Clear the password fields after saving
        currentPasswordField.value = '';
        newPasswordField.value = '';
        return;
    }

    // If there is a saved password, check if the current password matches the saved one
    if (currentPassword !== savedPassword) {
        alert('Current password is incorrect.');
        return;
    }

    // If the current password matches, save the new password to localStorage
    localStorage.setItem('password', newPassword);
    alert('Password updated successfully!');

    // Clear the password fields after saving
    currentPasswordField.value = '';
    newPasswordField.value = '';
}

// Load saved values from localStorage when the page loads
document.addEventListener('DOMContentLoaded', () => {
    const fields = ['first-name', 'last-name', 'mobile-number', 'email'];
    fields.forEach(fieldId => {
        const savedValue = localStorage.getItem(fieldId);
        if (savedValue) {
            const inputField = document.getElementById(fieldId);
            inputField.value = savedValue; // Set the value from localStorage
            inputField.classList.add('saved'); // Add the 'saved' class to change color to black
        }
    });
});
