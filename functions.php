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

/**
 * Calculates and returns gym ranks for all users
 * 
 * @return array The ranking data
 */
function getGymRanks() {
    $json = file_get_contents('data.json');
    $data = json_decode($json, true);
    
    $stats = ['prBench', 'prSquat', 'prDeadlift'];
    $ranks = [];
    
    foreach ($stats as $stat) {
        $values = [];
        foreach ($data as $index => $person) {
            $val = (int) filter_var($person['gymStats'][$stat], FILTER_SANITIZE_NUMBER_INT);
            $values[$index] = $val;
        }
        
        arsort($values);
        
        $rank = 1;
        $prevVal = null;
        $actualRank = 1;
        foreach ($values as $index => $val) {
            if ($prevVal !== null && $val < $prevVal) {
                $rank = $actualRank;
            }
            $ranks[$index][$stat] = $rank;
            $prevVal = $val;
            $actualRank++;
        }
    }
    
    return $ranks;
}

/**
 * Generates a similarity card HTML that finds people with shared hobbies or languages
 * 
 * @param string $currentFirstName The first name of the person whose profile is being viewed
 * @return string The HTML for the similarity card
 */
function renderSimilarityCard($currentFirstName) {
    return '
    <div class="card similarity-card">
        <div class="card-header">
            <i class="fas fa-users"></i>
            <h2>Common Interests</h2>
        </div>
        <div id="similarity-results" class="info-list">
            <p style="color: #94a3b8; font-size: 0.9rem;">Finding connections...</p>
        </div>
    </div>
    <script>
        (function() {
            const currentName = "' . addslashes($currentFirstName) . '";
            fetch("data.json")
                .then(res => res.json())
                .then(data => {
                    const me = data.find(p => p.identity.firstName === currentName);
                    if (!me) return;

                    const resultsContainer = document.getElementById("similarity-results");
                    resultsContainer.innerHTML = "";

                    const myHobbies = me.skillsAndInterests.hobbies || [];
                    const myLanguages = me.skillsAndInterests.languages || [];

                    let matchesFound = false;

                    data.forEach(person => {
                        if (person.identity.firstName === currentName) return;

                        const commonHobbies = (person.skillsAndInterests.hobbies || []).filter(h => myHobbies.includes(h));
                        const commonLanguages = (person.skillsAndInterests.languages || []).filter(l => myLanguages.includes(l));

                        if (commonHobbies.length > 0 || commonLanguages.length > 0) {
                            matchesFound = true;
                            const div = document.createElement("div");
                            div.style.marginBottom = "1rem";
                            div.style.paddingBottom = "0.5rem";
                            div.style.borderBottom = "1px solid rgba(255,255,255,0.05)";
                            
                            let html = `<div style="color: white; font-weight: 500; margin-bottom: 0.3rem;">${person.identity.firstName} ${person.identity.lastName}</div>`;
                            
                            if (commonHobbies.length > 0) {
                                html += `<div style="font-size: 0.8rem; color: #00d2ff;"><i class="fas fa-star" style="margin-right: 5px;"></i> Shared Hobbies: ${commonHobbies.join(", ")}</div>`;
                            }
                            if (commonLanguages.length > 0) {
                                html += `<div style="font-size: 0.8rem; color: #87CEEB;"><i class="fas fa-language" style="margin-right: 5px;"></i> Shared Languages: ${commonLanguages.join(", ")}</div>`;
                            }
                            
                            div.innerHTML = html;
                            resultsContainer.appendChild(div);
                        }
                    });

                    if (!matchesFound) {
                        resultsContainer.innerHTML = "<p style=\'color: #94a3b8; font-size: 0.85rem;\'>No direct matches found in hobbies or languages.</p>";
                    }
                });
        })();
    </script>';
}
?>