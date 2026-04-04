<?php

$stats = [
    ['label' => 'Total Pengguna', 'value' => '1,250', 'color' => '#4e73df', 'icon' => '👤'],
    ['label' => 'Pendapatan', 'value' => 'Rp 5.400.000', 'color' => '#1cc88a', 'icon' => '💰'],
    ['label' => 'Pesanan Baru', 'value' => '45', 'color' => '#36b9cc', 'icon' => '📦'],
    ['label' => 'Pending', 'value' => '12', 'color' => '#f6c23e', 'icon' => '⏳'],
];

$recent_activities = [
    ['user' => 'Adrian Alviano', 'status' => 'Selesai', 'date' => '2024-05-20'],
    ['user' => 'Daniel Ferdian', 'status' => 'Proses', 'date' => '2024-05-21'],
    ['user' => 'Diva Valencia', 'status' => 'Selesai', 'date' => '2024-05-21'],
    ['user' => 'Fauzil Azhim', 'status' => 'Batal', 'date' => '2024-05-22'],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mini Dashboard - Team Edition</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fc; margin: 0; display: flex; color: #333; }
        
        /* Sidebar */
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar h2 { font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; letter-spacing: 1px; }
        .sidebar nav a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px 0; transition: 0.3s; }
        .sidebar nav a:hover { color: white; padding-left: 10px; }

        /* Main Content */
        .main-content { flex: 1; padding: 40px; }
        .header { margin-bottom: 30px; }
        .header h1 { margin: 0; color: #2c3e50; }

        /* Cards Statistik */
        .card-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-left: 6px solid; }
        .card h3 { margin: 0; font-size: 0.75rem; text-transform: uppercase; color: #858796; letter-spacing: 0.5px; }
        .card .value { font-size: 1.4rem; font-weight: 700; margin-top: 8px; }

        /* Table Style */
        .table-container { margin-top: 40px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .table-container h3 { margin-top: 0; margin-bottom: 20px; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; background: #f8f9fc; color: #4e73df; font-size: 0.9rem; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        
        /* Badge Status */
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; color: white; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>PROJECT ADMIN</h2>
    <nav>
        <a href="#">📊 Dashboard</a>
        <a href="#">👥 Team Members</a>
        <a href="#">📑 Reports</a>
        <a href="#">⚙️ Settings</a>
    </nav>
</div>

<div class="main-content">
    <div class="header">
        <h1>Overview Dashboard</h1>
        <p>Data aktivitas terbaru dari tim Anda.</p>
    </div>

    <div class="card-container">
        <?php foreach ($stats as $item): ?>
            <div class="card" style="border-left-color: <?= $item['color']; ?>">
                <h3><?= $item['label']; ?></h3>
                <div class="value" style="color: <?= $item['color']; ?>">
                    <?= $item['icon'] . ' ' . $item['value']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="table-container">
        <h3>Daftar Anggota & Status</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Status Tugas</th>
                    <th>Tanggal Update</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_activities as $row): ?>
                <tr>
                    <td><strong><?= $row['user']; ?></strong></td>
                    <td>
                        <?php 
                            
                            $color = '#1cc88a';
                            if ($row['status'] == 'Proses') $color = '#f6c23e'; 
                            if ($row['status'] == 'Batal') $color = '#e74a3b';
                        ?>
                        <span class="badge" style="background: <?= $color; ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>
                    <td><?= $row['date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>