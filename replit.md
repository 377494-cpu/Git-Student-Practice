# Profile Viewer Application

## Overview

A static profile viewer web application that displays personal profile cards for multiple users. The application reads profile data from a JSON file and renders interactive profile cards with a modern glassmorphism design aesthetic. Currently features profiles for individuals with sections covering identity, physical stats, favorites, gym stats, and skills/interests.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Frontend Architecture
- **Static HTML/CSS** - Pure vanilla approach without frameworks
- **Design Pattern**: Glassmorphism UI with gradient backgrounds and blur effects
- **Styling**: Inline CSS within HTML files using CSS custom properties (CSS variables)
- **Responsive Design**: CSS Grid with auto-fit for card layouts

### Backend Architecture
- **Python HTTP Server** - Simple static file server using Python's built-in `http.server` module
- **Port**: 5000, bound to 0.0.0.0 for external access
- **Caching**: Disabled via custom headers (no-cache, no-store, must-revalidate)
- **Socket Configuration**: Uses SO_REUSEADDR for quick server restarts

### Data Storage
- **JSON File** (`data.json`) - Flat file storage for profile data
- **Schema Structure**:
  - `identity`: Personal info (name, birthday, gender, location)
  - `physicalStats`: Height, weight, hair color, ethnicity
  - `favorites`: Food, artist, color, show, movie, book
  - `gymStats`: Bench, squat, deadlift PRs
  - `skillsAndInterests`: Hobbies, languages, coding experience

### File Structure
- `index.html` - Main profile grid/listing page
- `zaid.html` - Individual detailed profile page
- `data.json` - Profile data storage
- `server.py` - Static file server

## External Dependencies

### CDN Resources
- **Font Awesome 6.0.0** - Icon library loaded via cdnjs CDN (used in individual profile pages)

### Runtime Requirements
- **Python 3.x** - Required for running the static file server
- No database required
- No npm packages or build tools needed