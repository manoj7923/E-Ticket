# 🚆 Mumbai Suburban Railway E-Ticket Portal - Deployment & Live Hosting Guide

Congratulations on building your first college project! This guide explains how to run, showcase, and deploy your upgraded **Mumbai Suburban Railway E-Ticket Platform (Western, Central & Harbour Lines)** live on the internet completely free of charge.

---

## ⚡ Option 1: Instant Local Testing (Zero Dependencies)
If you want to test and see your website running right now on your computer:
1. Double-click `run.bat` (or open PowerShell/Terminal and run `python serve.py`).
2. Your default web browser will immediately open to:  
   👉 **`http://localhost:8080`**
3. You can test:
   - Interactive Transit Map route booking across Western, Central & Harbour lines.
   - Dynamic fare calculation for Second Class, First Class, and AC Local EMU.
   - Dadar and Kurla interchange routing.
   - Payment gateway simulation with live UPI QR code.
   - Confirmed UTS boarding pass with real-time **12-Hour Validity countdown meter**.
   - Instant ticket cancellation with standard railway clerkage fee deduction.
   - Commercial Admin Operations Console with real-time analytics.

*(Note: If you want to test purely in the browser without starting the Python server, you can also directly double-click `demo.html` in your file explorer!)*

---

## 🌐 Option 2: Deploy Free to Cloud on Render.com (Full PHP + MySQL)
**Render** allows you to host full-stack PHP & MySQL applications with Docker for free.

### Steps to Deploy on Render:
1. Push your updated code to your GitHub repository:
   ```bash
   git add .
   git commit -m "Upgrade E-Ticket to multi-line suburban transit platform with map and 12h validity"
   git push origin main
   ```
2. Go to [Render.com](https://render.com) and sign in with your GitHub account.
3. Click **"New +"** ➔ **"Blueprint"**.
4. Select your `manoj7923/E-Ticket` repository.
5. Render will automatically read `render.yaml` and configure:
   - A free MySQL database
   - A free Dockerized Apache/PHP web service
6. Click **"Apply"**. Render will build and deploy your website with a free HTTPS URL (e.g. `https://mumbai-local-eticket.onrender.com`).

---

## ☁️ Option 3: Deploy Free to InfinityFree / 000webhost (Traditional cPanel PHP Hosting)
If you prefer traditional cPanel web hosting with phpMyAdmin:
1. Register for a free account at [InfinityFree](https://www.infinityfree.com/) or [000webhost](https://www.000webhost.com/).
2. Create a website and note your database credentials in the Control Panel.
3. Open **phpMyAdmin** from your control panel and import `db/schema.sql` (or `db/test_db.sql`).
4. Open the **File Manager** (or connect via FTP) and upload all files from this project into the `htdocs` or `public_html` directory.
5. Your website is immediately live!

---

## ⚡ Option 4: Deploy Free to Vercel / GitHub Pages (Instant Interactive Live Demo)
If you want a live portfolio demo link to share on LinkedIn or with recruiters:
1. **On Vercel**:
   - Go to [Vercel.com](https://vercel.com) and import your GitHub repo.
   - Vercel will automatically detect `vercel.json` and deploy `demo.html` to a fast edge URL (e.g. `https://mumbai-rail-eticket.vercel.app`).
2. **On GitHub Pages**:
   - In GitHub Settings ➔ Pages, enable GitHub Pages from `main` branch.
   - Set the custom domain or visit `https://manoj7923.github.io/E-Ticket/demo.html`.

---

## 🐳 Option 5: Run with Docker Compose
If you have Docker installed on your machine:
```bash
docker compose up -d
```
- Web Application: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081` (User: `root`, Password: `root_secret_pass`)
- MySQL Port: `3307`

---

## 🔑 Demo Account Credentials

| Portal | Username / ID | Password | Role |
|---|---|---|---|
| Passenger Login | `manoj` | `123` | Commuter / Booking |
| Passenger Login (Alt) | `demo` | `demo123` | Commuter / Booking |
| Admin Operations | `admin` | `admin123` | Commercial Superuser |
