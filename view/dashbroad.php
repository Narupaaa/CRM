<style>
  /* ถ้ายังไม่มีคลาสนี้ ให้เพิ่มเพื่อซ่อนหน้าอื่นๆ */
  .hidden {
    display: none !important;
  }

  .dashboard-cards-container {
    display: grid;
    grid-template-columns: repeat(4, minmax(200px, 1fr));
    gap: 16px;
  }

  .dashboard-card {
    display: flex;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    background: #d6d9dcff;
    color: #17181aff;
    box-shadow: 0 4px 16px rgba(199, 195, 195, 0.61);
    align-items: center;
  }

  .dashboard-card .card-content h4 {
    margin: 0 0 4px 0;
    font-size: 1rem;
    font-weight: 600;
  }

  .dashboard-card .card-value {
    font-size: 1.25rem;
    margin: 0;
  }

  .dashboard-section {
    margin-top: 24px;
  }

  .chart-half {
    width: 100%;
  }

  .dashboard-chart-container {
    background: #d6d9dcff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 1);
  }

  .dashboard-list-container {
    background: #d6d9dcff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 1);
  }

  .list-half {
    width: 100%;
  }

  .task-list,
  .activity-list {
    margin: 0;
    padding-left: 16px;
  }

  .task-due {
    color: #9ca3af;
    margin-left: 8px;
  }

  .task-priority-high {
    color: #fca5a5;
    font-weight: 700;
    margin-left: 8px;
  }

  .activity-user {
    font-weight: 600;
  }

  .activity-time {
    color: #9ca3af;
    margin-left: 8px;
  }

  .quick-actions-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
  }

  @media (min-width: 992px) {
    .chart-half {
      width: 49%;
      display: inline-block;
      vertical-align: top;
    }

    .list-half {
      width: 49%;
      display: inline-block;
      vertical-align: top;
    }
  }
</style>

