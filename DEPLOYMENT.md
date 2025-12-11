# StudentSphere Deployment Guide

## Local Development with Docker

### Prerequisites
- Docker and Docker Compose installed
- Port 80 available

### Running Locally
```bash
docker-compose up --build
```

This will:
- Start a PHP 8.2 Apache server on `http://localhost`
- Start a MySQL 8.0 database
- Mount your project files for live editing

### Environment Variables
Copy `.env.example` to `.env` and modify as needed:
```bash
cp .env.example .env
```

## Deployment on Render

### Prerequisites
1. A GitHub repository connected to Render
2. A Render account (free tier available)

### Step-by-Step Instructions

1. **Create PostgreSQL Database on Render**
   - Go to Render Dashboard
   - Click "New" → "PostgreSQL"
   - Set name: `studentsphere`
   - Choose free plan
   - Create database
   - Note the connection details

2. **Connect GitHub Repository**
   - Push your code to GitHub with the `render.yaml` file
   - Go to Render Dashboard
   - Click "New" → "Web Service"
   - Select your GitHub repository
   - Choose "Docker" as runtime
   - Set build command: (leave empty, uses Dockerfile)
   - Set start command: (leave empty, Apache starts automatically)

3. **Configure Environment Variables**
   - In Render dashboard, go to your service settings
   - Add environment variables (these will be auto-populated if using render.yaml):
     - `DB_DRIVER` = `pgsql`
     - `DB_HOST` = (from your PostgreSQL instance)
     - `DB_USER` = (from your PostgreSQL instance)
     - `DB_PASSWORD` = (from your PostgreSQL instance)
     - `DB_NAME` = `studentsphere`
     - `DB_PORT` = `5432`

4. **Deploy**
   - Push to GitHub
   - Render will automatically build and deploy your Docker image
   - Your site will be available at your Render URL

## Database Migration (MySQL to PostgreSQL)

When migrating from MySQL to PostgreSQL, you may need to:

1. **Update SQL Syntax**
   - PostgreSQL uses different SQL syntax in some cases
   - Example: Use `SERIAL` instead of `AUTO_INCREMENT`

2. **Update Column Types**
   - Replace `VARCHAR(255)` with `VARCHAR(255)` (same)
   - Replace `DATETIME` with `TIMESTAMP`
   - Replace `INT` with `INTEGER`

3. **Sample Schema Migration**
```sql
-- PostgreSQL version
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Important Notes

- The `apache.config` file is used for custom Apache configuration
- The Dockerfile exposes port 8080 for Render compatibility
- Local development uses port 80 (or 8080 if redirected)
- AuthController.php is in `.gitignore` and won't be deployed

## Troubleshooting

### Database Connection Issues
- Verify environment variables are correctly set
- Check that PostgreSQL database is running (on Render)
- Review logs in Render dashboard

### Port Issues
- Render requires services to listen on port 8080
- The Dockerfile is pre-configured for this
- Local development can use port 80 via docker-compose mapping

### File Permissions
- Ensure `uploads/` directory exists and is writable
- Docker handles this automatically in the Dockerfile

## Support
For Render-specific issues: https://render.com/docs
For PostgreSQL docs: https://www.postgresql.org/docs/
