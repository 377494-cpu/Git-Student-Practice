<?php
/**
 * Shared functions for the Profile Viewer application
 */

/**
 * Generates the privacy overlay HTML and associated JavaScript for profile unlocking
 * 
 * @param string $correctName The name required to unlock the profile
 * @param string $containerId The ID of the container element
 * @return string The HTML for the privacy overlay
 */
function renderPrivacyOverlay($correctName, $containerId = 'privacy-box') {
    return '
    <div class="privacy-overlay" onclick="unlockProfile(\'' . addslashes($correctName) . '\', \'' . addslashes($containerId) . '\')">
        <i class="fas fa-eye-slash"></i>
        <p>Click to Unlock Profile</p>
    </div>
    <script>
        if (typeof unlockProfile !== "function") {
            function unlockProfile(correctName, containerId) {
                const nameInput = prompt("Enter the first name of the person whose profile this is:");
                if (nameInput && nameInput.toLowerCase() === correctName.toLowerCase()) {
                    const container = document.getElementById(containerId);
                    if (container) {
                        container.classList.remove("privacy-locked");
                        container.classList.add("privacy-unlocked");
                    }
                } else if (nameInput) {
                    alert("Incorrect name. Access denied.");
                }
            }
        }
    </script>';
}
?>