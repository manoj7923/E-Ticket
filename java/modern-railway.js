/**
 * E-Ticket Modern Railway Interactive Engine
 * Mumbai Suburban Transit Network: Western, Central & Harbour Lines
 * Includes Map-Based Interactive Route Booking & 12-Hour Ticket Validity
 */

// Comprehensive Mumbai Suburban Station Matrix
const MUMBAI_SUBURBAN_NETWORK = [
  // ================= WESTERN LINE (WR - Blue) =================
  { code: 'CCG', name: 'Churchgate', line: 'WR', km: 0.0, x: 120, y: 460, interchange: null },
  { code: 'MEL', name: 'Marine Lines', line: 'WR', km: 1.4, x: 120, y: 435, interchange: null },
  { code: 'CYR', name: 'Charni Road', line: 'WR', km: 2.3, x: 120, y: 410, interchange: null },
  { code: 'GTR', name: 'Grant Road', line: 'WR', km: 3.7, x: 120, y: 385, interchange: null },
  { code: 'MMCT', name: 'Mumbai Central', line: 'WR', km: 4.7, x: 120, y: 360, interchange: 'Outstation Terminus' },
  { code: 'MX', name: 'Mahalaxmi', line: 'WR', km: 6.0, x: 120, y: 335, interchange: null },
  { code: 'PL', name: 'Lower Parel', line: 'WR', km: 7.5, x: 120, y: 310, interchange: null },
  { code: 'PBHD', name: 'Prabhadevi', line: 'WR', km: 8.8, x: 120, y: 285, interchange: 'Parel (CR)' },
  { code: 'DDR_WR', name: 'Dadar (WR)', line: 'WR', km: 10.2, x: 120, y: 260, interchange: 'Dadar (CR)' },
  { code: 'MRU', name: 'Matunga Road', line: 'WR', km: 11.4, x: 120, y: 235, interchange: null },
  { code: 'MM', name: 'Mahim Junction', line: 'WR', km: 12.8, x: 120, y: 210, interchange: 'Harbour Line Branch' },
  { code: 'BA', name: 'Bandra', line: 'WR', km: 14.8, x: 120, y: 185, interchange: 'Harbour Line Branch' },
  { code: 'KHAR', name: 'Khar Road', line: 'WR', km: 16.5, x: 120, y: 160, interchange: null },
  { code: 'STC', name: 'Santacruz', line: 'WR', km: 18.0, x: 120, y: 140, interchange: null },
  { code: 'VLP', name: 'Vile Parle', line: 'WR', km: 19.8, x: 120, y: 120, interchange: null },
  { code: 'ADH', name: 'Andheri', line: 'WR', km: 21.8, x: 120, y: 100, interchange: 'Metro 1 & Harbour Branch' },
  { code: 'GMN', name: 'Goregaon', line: 'WR', km: 27.0, x: 120, y: 80, interchange: 'Harbour Branch Terminus' },
  { code: 'MDD', name: 'Malad', line: 'WR', km: 29.8, x: 120, y: 65, interchange: null },
  { code: 'KNDI', name: 'Kandivali', line: 'WR', km: 31.8, x: 120, y: 50, interchange: null },
  { code: 'BVI', name: 'Borivali', line: 'WR', km: 34.2, x: 120, y: 35, interchange: 'Fast EMU Hub' },
  { code: 'BYR', name: 'Bhayandar', line: 'WR', km: 43.8, x: 120, y: 20, interchange: null },
  { code: 'BSR', name: 'Vasai Road', line: 'WR', km: 52.0, x: 120, y: 10, interchange: 'CR Diva Link' },
  { code: 'VR', name: 'Virar', line: 'WR', km: 60.0, x: 120, y: 2, interchange: 'Terminus Fast Hub' },

  // ================= CENTRAL MAIN LINE (CR - Red) =================
  { code: 'CSMT_CR', name: 'CSMT (Central)', line: 'CR', km: 0.0, x: 260, y: 460, interchange: 'Harbour Line Terminus' },
  { code: 'MSD_CR', name: 'Masjid (CR)', line: 'CR', km: 1.5, x: 260, y: 435, interchange: 'Harbour Line' },
  { code: 'SNRD_CR', name: 'Sandhurst Road (CR)', line: 'CR', km: 2.5, x: 260, y: 410, interchange: 'Harbour Line' },
  { code: 'BY', name: 'Byculla', line: 'CR', km: 4.0, x: 260, y: 375, interchange: null },
  { code: 'CHG', name: 'Chinchpokli', line: 'CR', km: 5.2, x: 260, y: 345, interchange: null },
  { code: 'CRD', name: 'Currey Road', line: 'CR', km: 6.3, x: 260, y: 315, interchange: null },
  { code: 'PR', name: 'Parel', line: 'CR', km: 7.5, x: 260, y: 285, interchange: 'Prabhadevi (WR)' },
  { code: 'DDR_CR', name: 'Dadar (CR)', line: 'CR', km: 9.0, x: 260, y: 260, interchange: 'Dadar (WR)' },
  { code: 'MTN', name: 'Matunga', line: 'CR', km: 10.5, x: 260, y: 235, interchange: null },
  { code: 'SIN', name: 'Sion', line: 'CR', km: 13.0, x: 260, y: 205, interchange: null },
  { code: 'CLA_CR', name: 'Kurla (CR)', line: 'CR', km: 15.5, x: 260, y: 175, interchange: 'Kurla (Harbour)' },
  { code: 'VVH', name: 'Vidyavihar', line: 'CR', km: 17.5, x: 260, y: 150, interchange: null },
  { code: 'GC', name: 'Ghatkopar', line: 'CR', km: 19.5, x: 260, y: 125, interchange: 'Metro 1 Interchange' },
  { code: 'VK', name: 'Vikhroli', line: 'CR', km: 23.0, x: 260, y: 100, interchange: null },
  { code: 'BND', name: 'Bhandup', line: 'CR', km: 27.0, x: 260, y: 80, interchange: null },
  { code: 'MLND', name: 'Mulund', line: 'CR', km: 31.0, x: 260, y: 60, interchange: null },
  { code: 'TNA', name: 'Thane', line: 'CR', km: 34.0, x: 260, y: 40, interchange: 'Trans-Harbour Line' },
  { code: 'DI', name: 'Dombivli', line: 'CR', km: 48.5, x: 260, y: 20, interchange: 'Fast EMU Hub' },
  { code: 'KYN', name: 'Kalyan Junction', line: 'CR', km: 54.0, x: 260, y: 5, interchange: 'Kasara & Karjat Routes' },

  // ================= HARBOUR LINE (HR - Teal) =================
  { code: 'CSMT_HR', name: 'CSMT (Harbour)', line: 'HR', km: 0.0, x: 275, y: 460, interchange: 'Central Line Terminus' },
  { code: 'DKRD', name: 'Dockyard Road', line: 'HR', km: 3.8, x: 330, y: 390, interchange: null },
  { code: 'RRD', name: 'Reay Road', line: 'HR', km: 4.9, x: 340, y: 360, interchange: null },
  { code: 'CTGN', name: 'Cotton Green', line: 'HR', km: 5.9, x: 350, y: 330, interchange: null },
  { code: 'SVE', name: 'Sewri', line: 'HR', km: 7.2, x: 360, y: 300, interchange: null },
  { code: 'VDLR', name: 'Vadala Road', line: 'HR', km: 9.3, x: 360, y: 260, interchange: 'Western Line Branch (Bandra)' },
  { code: 'GTBN', name: 'GTB Nagar', line: 'HR', km: 11.5, x: 370, y: 220, interchange: null },
  { code: 'CHF', name: 'Chunabhatti', line: 'HR', km: 13.0, x: 380, y: 195, interchange: null },
  { code: 'CLA_HR', name: 'Kurla (Harbour)', line: 'HR', km: 15.0, x: 275, y: 175, interchange: 'Kurla (Central)' },
  { code: 'TKNG', name: 'Tilak Nagar', line: 'HR', km: 17.0, x: 420, y: 175, interchange: null },
  { code: 'CMBR', name: 'Chembur', line: 'HR', km: 18.5, x: 450, y: 175, interchange: 'Monorail' },
  { code: 'GV', name: 'Govandi', line: 'HR', km: 20.0, x: 480, y: 175, interchange: null },
  { code: 'MNKD', name: 'Mankhurd', line: 'HR', km: 22.0, x: 510, y: 175, interchange: null },
  { code: 'VSH', name: 'Vashi', line: 'HR', km: 29.0, x: 580, y: 175, interchange: 'Trans-Harbour (Thane)' },
  { code: 'SNCR', name: 'Sanpada', line: 'HR', km: 31.0, x: 610, y: 190, interchange: 'Trans-Harbour' },
  { code: 'JNJ', name: 'Juinagar', line: 'HR', km: 33.0, x: 640, y: 210, interchange: 'Trans-Harbour' },
  { code: 'NEU', name: 'Nerul', line: 'HR', km: 35.5, x: 670, y: 235, interchange: 'Trans-Harbour' },
  { code: 'SWDV', name: 'Seawoods-Darave', line: 'HR', km: 38.0, x: 700, y: 260, interchange: null },
  { code: 'BEPR', name: 'Belapur CBD', line: 'HR', km: 41.0, x: 730, y: 290, interchange: null },
  { code: 'KHAG', name: 'Kharghar', line: 'HR', km: 44.5, x: 760, y: 320, interchange: null },
  { code: 'PNVL', name: 'Panvel', line: 'HR', km: 53.0, x: 820, y: 380, interchange: 'Terminus & Konkan Railway' }
];