<!-- Dashboard Content -->
<div id="dashboard-page" class="page-content">
  <!-- Quick Stats / Summary Cards -->
  <div class="dashboard-cards-container">
    <div class="dashboard-card card-sales">
      <div class="card-icon"><i class="fas fa-chart-line fa-3x"></i></div>
      <div class="card-content">
        <h4>ยอดขายคาดการณ์ (เดือนนี้)</h4>
        <p class="card-value" id="db-sales-forecast">฿1,250,000</p>
        <small>จาก QTN ที่มีโอกาสสูง</small>
      </div>
    </div>
    <div class="dashboard-card card-qtn">
      <div class="card-icon"><i class="fas fa-file-alt fa-3x"></i></div>
      <div class="card-content">
        <h4>ใบเสนอราคารออนุมัติ</h4>
        <p class="card-value" id="db-pending-qtn">5</p>
        <a href="#" class="card-link" data-nav="quotations">ดูรายการ »</a>
      </div>
    </div>
    <div class="dashboard-card card-po">
      <div class="card-icon"><i class="fas fa-file-invoice fa-3x"></i></div>
      <div class="card-content">
        <h4>PO ลูกค้ารอสร้าง IO</h4>
        <p class="card-value" id="db-pending-po">3</p>
        <a href="#" class="card-link" data-nav="customer-pos">ดูรายการ »</a>
      </div>
    </div>
    <div class="dashboard-card card-stock">
      <div class="card-icon"><i class="fas fa-boxes fa-3x"></i></div>
      <div class="card-content">
        <h4>สินค้าใกล้หมดสต็อก</h4>
        <p class="card-value" id="db-low-stock">2</p>
        <a href="#" class="card-link" data-nav="inventory">ดูรายการ »</a>
      </div>
    </div>
  </div>

  <!-- Charts Section (Placeholders) -->
  <div class="dashboard-section">
    <div class="dashboard-chart-container chart-half">
      <h3>ภาพรวมยอดขายรายเดือน (6 เดือนล่าสุด)</h3>
      <div class="chart-placeholder" id="sales-monthly-chart">
        (กราฟแท่งแสดงยอดขายรายเดือน)
        <!-- <canvas id="salesMonthlyChartCanvas"></canvas> -->
      </div>
    </div>
    <div class="dashboard-chart-container chart-half">
      <h3>สถานะ Sales Pipeline</h3>
      <div class="chart-placeholder" id="pipeline-status-chart">
        (กราฟวงกลมแสดง % QTN ตามสถานะ)
        <!-- <canvas id="pipelineStatusChartCanvas"></canvas> -->
      </div>
    </div>
  </div>

  <!-- Recent Activity / Task List Section -->
  <div class="dashboard-section">
    <div class="dashboard-list-container list-half">
      <h3><i class="fas fa-tasks"></i> งานที่ต้องดำเนินการ (My Tasks)</h3>
      <ul class="task-list" id="db-my-tasks">
        <li><a href="#">อนุมัติ QTN00125 สำหรับ บ. DEF</a> <span class="task-due">Due: Today</span></li>
        <li><a href="#">ติดตามผล QTN00120 กับ บ. GHI</a> <span class="task-due">Due: Tomorrow</span></li>
        <li><a href="#">สร้าง IO จาก CUST-PO-800</a> <span class="task-due">Due: Today</span></li>
        <li><a href="#">สั่งซื้อ Chemical X (ใกล้หมด)</a> <span class="task-priority-high">ด่วน!</span></li>
      </ul>
      <a href="#" class="view-all-link">ดูงานทั้งหมด »</a>
    </div>
    <div class="dashboard-list-container list-half">
      <h3><i class="far fa-clock"></i> กิจกรรมล่าสุดในระบบ</h3>
      <ul class="activity-list" id="db-recent-activity">
        <li><span class="activity-user">Sales01</span> สร้าง QTN00128 ให้ บ. JKL <span class="activity-time">5
            นาทีที่แล้ว</span></li>
        <li><span class="activity-user">Admin01</span> อนุมัติผู้ใช้งานใหม่: user_test <span class="activity-time">30
            นาทีที่แล้ว</span></li>
        <li><span class="activity-user">Purchasing01</span> สร้าง SUP-PO-090 สั่งของ <span class="activity-time">1
            ชั่วโมงที่แล้ว</span></li>
        <li><span class="activity-user">Account01</span> บันทึกการรับชำระ INV00777 <span class="activity-time">2
            ชั่วโมงที่แล้ว</span></li>
      </ul>
      <a href="#" class="view-all-link">ดูกิจกรรมทั้งหมด »</a>
    </div>
  </div>

  <!-- Quick Links/Actions Section -->
  <div class="dashboard-section">
    <h3><i class="fas fa-rocket"></i> ทางลัด (Quick Actions)</h3>
    <div class="quick-actions-container">
      <button class="btn btn-primary quick-action-btn" data-nav="quotations" data-action="create"><i
          class="fas fa-plus-circle"></i> สร้างใบเสนอราคา</button>
      <button class="btn btn-primary quick-action-btn" data-nav="customer-pos" data-action="create"><i
          class="fas fa-file-import"></i> บันทึก PO ลูกค้า</button>
      <button class="btn btn-primary quick-action-btn" data-nav="inventory" data-action="receive"><i
          class="fas fa-truck-loading"></i> รับสินค้าเข้าสต็อก</button>
      <button class="btn btn-secondary quick-action-btn" data-nav="reports" data-report="sales_forecast"><i
          class="fas fa-eye"></i> ดู Sale Forecast</button>
    </div>
  </div>
</div>

<!-- Placeholder for other pages -->
<div id="reports-page" class="page-content hidden">
  <h2>Reports Content</h2>
</div>
<!-- ... more placeholder divs ... -->




