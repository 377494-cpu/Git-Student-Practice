<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nick Jaramillo | Personal Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #87CEEB; /* Baby Blue */
            --secondary: #3a7bd5;
            --bg: #0f172a;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg);
            color: white;
            overflow-x: hidden;
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .hero {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: 800;
            box-shadow: 0 0 30px rgba(135, 206, 235, 0.3);
            border: 4px solid var(--glass-border);
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .tagline {
            color: #94a3b8;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .privacy-container {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
        }

        .privacy-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(25px);
            transition: all 0.5s ease;
            border-radius: 24px;
            cursor: pointer;
            border: 1px solid var(--glass-border);
        }

        .privacy-overlay i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
            text-shadow: 0 0 20px rgba(135, 206, 235, 0.5);
        }

        .privacy-overlay p {
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9rem;
            color: #f1f5f9;
        }

        .privacy-unlocked .privacy-overlay {
            opacity: 0;
            pointer-events: none;
            transform: scale(1.1);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            transition: filter 0.5s ease;
        }

        .privacy-locked .grid {
            filter: blur(10px);
            pointer-events: none;
        }

        .card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-header i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        h2 {
            font-size: 1.25rem;
            color: #f1f5f9;
        }

        .info-list {
            list-style: none;
        }

        .info-list li {
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            color: #94a3b8;
        }

        .info-list li span:last-child {
            color: white;
            font-weight: 500;
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .tag {
            background: rgba(135, 206, 235, 0.15);
            color: var(--primary);
            padding: 0.4rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid rgba(135, 206, 235, 0.2);
        }

        .progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 4px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .back-btn:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Profiles
        </a>

        <div class="hero">
            <div class="profile-img">NJ</div>
            <h1 id="full-name">Nick Jaramillo</h1>
            <p class="tagline" id="tagline">Tech Enthusiast</p>
        </div>

        <div class="privacy-container privacy-locked" id="privacy-box">
            <?php echo renderPrivacyOverlay('Nick', 'privacy-box'); ?>
            <div class="grid">
                <!-- Identity -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        <h2>Identity</h2>
                    </div>
                    <ul class="info-list">
                        <li><span>Birthday</span> <span id="birthday">-</span></li>
                        <li><span>Gender</span> <span id="gender">-</span></li>
                        <li><span>Location</span> <span id="location">-</span></li>
                        <li><span>Ethnicity</span> <span id="ethnicity">-</span></li>
                    </ul>
                </div>

                <!-- Gym Statistics -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-dumbbell"></i>
                        <h2>Gym Statistics</h2>
                    </div>
                    <div class="info-list">
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span>Bench Press</span>
                                <span id="bench">-</span>
                            </div>
                            <div class="progress-bar"><div class="progress-fill" style="width: 45%"></div></div>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span>Squat</span>
                                <span id="squat">-</span>
                            </div>
                            <div class="progress-bar"><div class="progress-fill" style="width: 60%"></div></div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span>Deadlift</span>
                                <span id="deadlift">-</span>
                            </div>
                            <div class="progress-bar"><div class="progress-fill" style="width: 70%"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Favorites -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-heart"></i>
                        <h2>Favorites</h2>
                    </div>
                    <ul class="info-list">
                        <li><span>Cuisine</span> <span id="cuisine">-</span></li>
                        <li><span>Artist</span> <span id="artist">-</span></li>
                        <li><span>Movie</span> <span id="movie">-</span></li>
                        <li><span>Show</span> <span id="show">-</span></li>
                        <li><span>Book</span> <span id="book">-</span></li>
                    </ul>
                </div>

                <!-- Coding & Experience -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-code"></i>
                        <h2>Coding & Experience</h2>
                    </div>
                    <p id="coding-exp" style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 1rem;"></p>
                    <div class="tags" id="projects-tags"></div>
                </div>

                <!-- Hobbies -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-icons"></i>
                        <h2>Hobbies</h2>
                    </div>
                    <div class="tags" id="hobbies-tags"></div>
                </div>

                <!-- Languages -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-language"></i>
                        <h2>Languages</h2>
                    </div>
                    <div class="tags" id="languages-tags"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        fetch('data.json')
            .then(res => res.json())
            .then(data => {
                const nick = data.find(p => p.identity.firstName === "Nick");
                if (!nick) return;

                document.getElementById('full-name').textContent = `${nick.identity.firstName} ${nick.identity.lastName}`;
                document.getElementById('birthday').textContent = nick.identity.birthday;
                document.getElementById('gender').textContent = nick.identity.gender;
                document.getElementById('location').textContent = nick.identity.location || 'N/A';
                document.getElementById('ethnicity').textContent = nick.physicalStats.ethnicity;
                document.getElementById('bench').textContent = nick.gymStats.prBench;
                document.getElementById('squat').textContent = nick.gymStats.prSquat;
                document.getElementById('deadlift').textContent = nick.gymStats.prDeadlift;
                document.getElementById('cuisine').textContent = nick.favorites.foodCuisine;
                document.getElementById('artist').textContent = nick.favorites.artist;
                document.getElementById('movie').textContent = nick.favorites.movie;
                document.getElementById('show').textContent = nick.favorites.show;
                document.getElementById('book').textContent = nick.favorites.book;
                document.getElementById('coding-exp').textContent = nick.skillsAndInterests.codingExperience;

                const renderTags = (id, list) => {
                    const container = document.getElementById(id);
                    if (!list) return;
                    list.forEach(item => {
                        const span = document.createElement('span');
                        span.className = 'tag';
                        span.textContent = item;
                        container.appendChild(span);
                    });
                };

                renderTags('hobbies-tags', nick.skillsAndInterests.hobbies || []);
                renderTags('languages-tags', nick.skillsAndInterests.languages || []);
            });
    </script>
</body>
</html>