// Helper: Find station by name
function findStation(name) {
  if (!name) return null;
  const clean = name.toLowerCase().replace(/\s*\(wr\)|\s*\(cr\)|\s*\(harbour\)/g, '').trim();
  return MUMBAI_SUBURBAN_NETWORK.find(s => {
    const sClean = s.name.toLowerCase().replace(/\s*\(wr\)|\s*\(cr\)|\s*\(harbour\)/g, '').trim();
    return sClean === clean || s.name.toLowerCase() === name.toLowerCase();
  });
}

// Multi-Line Route & Fare Calculator with Interchanges
function calculateMultiLineFare(fromName, toName, travelClass = 'Second Class', tripType = 'Single') {
  const fromSt = findStation(fromName);
  const toSt = findStation(toName);

  if (!fromSt || !toSt || fromSt.name === toSt.name) {
    return {
      fare: 10,
      distance: 0,
      linesUsed: ['Western Line'],
      interchangeStation: null,
      interchangeText: 'Direct Journey',
      estimatedMins: 15,
      fromSt,
      toSt
    };
  }

  let totalDistance = 0;
  let linesUsed = [];
  let interchangeStation = null;
  let interchangeText = 'Direct Non-Stop Journey';

  if (fromSt.line === toSt.line) {
    // Single Line Direct Journey
    totalDistance = Math.abs(toSt.km - fromSt.km);
    const lineNames = { 'WR': 'Western Line', 'CR': 'Central Main Line', 'HR': 'Harbour Line' };
    linesUsed = [lineNames[fromSt.line]];
  } else {
    // Cross-Line Interchanges
    if ((fromSt.line === 'WR' && toSt.line === 'CR') || (fromSt.line === 'CR' && toSt.line === 'WR')) {
      interchangeStation = 'Dadar';
      interchangeText = 'Interchange at Dadar (Western ⇄ Central)';
      linesUsed = ['Western Line', 'Central Main Line'];
      const wrPart = Math.abs(fromSt.line === 'WR' ? fromSt.km - 10.2 : toSt.km - 10.2);
      const crPart = Math.abs(fromSt.line === 'CR' ? fromSt.km - 9.0 : toSt.km - 9.0);
      totalDistance = wrPart + crPart;
    } else if ((fromSt.line === 'CR' && toSt.line === 'HR') || (fromSt.line === 'HR' && toSt.line === 'CR')) {
      interchangeStation = 'Kurla';
      interchangeText = 'Interchange at Kurla (Central ⇄ Harbour)';
      linesUsed = ['Central Main Line', 'Harbour Line'];
      const crPart = Math.abs(fromSt.line === 'CR' ? fromSt.km - 15.5 : toSt.km - 15.5);
      const hrPart = Math.abs(fromSt.line === 'HR' ? fromSt.km - 15.0 : toSt.km - 15.0);
      totalDistance = crPart + hrPart;
    } else if ((fromSt.line === 'WR' && toSt.line === 'HR') || (fromSt.line === 'HR' && toSt.line === 'WR')) {
      interchangeStation = 'Dadar & Kurla / Wadala';
      interchangeText = 'Interchange via Dadar (WR ➔ CR) or Bandra/Wadala (HR)';
      linesUsed = ['Western Line', 'Harbour Line'];
      const wrPart = Math.abs(fromSt.line === 'WR' ? fromSt.km - 14.8 : toSt.km - 14.8);
      const hrPart = Math.abs(fromSt.line === 'HR' ? fromSt.km - 9.3 : toSt.km - 9.3);
      totalDistance = wrPart + hrPart + 6.0;
    }
  }

  // Second class fare slab
  let baseFare = 5;
  if (totalDistance > 10 && totalDistance <= 20) baseFare = 10;
  else if (totalDistance > 20 && totalDistance <= 40) baseFare = 15;
  else if (totalDistance > 40 && totalDistance <= 55) baseFare = 20;
  else if (totalDistance > 55 && totalDistance <= 75) baseFare = 25;
  else if (totalDistance > 75 && totalDistance <= 95) baseFare = 30;
  else if (totalDistance > 95) baseFare = 35;

  let classMultiplier = 1.0;
  let minFare = 5;

  if (travelClass === 'First Class') {
    classMultiplier = 5.5;
    minFare = 50;
  } else if (travelClass === 'AC Local' || travelClass === 'AC Fast') {
    classMultiplier = 6.8;
    minFare = 65;
  }

  let finalSingle = Math.max(minFare, Math.round((baseFare * classMultiplier) / 5) * 5);
  let finalFare = tripType === 'Return' ? finalSingle * 2 : finalSingle;
  let estimatedMins = Math.max(12, Math.round(totalDistance * 1.8));

  return {
    fare: finalFare,
    distance: totalDistance.toFixed(1),
    linesUsed,
    interchangeStation,
    interchangeText,
    estimatedMins,
    fromSt,
    toSt
  };
}