<script>
  (function () {
    // ---------- SPA Navigation ----------
    function navigateTo(pageKey) {
      // pageKey มาจาก data-nav เช่น 'quotations', 'customer-pos', 'inventory', 'reports'
      // โครงสร้างหน้า: มี .page-content แต่ละอัน เช่น #dashboard-page, #reports-page ...
      // ถ้ายังไม่มีเพจเป้าหมาย ให้คงอยู่หน้าเดิม
      const pages = document.querySelectorAll('.page-content');
      pages.forEach(p => p.classList.add('hidden'));
      // mapping key -> element id (ปรับตามหน้าในระบบจริง)
      const map = {
        'dashboard': 'dashboard-page',
        'reports': 'reports-page',
        'quotations': 'quotations-page',
        'customer-pos': 'customer-pos-page',
        'inventory': 'inventory-page'
      };
      const elId = map[pageKey] || 'dashboard-page';
      const target = document.getElementById(elId);
      if (target) target.classList.remove('hidden');
    }

    // delegate ให้ลิงก์/ปุ่มที่มี data-nav ทำงาน
    document.addEventListener('click', function (e) {
      const link = e.target.closest('[data-nav]');
      if (!link) return;
      e.preventDefault();
      const nav = link.getAttribute('data-nav');
      navigateTo(nav);

      // ส่ง action/report ถ้าต้องการ (เช่น เปิดฟอร์มสร้างใบเสนอราคา)
      const action = link.getAttribute('data-action');
      const report = link.getAttribute('data-report');
      if (action) { console.log('Action:', nav, action); /* เปิด modal / ฟอร์มตามจริงได้ที่นี่ */ }
      if (report) { console.log('Report:', report); /* โหลดรายงานตามจริงได้ที่นี่ */ }
    });

    // ---------- Fetch Dashboard Data ----------
    async function fetchDashboardData() {
      // พยายามเรียก API จริง (controller.php?case=getDashboard)
      try {
        const res = await fetch('controller.php?case=getDashboard', { cache: 'no-store' });
        if (res.ok) {
          const data = await res.json();
          if (data && typeof data === 'object') return data;
        }
      } catch (err) {
        console.warn('API not ready, using mock data...', err);
      }
      // fallback mock data
      const today = new Date();
      const monthNames = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
      const labels = [];
      const sales = [];
      for (let i = 5; i >= 0; i--) {
        const d = new Date(today.getFullYear(), today.getMonth() - i, 1);
        labels.push(monthNames[d.getMonth()] + ' ' + (d.getFullYear() + 543)); // พ.ศ.
        sales.push(Math.round(800000 + Math.random() * 700000));
      }
      return {
        kpis: {
          salesForecast: 1250000,
          pendingQTN: 5,
          pendingPO: 3,
          lowStock: 2
        },
        salesMonthly: {
          labels,
          values: sales
        },
        pipeline: {
          labels: ['Prospect', 'Qualified', 'Proposal', 'Negotiation', 'Won', 'Lost'],
          values: [15, 22, 28, 18, 10, 7]
        },
        tasks: [
          { text: 'อนุมัติ QTN00125 สำหรับ บ. DEF', due: 'Today', priority: null, href: '#' },
          { text: 'ติดตามผล QTN00120 กับ บ. GHI', due: 'Tomorrow', priority: null, href: '#' },
          { text: 'สร้าง IO จาก CUST-PO-800', due: 'Today', priority: null, href: '#' },
          { text: 'สั่งซื้อ Chemical X (ใกล้หมด)', due: null, priority: 'high', href: '#' },
        ],
        activities: [
          { user: 'Sales01', text: 'สร้าง QTN00128 ให้ บ. JKL', time: '5 นาทีที่แล้ว' },
          { user: 'Admin01', text: 'อนุมัติผู้ใช้งานใหม่: user_test', time: '30 นาทีที่แล้ว' },
          { user: 'Purchasing01', text: 'สร้าง SUP-PO-090 สั่งของ', time: '1 ชั่วโมงที่แล้ว' },
          { user: 'Account01', text: 'บันทึกการรับชำระ INV00777', time: '2 ชั่วโมงที่แล้ว' },
        ]
      };
    }

    // ---------- Update UI ----------
    function formatTHB(n) {
      try {
        return n.toLocaleString('th-TH', { style: 'currency', currency: 'THB', maximumFractionDigits: 0 });
      } catch { return '฿' + (n || 0).toLocaleString(); }
    }

    function updateKPIs(kpis) {
      document.getElementById('db-sales-forecast').textContent = formatTHB(kpis.salesForecast || 0);
      document.getElementById('db-pending-qtn').textContent = kpis.pendingQTN ?? '-';
      document.getElementById('db-pending-po').textContent = kpis.pendingPO ?? '-';
      document.getElementById('db-low-stock').textContent = kpis.lowStock ?? '-';
    }

    function updateTasks(tasks) {
      const ul = document.getElementById('db-my-tasks');
      ul.innerHTML = '';
      (tasks || []).forEach(t => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = t.href || '#';
        a.textContent = t.text;
        li.appendChild(a);
        if (t.due) {
          const sp = document.createElement('span');
          sp.className = 'task-due';
          sp.textContent = 'Due: ' + t.due;
          li.appendChild(document.createTextNode(' '));
          li.appendChild(sp);
        }
        if (t.priority === 'high') {
          const sp2 = document.createElement('span');
          sp2.className = 'task-priority-high';
          sp2.textContent = 'ด่วน!';
          li.appendChild(document.createTextNode(' '));
          li.appendChild(sp2);
        }
        ul.appendChild(li);
      });
    }

    function updateActivities(activities) {
      const ul = document.getElementById('db-recent-activity');
      ul.innerHTML = '';
      (activities || []).forEach(ac => {
        const li = document.createElement('li');
        const u = document.createElement('span');
        u.className = 'activity-user';
        u.textContent = ac.user;
        li.appendChild(u);
        li.appendChild(document.createTextNode(' ' + (ac.text || '')));
        const t = document.createElement('span');
        t.className = 'activity-time';
        t.textContent = ac.time || '';
        li.appendChild(document.createTextNode(' '));
        li.appendChild(t);
        ul.appendChild(li);
      });
    }

    // ---------- Charts ----------
    let salesChart, pipelineChart;

    function ensureCanvas(containerId, canvasId) {
      const container = document.getElementById(containerId);
      if (!container) return null;
      let canvas = container.querySelector('canvas');
      if (!canvas) {
        canvas = document.createElement('canvas');
        canvas.id = canvasId;
        canvas.height = 160;
        container.innerHTML = '';
        container.appendChild(canvas);
      }
      return canvas;
    }

    function renderSalesMonthly(labels, values) {
      const canvas = ensureCanvas('sales-monthly-chart', 'salesMonthlyChartCanvas');
      if (!canvas) return;
      if (salesChart) { salesChart.destroy(); }
      salesChart = new Chart(canvas, {
        type: 'bar',
        data: {
          labels,
          datasets: [{
            label: 'ยอดขาย (บาท)',
            data: values
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: { ticks: { callback: (v) => v.toLocaleString() } }
          },
          plugins: {
            tooltip: {
              callbacks: {
                label: ctx => ' ' + ctx.raw.toLocaleString() + ' บาท'
              }
            },
            legend: { display: true }
          }
        }
      });
    }

    function renderPipeline(labels, values) {
      const canvas = ensureCanvas('pipeline-status-chart', 'pipelineStatusChartCanvas');
      if (!canvas) return;
      if (pipelineChart) { pipelineChart.destroy(); }
      pipelineChart = new Chart(canvas, {
        type: 'doughnut',
        data: {
          labels,
          datasets: [{ data: values }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'bottom' },
            tooltip: {
              callbacks: {
                label: ctx => {
                  const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                  const val = ctx.raw;
                  const pct = total ? (val * 100 / total).toFixed(1) : 0;
                  return ` ${ctx.label}: ${val} (${pct}%)`;
                }
              }
            }
          },
          cutout: '60%'
        }
      });
    }

    // ---------- Init ----------
    async function initDashboard() {
      const data = await fetchDashboardData();
      updateKPIs(data.kpis || {});
      updateTasks(data.tasks || []);
      updateActivities(data.activities || []);
      renderSalesMonthly((data.salesMonthly || {}).labels || [], (data.salesMonthly || {}).values || []);
      renderPipeline((data.pipeline || {}).labels || [], (data.pipeline || {}).values || []);
    }

    // load once
    document.addEventListener('DOMContentLoaded', initDashboard);

    // optional: refresh ทุก 5 นาที
    // setInterval(initDashboard, 5 * 60 * 1000);
  })();
</script>