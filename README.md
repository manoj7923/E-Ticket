# 🚆 Mumbai Suburban Railway E-Ticket Portal (IRCTC & UTS On Mobile)
> **A high-performance, responsive suburban transit web platform connecting Western, Central, and Harbour lines with Interactive Transit Map Booking and 12-Hour Ticket Validity Enforcement.**  
> *Originally engineered by **Manoj Gupta** as a college flagship project, now elevated into a production-grade multi-line suburban transit platform.*

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777bb4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479a1?style=for-the-badge&logo=mysql&logoColor=white)
![SQLite Fallback](https://img.shields.io/badge/SQLite-Zero--Config-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Design](https://img.shields.io/badge/Design-100%25%20Mobile%20Responsive-brightgreen?style=for-the-badge)

---

## 🌟 Key Highlights & Modern Upgrades

- 🗺️ **Interactive Transit Map Booking**:
  - Point-and-click route selection directly on an interactive SVG schematic transit map.
  - Dynamic line filters: **All Lines**, **Western Line (WR)**, **Central Line (CR)**, **Harbour Line (HR)**.
  - Dynamic station pins with glowing pulse beacons and animated marching track connectors.
  - Floating Real-Time HUD card previewing distance, duration, interchanges, and live fare.

- 🚆 **Full 3-Line Mumbai Suburban Coverage (89+ Stations)**:
  - **Western Line (WR)**: 37 stations from Churchgate (0.0 km) to Dahanu Road (124.0 km).
  - **Central Main Line (CR)**: 32 stations from CSMT (0.0 km) to Kalyan / Kasara / Karjat (121.0 km).
  - **Harbour Line (HR)**: 25 stations from CSMT (0.0 km) to Panvel (53.0 km) and Wadala-Bandra/Goregaon branch.
  - **Smart Interchange Routing**: Automatic transfer detection at **Dadar** (WR ⇄ CR), **Kurla** (CR ⇄ HR), and **Wadala Road** (HR ⇄ WR).

- ⏱️ **12-Hour Ticket Validity Engine**:
  - Confirmed suburban tickets carry a strict **12-Hour Validity window** from time of issuance.
  - Live real-time countdown timer (`11h 59m 45s remaining`) and animated SVG progress bar.
  - Cryptographic QR code with embedded 12-hour expiry timestamp for anti-fraud TTE inspection.

- 📱 **100% Mobile-First Responsive Design**:
  - Polished transit design system with authentic railway color palettes, typography, glassmorphism cards, and mobile slide-out navigation.

- 💰 **Dynamic Multi-Line Fare Calculation**:
  - Automated distance-tiered fare calculation in Indian Rupees (₹) for Second Class (II), First Class (FC), and AC Local EMU.
  - Supports Single and Return journeys with automatic return discounts.

- 💳 **Realistic Payment Gateway**:
  - 4 Payment Methods: Dynamic UPI QR code with countdown timer, Debit/Credit Card, Net Banking (SBI, HDFC, ICICI, etc.), and R-Wallet.

- ❌ **Ticket Cancellation & Instant Refund**:
  - Compliant with Indian Railways suburban ticket cancellation policy: deducts nominal ₹5 clerkage fee and issues immediate audit refund.

- 🚨 **Rail Madad Grievance Helpdesk**:
  - Integrated passenger grievance lodging system with official helplines (139, 182, 1512).

- 📊 **Commercial Admin Operations Console**:
  - Real-time KPIs for registered passengers, confirmed bookings, revenue, and active routes across all 3 suburban corridors.

- 🛡️ **Zero-Failure Database Layer**:
  - Dual-mode architecture in `db_conn.php`: connects to MySQL/MariaDB in production, and automatically falls back to embedded SQLite (`db/e_ticket.sqlite`) with automatic schema initialization when running offline or without MySQL installed.

---

## 🗺️ Suburban Network Architecture

```
Western Line (WR - Blue)      Central Main Line (CR - Red)       Harbour Line (HR - Teal)
Churchgate (CCG)              CSMT (Central)                     CSMT (Harbour)
Marine Lines                  Masjid                             Dockyard Road
Charni Road                   Sandhurst Road                     Reay Road
Grant Road                    Byculla                            Cotton Green
Mumbai Central                Chinchpokli                        Sewri
Mahalaxmi                     Currey Road                        Vadala Road (Interchange to WR)
Lower Parel                   Parel (Interchange to WR)          GTB Nagar
Prabhadevi ------------------ Dadar (WR ⇄ CR Interchange) ------ Chunabhatti
Matunga Road                  Matunga                            Kurla (CR ⇄ HR Interchange)
Mahim                         Sion                               Tilak Nagar
Bandra (WR ⇄ HR link)         Kurla (CR ⇄ HR Interchange) ------ Chembur
Khar / Santacruz / Vile Parle Vidyavihar                         Govandi
Andheri                       Ghatkopar (Metro 1)                Mankhurd
Goregaon                      Vikhroli                           Vashi (Navi Mumbai)
Borivali                      Bhandup                            Sanpada
Bhayandar                     Mulund                             Juinagar
Vasai Road                    Thane (Trans-Harbour link)         Nerul
Virar                         Dombivli                           Belapur CBD
Dahanu Road (124 km)          Kalyan (Kasara/Karjat, 121 km)     Panvel (53 km)
```

---

## 🚀 Quick Start (Instant Local Preview)

### Method 1: Instant Python Runner (Zero Dependencies)
Double-click `run.bat` or run:
```powershell
python serve.py
```
Then open: **`http://localhost:8080`** (or open `demo.html` directly in your browser).

### Method 2: Standard XAMPP / WAMP / Apache PHP
1. Copy the folder `E-Ticket-main` to `C:\xampp\htdocs\e-ticket`.
2. Start Apache and MySQL in XAMPP Control Panel.
3. Open `http://localhost/e-ticket/`.
*(If MySQL is not running, the system automatically uses SQLite with zero configuration!)*

---

## 🔑 Default Credentials

| Portal | Username / ID | Password | Role |
|---|---|---|---|
| Passenger Login | `manoj` | `123` | Commuter / Booking |
| Passenger Login (Alt) | `demo` | `demo123` | Commuter / Booking |
| Admin Operations | `admin` | `admin123` | Commercial Superuser |

---

## 📦 How to Publish This Project to GitHub

Follow these simple steps in terminal or Git Bash to publish the project to your GitHub account:

```bash
# 1. Initialize Git repository
git init

# 2. Add all files
git add .

# 3. Create initial commit
git commit -m "feat: complete Mumbai Suburban multi-line e-ticketing platform with interactive map and 12h validity"

# 4. Link to your GitHub repository (replace with your repo URL)
git remote add origin https://github.com/manoj7923/E-Ticket.git

# 5. Push to GitHub
git branch -M main
git push -u origin main
```

---

## 🌐 Cloud Deployment Options

Refer to the included [DEPLOYMENT.md](DEPLOYMENT.md) for full instructions:
- **Render.com**: Instant one-click Dockerized full-stack deployment (`render.yaml`).
- **Vercel / GitHub Pages**: Deploy the interactive `demo.html` client demo (`vercel.json`).
- **cPanel / Shared Hosting (InfinityFree, Hostinger)**: Upload files via FTP/File Manager and import `db/schema.sql`.

---

## 👤 Author & Credits

- **Project Creator & Lead Developer**: Manoj Gupta ([@manoj7923](https://github.com/manoj7923))
- **Inspiration**: Indian Railways CRIS UTS on Mobile & IRCTC Next-Generation Suburban Ticketing
- **License**: MIT License