// 12-Hour Ticket Validity Engine
function get12HourValidity(bookingDateStr = null) {
  const start = bookingDateStr ? new Date(bookingDateStr) : new Date();
  const end = new Date(start.getTime() + 12 * 60 * 60 * 1000); // exactly +12 hours

  const formatOptions = {
    timeZone: 'Asia/Kolkata',
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  };

  return {
    issuedAt: start.toLocaleString('en-IN', formatOptions),
    validUntil: end.toLocaleString('en-IN', formatOptions),
    endTimestamp: end.getTime(),
    validityHours: 12
  };
}

// Live Countdown Timer for 12-Hour Validity
function init12HourCountdown(endTimestamp, displayElId, progressElId = null) {
  const displayEl = document.getElementById(displayElId);
  if (!displayEl) return;

  function tick() {
    const now = Date.now();
    const diff = endTimestamp - now;

    if (diff <= 0) {
      displayEl.innerHTML = '<span style="color:var(--wr-crimson); font-weight:800;">EXPIRED</span>';
      if (progressElId) {
        const prog = document.getElementById(progressElId);
        if (prog) prog.style.width = '0%';
      }
      return;
    }

    const hours = Math.floor(diff / (1000 * 60 * 60));
    const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const secs = Math.floor((diff % (1000 * 60)) / 1000);

    displayEl.textContent = `${String(hours).padStart(2, '0')}h ${String(mins).padStart(2, '0')}m ${String(secs).padStart(2, '0')}s remaining`;

    if (progressElId) {
      const prog = document.getElementById(progressElId);
      if (prog) {
        const total12hMs = 12 * 60 * 60 * 1000;
        const pct = Math.max(0, Math.min(100, (diff / total12hMs) * 100));
        prog.style.width = `${pct}%`;
      }
    }
  }

  tick();
  return setInterval(tick, 1000);
}

