<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Profile Viewer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            padding: 2rem;
            color: #fff;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            background: linear-gradient(90deg, #00d2ff, #3a7bd5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .profiles-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .profile-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .name {
            font-size: 1.4rem;
            font-weight: 600;
        }
        
        .birthday {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .section {
            margin-bottom: 1rem;
        }
        
        .section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #00d2ff;
            margin-bottom: 0.5rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        
        .info-item {
            font-size: 0.9rem;
        }
        
        .info-label {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }
        
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .tag {
            background: rgba(0, 210, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            color: #00d2ff;
        }
        
        .gym-stats {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
        }
        
        .stat {
            text-align: center;
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            padding: 0.5rem;
            border-radius: 8px;
        }
        
        .stat-value {
            font-size: 1rem;
            font-weight: 600;
            color: #3a7bd5;
        }
        
        .stat-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Gym Ranks Styles */
        .gym-stats-container {
            position: relative;
        }

        .rank-badge {
            position: absolute;
            top: -10px;
            right: -5px;
            background: #ffd700;
            color: #000;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            display: none;
            z-index: 10;
        }

        .stat:hover .rank-badge {
            display: block;
        }

        .rank-card {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid #00d2ff;
            border-radius: 8px;
            padding: 10px;
            width: 200px;
            display: none;
            z-index: 100;
            margin-bottom: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }

        .gym-stats-container:hover .rank-card {
            display: block;
        }

        .rank-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        .rank-item:last-child {
            margin-bottom: 0;
        }

        .rank-number {
            color: #ffd700;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Profile Viewer</h1>
    <div class="profiles-container" id="profiles"></div>

    <script>
        // Rankings will be calculated on the client side for reactivity
        function calculateRanks(data) {
            const stats = ['prBench', 'prSquat', 'prDeadlift'];
            const rankings = {};

            stats.forEach(stat => {
                const values = data.map((p, i) => ({
                    index: i,
                    val: parseInt(p.gymStats[stat].replace(/[^0-9]/g, ''))
                }));

                values.sort((a, b) => b.val - a.val);

                let rank = 1;
                values.forEach((v, i) => {
                    if (i > 0 && v.val < values[i-1].val) {
                        rank = i + 1;
                    }
                    if (!rankings[v.index]) rankings[v.index] = {};
                    rankings[v.index][stat] = rank;
                });
            });
            return rankings;
        }

        fetch('data.json')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('profiles');
                const rankings = calculateRanks(data);
                
                data.forEach((person, index) => {
                    const personRanks = rankings[index];
                    const initials = person.identity.firstName[0] + person.identity.lastName[0];
                    const card = document.createElement('div');
                    card.className = 'profile-card';
                    
                    // Added Arsen to the condition below
                    card.innerHTML = `
                        <div class="profile-header">
                            <div class="avatar">${initials}</div>
                            <div>
                                <div class="name">${person.identity.firstName} ${person.identity.lastName}</div>
                                <div class="birthday">${person.identity.birthday} | ${person.identity.gender}</div>
                                ${person.identity.firstName === 'Zaid' || person.identity.firstName === 'Darius' || person.identity.firstName === 'Arsen' || person.identity.firstName === 'Nick' ? `<a href="${person.identity.firstName.toLowerCase()}.php" style="color: #00d2ff; text-decoration: none; font-size: 0.8rem; display: block; margin-top: 0.5rem;">View Full Profile →</a>` : ''}
                            </div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Physical Stats</div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Height</div>
                                    ${person.physicalStats.height}
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Weight</div>
                                    ${person.physicalStats.weight}
                                </div>
                            </div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Gym PRs</div>
                            <div class="gym-stats-container">
                                <div class="rank-card">
                                    <div style="font-size: 0.75rem; color: #00d2ff; margin-bottom: 8px; border-bottom: 1px solid rgba(0,210,255,0.2); padding-bottom: 4px;">Leaderboard Rank</div>
                                    <div class="rank-item">
                                        <span>Bench Press</span>
                                        <span class="rank-number">#${personRanks.prBench}</span>
                                    </div>
                                    <div class="rank-item">
                                        <span>Squat</span>
                                        <span class="rank-number">#${personRanks.prSquat}</span>
                                    </div>
                                    <div class="rank-item">
                                        <span>Deadlift</span>
                                        <span class="rank-number">#${personRanks.prDeadlift}</span>
                                    </div>
                                </div>
                                <div class="gym-stats">
                                    <div class="stat" style="position: relative;">
                                        <div class="rank-badge">#${personRanks.prBench}</div>
                                        <div class="stat-value">${person.gymStats.prBench}</div>
                                        <div class="stat-label">Bench</div>
                                    </div>
                                    <div class="stat" style="position: relative;">
                                        <div class="rank-badge">#${personRanks.prSquat}</div>
                                        <div class="stat-value">${person.gymStats.prSquat}</div>
                                        <div class="stat-label">Squat</div>
                                    </div>
                                    <div class="stat" style="position: relative;">
                                        <div class="rank-badge">#${personRanks.prDeadlift}</div>
                                        <div class="stat-value">${person.gymStats.prDeadlift}</div>
                                        <div class="stat-label">Deadlift</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Favorites</div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Cuisine</div>
                                    ${person.favorites.foodCuisine}
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Artist</div>
                                    ${person.favorites.artist}
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Show</div>
                                    ${person.favorites.show}
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Movie</div>
                                    ${person.favorites.movie}
                                </div>
                            </div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Languages</div>
                            <div class="tags">
                                ${person.skillsAndInterests.languages.map(lang => `<span class="tag">${lang}</span>`).join('')}
                            </div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Hobbies</div>
                            <div class="tags">
                                ${person.skillsAndInterests.hobbies.map(hobby => `<span class="tag">${hobby}</span>`).join('')}
                            </div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Coding Experience</div>
                            <div class="info-item">${person.skillsAndInterests.codingExperience}</div>
                        </div>
                    `;
                    
                    container.appendChild(card);
                });
            })
            .catch(error => {
                console.error('Error loading data:', error);
                document.getElementById('profiles').innerHTML = '<p style="text-align: center;">Error loading profiles</p>';
            });
    </script>
</body>
</html>