// Interactive Map Booking State
let mapBookingState = {
  selectedOrigin: null,
  selectedDest: null,
  activeFilter: 'ALL'
};

// Render Interactive SVG Mumbai Suburban Rail Transit Map
function renderInteractiveTransitMap(containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const width = 880;
  const height = 490;

  // Filter stations based on active filter
  let visibleStations = MUMBAI_SUBURBAN_NETWORK;
  if (mapBookingState.activeFilter === 'WR') {
    visibleStations = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === 'WR');
  } else if (mapBookingState.activeFilter === 'CR') {
    visibleStations = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === 'CR');
  } else if (mapBookingState.activeFilter === 'HR') {
    visibleStations = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === 'HR');
  }

  // Draw Line Paths
  const wrStations = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === 'WR');
  const crStations = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === 'CR');
  const hrStations = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === 'HR');

  const wrPath = wrStations.map((s, i) => `${i === 0 ? 'M' : 'L'} ${s.x} ${s.y}`).join(' ');
  const crPath = crStations.map((s, i) => `${i === 0 ? 'M' : 'L'} ${s.x} ${s.y}`).join(' ');
  const hrPath = hrStations.map((s, i) => `${i === 0 ? 'M' : 'L'} ${s.x} ${s.y}`).join(' ');

  let svgHtml = `
    <svg viewBox="0 0 ${width} ${height}" class="transit-map-svg" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <!-- Gradients -->
        <linearGradient id="wrGrad" x1="0%" y1="100%" x2="0%" y2="0%">
          <stop offset="0%" stop-color="#0284c7" />
          <stop offset="100%" stop-color="#38bdf8" />
        </linearGradient>
        <linearGradient id="crGrad" x1="0%" y1="100%" x2="0%" y2="0%">
          <stop offset="0%" stop-color="#b91c1c" />
          <stop offset="100%" stop-color="#f87171" />
        </linearGradient>
        <linearGradient id="hrGrad" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%" stop-color="#0d9488" />
          <stop offset="100%" stop-color="#2dd4bf" />
        </linearGradient>

        <!-- Filters & Glow -->
        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
          <feGaussianBlur stdDeviation="3" result="blur" />
          <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
      </defs>

      <!-- Grid Background Pattern -->
      <pattern id="railGrid" width="40" height="40" patternUnits="userSpaceOnUse">
        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#f1f5f9" stroke-width="1"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#railGrid)" rx="16"/>

      <!-- Coastline & Mumbai Harbour Silhouette -->
      <path d="M 30 490 Q 70 300 90 100 L 100 0 L 0 0 L 0 490 Z" fill="rgba(224, 242, 254, 0.4)"/>
      <path d="M 520 160 Q 560 170 880 170 L 880 490 L 520 490 Z" fill="rgba(240, 253, 250, 0.4)"/>
      <text x="35" y="475" fill="#94a3b8" font-size="12" font-weight="700" letter-spacing="2">ARABIAN SEA</text>
      <text x="640" y="475" fill="#94a3b8" font-size="12" font-weight="700" letter-spacing="2">THANE CREEK / NAVI MUMBAI</text>

      <!-- Inter-Line Transfer Connectors (Dadar, Kurla, Prabhadevi) -->
      <!-- Dadar Transfer -->
      <line x1="120" y1="260" x2="260" y2="260" stroke="#f59e0b" stroke-width="6" stroke-dasharray="3,3" opacity="0.8"/>
      <!-- Kurla Transfer -->
      <line x1="260" y1="175" x2="275" y2="175" stroke="#f59e0b" stroke-width="6" stroke-dasharray="2,2" opacity="0.8"/>
      <!-- Wadala - Bandra branch connector -->
      <path d="M 360 260 Q 240 220 120 185" fill="none" stroke="#0d9488" stroke-width="4" stroke-dasharray="4,4" opacity="0.6"/>

      <!-- Main Railway Tracks -->
      <!-- Western Line Track -->
      <path d="${wrPath}" fill="none" stroke="url(#wrGrad)" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" opacity="${(mapBookingState.activeFilter === 'ALL' || mapBookingState.activeFilter === 'WR') ? '1' : '0.2'}"/>
      <!-- Central Line Track -->
      <path d="${crPath}" fill="none" stroke="url(#crGrad)" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" opacity="${(mapBookingState.activeFilter === 'ALL' || mapBookingState.activeFilter === 'CR') ? '1' : '0.2'}"/>
      <!-- Harbour Line Track -->
      <path d="${hrPath}" fill="none" stroke="url(#hrGrad)" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" opacity="${(mapBookingState.activeFilter === 'ALL' || mapBookingState.activeFilter === 'HR') ? '1' : '0.2'}"/>

      <!-- Active Journey Marching Line if both Origin and Dest selected -->
      ${renderActiveTrackHighlight()}

      <!-- Station Nodes -->
  `;

  // Draw Station Dots & Labels
  MUMBAI_SUBURBAN_NETWORK.forEach(st => {
    const isOrigin = mapBookingState.selectedOrigin && mapBookingState.selectedOrigin.name === st.name;
    const isDest = mapBookingState.selectedDest && mapBookingState.selectedDest.name === st.name;
    const isInterchange = st.interchange !== null;

    let dotColor = '#0284c7';
    if (st.line === 'CR') dotColor = '#dc2626';
    if (st.line === 'HR') dotColor = '#0d9488';

    let r = isInterchange ? 6.5 : 4.5;
    let strokeColor = '#ffffff';
    let strokeWidth = 2;

    if (isOrigin) {
      dotColor = '#10b981';
      r = 9;
      strokeColor = '#ffffff';
      strokeWidth = 3;
    } else if (isDest) {
      dotColor = '#ef4444';
      r = 9;
      strokeColor = '#ffffff';
      strokeWidth = 3;
    }

    const opacity = (mapBookingState.activeFilter === 'ALL' || mapBookingState.activeFilter === st.line) ? '1' : '0.25';

    // Click handler for node
    svgHtml += `
      <g class="map-station-node" onclick="handleMapStationClick('${st.name}')" style="cursor: pointer; opacity: ${opacity};">
        ${isOrigin ? `<circle cx="${st.x}" cy="${st.y}" r="16" fill="rgba(16,185,129,0.3)" class="pulse-beacon"/>` : ''}
        ${isDest ? `<circle cx="${st.x}" cy="${st.y}" r="16" fill="rgba(239,68,68,0.3)" class="pulse-beacon"/>` : ''}
        
        <circle cx="${st.x}" cy="${st.y}" r="${r}" fill="${dotColor}" stroke="${strokeColor}" stroke-width="${strokeWidth}" />
        
        <!-- Key Interchange / Major Station Labels -->
        ${(isInterchange || isOrigin || isDest || ['Churchgate', 'Borivali', 'Virar', 'CSMT (Central)', 'Kalyan Junction', 'Thane', 'Panvel', 'Vashi', 'Andheri'].includes(st.name)) ? `
          <text x="${st.x + (st.line === 'WR' ? -12 : (st.line === 'CR' ? 12 : 10))}" y="${st.y + 4}" 
                fill="${isOrigin ? '#059669' : (isDest ? '#dc2626' : (isInterchange ? '#b45309' : '#1e293b'))}" 
                font-size="${(isOrigin || isDest || isInterchange) ? '11' : '9.5'}" 
                font-weight="${(isOrigin || isDest || isInterchange) ? '800' : '600'}" 
                text-anchor="${st.line === 'WR' ? 'end' : 'start'}"
                font-family="system-ui, -apple-system, sans-serif">
            ${st.name} ${isInterchange ? '⇄' : ''}
          </text>
        ` : ''}
      </g>
    `;
  });

  // Map Legend
  svgHtml += `
      <!-- Transit Legend -->
      <g transform="translate(620, 20)">
        <rect width="240" height="120" rx="10" fill="rgba(255,255,255,0.95)" stroke="#cbd5e1" stroke-width="1" />
        <text x="15" y="22" font-size="11" font-weight="800" fill="#0f172a">MUMBAI SUBURBAN NETWORK</text>
        
        <circle cx="25" cy="42" r="5" fill="#0284c7" />
        <text x="38" y="46" font-size="10" font-weight="600" fill="#334155">Western Line (CCG - VR - DRD)</text>
        
        <circle cx="25" cy="62" r="5" fill="#dc2626" />
        <text x="38" y="66" font-size="10" font-weight="600" fill="#334155">Central Line (CSMT - KYN - KAS)</text>
        
        <circle cx="25" cy="82" r="5" fill="#0d9488" />
        <text x="38" y="86" font-size="10" font-weight="600" fill="#334155">Harbour Line (CSMT - PNVL)</text>
        
        <circle cx="25" cy="102" r="5" fill="#f59e0b" stroke="#ffffff" stroke-width="1.5" />
        <text x="38" y="106" font-size="10" font-weight="700" fill="#b45309">⇄ Major Transfer Interchange</text>
      </g>
    </svg>
  `;

  container.innerHTML = svgHtml;
}

// Active track highlight renderer
function renderActiveTrackHighlight() {
  if (!mapBookingState.selectedOrigin || !mapBookingState.selectedDest) return '';
  const o = mapBookingState.selectedOrigin;
  const d = mapBookingState.selectedDest;

  if (o.line === d.line) {
    const list = MUMBAI_SUBURBAN_NETWORK.filter(s => s.line === o.line);
    const i1 = list.findIndex(s => s.name === o.name);
    const i2 = list.findIndex(s => s.name === d.name);
    const slice = list.slice(Math.min(i1, i2), Math.max(i1, i2) + 1);
    const pathD = slice.map((s, idx) => `${idx === 0 ? 'M' : 'L'} ${s.x} ${s.y}`).join(' ');
    return `<path d="${pathD}" fill="none" stroke="#f59e0b" stroke-width="6" stroke-linecap="round" stroke-dasharray="6,4" class="marching-track" filter="url(#glow)"/>`;
  }
  return '';
}

// Map Click Handler (Select Origin then Destination)
function handleMapStationClick(stationName) {
  const st = findStation(stationName);
  if (!st) return;

  if (!mapBookingState.selectedOrigin || (mapBookingState.selectedOrigin && mapBookingState.selectedDest)) {
    // New selection: Set origin
    mapBookingState.selectedOrigin = st;
    mapBookingState.selectedDest = null;
  } else {
    // Set destination
    if (mapBookingState.selectedOrigin.name === st.name) {
      alert("Please select a different destination station.");
      return;
    }
    mapBookingState.selectedDest = st;
  }

  // Re-render map to show beacons and highlights
  renderInteractiveTransitMap('transitMapContainer');
  renderInteractiveTransitMap('standaloneMapModalContainer');

  // Sync with booking inputs
  syncMapWithBookingForm();
}

// Filter map lines
function filterMapLine(lineCode) {
  mapBookingState.activeFilter = lineCode;
  document.querySelectorAll('.map-filter-btn').forEach(b => {
    b.classList.toggle('active', b.getAttribute('data-line') === lineCode);
  });
  renderInteractiveTransitMap('transitMapContainer');
  renderInteractiveTransitMap('standaloneMapModalContainer');
}

// Sync map selection with HTML form inputs
function syncMapWithBookingForm() {
  const o = mapBookingState.selectedOrigin;
  const d = mapBookingState.selectedDest;

  const fromInputs = [document.getElementById('stan1'), document.getElementById('homeFrom')];
  const toInputs = [document.getElementById('To'), document.getElementById('homeTo')];

  if (o) {
    fromInputs.forEach(inp => { if (inp) inp.value = o.name; });
  }
  if (d) {
    toInputs.forEach(inp => { if (inp) inp.value = d.name; });
  }

  // Update live preview & HUD
  updateLiveFarePreview();
  updateMapRouteHUD();
}

// Update Map Floating Route HUD
function updateMapRouteHUD() {
  const hud = document.getElementById('mapRouteHUD');
  if (!hud) return;

  const o = mapBookingState.selectedOrigin;
  const d = mapBookingState.selectedDest;

  if (!o && !d) {
    hud.style.display = 'none';
    return;
  }

  hud.style.display = 'block';

  if (o && !d) {
    hud.innerHTML = `
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
          <span class="badge badge-success"><i class="fas fa-location-dot"></i> Step 1: Origin Set</span>
          <div style="font-size:1.1rem; font-weight:800; color:var(--wr-navy-900); margin-top:0.25rem;">${o.name} (${o.line} Line)</div>
          <div style="font-size:0.8rem; color:#64748b;">Now click any destination station on the map to calculate route & 12-hour ticket.</div>
        </div>
        <button type="button" class="btn-secondary" style="padding:0.4rem 0.8rem; font-size:0.8rem;" onclick="clearMapSelection()">Clear</button>
      </div>
    `;
    return;
  }

  if (o && d) {
    const classEl = document.getElementById('journeyClass') || document.getElementById('homeClass');
    const travelClass = classEl ? classEl.value : 'Second Class';
    const res = calculateMultiLineFare(o.name, d.name, travelClass, 'Single');

    hud.innerHTML = `
      <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:1rem;">
        <div>
          <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
            <span class="badge badge-wr">${res.linesUsed.join(' + ')}</span>
            <span class="badge badge-success"><i class="fas fa-clock"></i> 12-Hour Validity</span>
            ${res.interchangeStation ? `<span class="badge badge-warning"><i class="fas fa-shuffle"></i> ${res.interchangeStation}</span>` : ''}
          </div>
          <div style="font-size:1.25rem; font-weight:800; color:var(--wr-navy-900);">
            ${o.name} ➔ ${d.name}
          </div>
          <div style="font-size:0.8rem; color:#64748b; margin-top:0.2rem;">
            Distance: <strong>${res.distance} km</strong> • Approx. Time: <strong>${res.estimatedMins} mins</strong> • <em>${res.interchangeText}</em>
          </div>
        </div>

        <div style="display:flex; align-items:center; gap:1.25rem;">
          <div style="text-align:right;">
            <div style="font-size:0.72rem; text-transform:uppercase; color:#64748b; font-weight:700;">Suburban Fare</div>
            <div style="font-size:1.8rem; font-weight:800; color:var(--wr-navy-900); font-family:var(--font-mono);">₹${res.fare}</div>
          </div>
          <button type="button" class="btn-primary" style="width:auto; padding:0.75rem 1.5rem;" onclick="applyMapBookingAndProceed()">
            <i class="fas fa-check-circle"></i> Confirm & Book This Route
          </button>
        </div>
      </div>
    `;
  }
}

function clearMapSelection() {
  mapBookingState.selectedOrigin = null;
  mapBookingState.selectedDest = null;
  renderInteractiveTransitMap('transitMapContainer');
  renderInteractiveTransitMap('standaloneMapModalContainer');
  updateMapRouteHUD();
}

function applyMapBookingAndProceed() {
  const form = document.getElementById('journeySearchForm') || document.getElementById('standaloneBookingForm');
  if (form) {
    if (typeof form.onsubmit === 'function') {
      form.onsubmit(new Event('submit'));
    } else {
      form.submit();
    }
  }
}

// Live Clock Initializer (Indian Standard Time)
function initLiveClock() {
  const clockEl = document.getElementById('liveClock');
  if (!clockEl) return;

  function update() {
    const now = new Date();
    const options = {
      timeZone: 'Asia/Kolkata',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: true
    };
    clockEl.textContent = now.toLocaleTimeString('en-IN', options);
  }
  update();
  setInterval(update, 1000);
}

// Station Swap Helper
function swapStations() {
  const fromEl = document.getElementById('stan1') || document.getElementById('homeFrom');
  const toEl = document.getElementById('To') || document.getElementById('homeTo');
  if (fromEl && toEl) {
    const temp = fromEl.value;
    fromEl.value = toEl.value;
    toEl.value = temp;

    const tempSt = mapBookingState.selectedOrigin;
    mapBookingState.selectedOrigin = mapBookingState.selectedDest;
    mapBookingState.selectedDest = tempSt;

    renderInteractiveTransitMap('transitMapContainer');
    renderInteractiveTransitMap('standaloneMapModalContainer');
    updateLiveFarePreview();
    updateMapRouteHUD();
  }
}

// Update Live Fare Preview in Home UI
function updateLiveFarePreview() {
  const fromEl = document.getElementById('stan1') || document.getElementById('homeFrom');
  const toEl = document.getElementById('To') || document.getElementById('homeTo');
  const classEl = document.getElementById('journeyClass') || document.getElementById('homeClass');
  const typeEl = document.querySelector('input[name="tripType"]:checked') || document.getElementById('btnTypeReturn')?.classList.contains('active') ? { value: 'Return' } : { value: 'Single' };

  const fareNumEl = document.getElementById('fareAmount') || document.getElementById('liveFareDisplay');
  const distEl = document.getElementById('journeyDistance') || document.getElementById('liveDistance');
  const routeSummaryEl = document.getElementById('routeSummary') || document.getElementById('liveRouteSummary');

  if (!fromEl || !toEl) return;

  const travelClass = classEl ? classEl.value : 'Second Class';
  const tripType = typeEl ? typeEl.value : 'Single';

  const res = calculateMultiLineFare(fromEl.value, toEl.value, travelClass, tripType);

  if (fareNumEl) fareNumEl.textContent = res.fare;
  if (distEl) distEl.textContent = res.distance > 0 ? `${res.distance} km (~${res.estimatedMins} mins)` : 'Select Stations';
  if (routeSummaryEl) {
    if (fromEl.value && toEl.value && fromEl.value !== toEl.value) {
      routeSummaryEl.textContent = `${fromEl.value} ➔ ${toEl.value} (${travelClass}) • ${res.linesUsed.join(', ')}`;
    } else {
      routeSummaryEl.textContent = 'Please choose pickup & drop stations';
    }
  }
}

// Mobile Navigation Drawer Toggle
function toggleNavDrawer() {
  const drawer = document.getElementById('mobileDrawer');
  const overlay = document.getElementById('drawerOverlay');
  if (drawer && overlay) {
    drawer.classList.toggle('open');
    overlay.classList.toggle('open');
  }
}

function closeNavDrawer() {
  const drawer = document.getElementById('mobileDrawer');
  const overlay = document.getElementById('drawerOverlay');
  if (drawer && overlay) {
    drawer.classList.remove('open');
    overlay.classList.remove('open');
  }
}

// Fill Demo User / Admin Credentials Helper
function fillDemoCredentials(username, password) {
  const uInput = document.querySelector('input[name="uname"]');
  const pInput = document.querySelector('input[name="password"]');
  if (uInput && pInput) {
    uInput.value = username;
    pInput.value = password;
  }
}

// Interactive QR Code Generator (SVG-based for sharp rendering)
function generateTicketQR(containerId, qrText) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const svg = `
    <svg width="115" height="115" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="110" height="110" fill="#FFFFFF"/>
      <rect x="8" y="8" width="30" height="30" rx="4" fill="#0B2545"/>
      <rect x="14" y="14" width="18" height="18" fill="#FFFFFF"/>
      <rect x="18" y="18" width="10" height="10" fill="#0B2545"/>
      <rect x="72" y="8" width="30" height="30" rx="4" fill="#0B2545"/>
      <rect x="78" y="14" width="18" height="18" fill="#FFFFFF"/>
      <rect x="82" y="18" width="10" height="10" fill="#0B2545"/>
      <rect x="8" y="72" width="30" height="30" rx="4" fill="#0B2545"/>
      <rect x="14" y="78" width="18" height="18" fill="#FFFFFF"/>
      <rect x="18" y="82" width="10" height="10" fill="#0B2545"/>
      <rect x="44" y="12" width="6" height="6" fill="#0B2545"/>
      <rect x="54" y="12" width="10" height="6" fill="#0B2545"/>
      <rect x="44" y="24" width="12" height="6" fill="#0B2545"/>
      <rect x="60" y="24" width="6" height="6" fill="#0B2545"/>
      <rect x="12" y="44" width="6" height="12" fill="#0B2545"/>
      <rect x="24" y="44" width="12" height="6" fill="#0B2545"/>
      <circle cx="55" cy="55" r="14" fill="#D32F2F"/>
      <circle cx="55" cy="55" r="11" fill="#FFFFFF"/>
      <path d="M51 51H59V59H51Z" fill="#0B2545"/>
      <rect x="44" y="72" width="8" height="8" fill="#0B2545"/>
      <rect x="56" y="72" width="8" height="8" fill="#0B2545"/>
      <rect x="72" y="52" width="12" height="6" fill="#0B2545"/>
      <rect x="88" y="52" width="14" height="6" fill="#0B2545"/>
      <rect x="72" y="66" width="6" height="12" fill="#0B2545"/>
      <rect x="72" y="86" width="16" height="8" fill="#0B2545"/>
    </svg>
  `;
  container.innerHTML = svg;
}

// On DOM Loaded Handlers
document.addEventListener('DOMContentLoaded', () => {
  initLiveClock();

  // Attach event listeners for fare calculation
  const stan1 = document.getElementById('stan1') || document.getElementById('homeFrom');
  const stan2 = document.getElementById('To') || document.getElementById('homeTo');
  const classEl = document.getElementById('journeyClass') || document.getElementById('homeClass');

  if (stan1) stan1.addEventListener('input', () => {
    mapBookingState.selectedOrigin = findStation(stan1.value);
    renderInteractiveTransitMap('transitMapContainer');
    updateLiveFarePreview();
  });
  if (stan2) stan2.addEventListener('input', () => {
    mapBookingState.selectedDest = findStation(stan2.value);
    renderInteractiveTransitMap('transitMapContainer');
    updateLiveFarePreview();
  });
  if (classEl) classEl.addEventListener('change', updateLiveFarePreview);

  document.querySelectorAll('input[name="tripType"]').forEach(r => {
    r.addEventListener('change', updateLiveFarePreview);
  });

  // Calculate initial preview
  updateLiveFarePreview();

  // Initialize transit map if container present
  if (document.getElementById('transitMapContainer')) {
    mapBookingState.selectedOrigin = findStation('Churchgate');
    mapBookingState.selectedDest = findStation('Borivali');
    renderInteractiveTransitMap('transitMapContainer');
    updateMapRouteHUD();
  }

  // Generate QR if container present
  if (document.getElementById('ticketQRContainer')) {
    generateTicketQR('ticketQRContainer', 'UTS-VERIFIED-12H-TICKET');
  }

  // Initialize 12-hour ticket countdown if element present
  if (document.getElementById('ticketCountdownTimer')) {
    const valObj = get12HourValidity();
    init12HourCountdown(valObj.endTimestamp, 'ticketCountdownTimer', 'validityProgressBar');
  }
});
