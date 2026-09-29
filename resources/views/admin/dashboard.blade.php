@extends('admin.layout')

@section('title', 'Dashboard Laporan')

@section('content')
    <div class="dashboard-header">
        <h2>Laporan Pending</h2>
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $reports->count() }}</div>
                    <div class="stat-label">Laporan Pending</div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table id="reports-table" class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Pelapor</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr id="report-row-{{ $report->id }}" class="report-row">
                        <td><span class="report-id">#{{ $report->id }}</span></td>
                        <td><strong>{{ $report->title }}</strong></td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span>{{ $report->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $report->media_url) }}" target="_blank" class="evidence-link">
                                <img src="{{ asset('storage/' . $report->media_url) }}" alt="Bukti Laporan" class="evidence-img">
                                <div class="view-evidence">
                                    <i class="fas fa-search-plus"></i> Lihat Bukti
                                </div>
                            </a>
                        </td>
                        <td class="actions">
                            <button class="btn-validate" data-id="{{ $report->id }}">
                                <i class="fas fa-check"></i> Validasi
                            </button>
                            <button class="btn-reject" data-id="{{ $report->id }}">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Tidak ada laporan pending saat ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
<style>
    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .dashboard-header h2 {
        color: var(--gray-900);
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .dashboard-header h2::before {
        content: "";
        display: inline-block;
        width: 4px;
        height: 24px;
        background-color: var(--primary-color);
        margin-right: 0.75rem;
        border-radius: 2px;
    }
    
    /* Stats Card */
    .dashboard-stats {
        display: flex;
        gap: 1rem;
    }
    
    .stat-card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: var(--shadow);
        padding: 1rem;
        display: flex;
        align-items: center;
        min-width: 200px;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.375rem;
        background-color: rgba(79, 70, 229, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .stat-icon i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: var(--gray-600);
    }
    
    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .report-row {
        transition: all 0.3s ease;
    }
    
    .report-row:hover {
        background-color: var(--gray-50);
    }
    
    .report-row.processing {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }
    
    .report-row.processing::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 1;
    }
    
    .report-id {
        display: inline-block;
        background-color: var(--gray-100);
        color: var(--gray-700);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    
    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-avatar {
        margin-right: 0.5rem;
        color: var(--gray-400);
        font-size: 1.25rem;
    }
    
    /* Evidence Image */
    .evidence-link {
        position: relative;
        display: block;
        width: 100px;
        height: 100px;
        border-radius: 0.375rem;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    
    .evidence-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .evidence-link:hover .evidence-img {
        transform: scale(1.05);
    }
    
    .view-evidence {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.25rem;
        font-size: 0.75rem;
        text-align: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .evidence-link:hover .view-evidence {
        opacity: 1;
    }
    
    /* Action Buttons */
    .actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-validate, .btn-reject {
        padding: 0.5rem 0.75rem;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        font-weight: 500;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    
    .btn-validate {
        background-color: var(--success-color);
        color: white;
    }
    
    .btn-validate:hover {
        background-color: var(--success-hover);
    }
    
    .btn-reject {
        background-color: var(--danger-color);
        color: white;
    }
    
    .btn-reject:hover {
        background-color: var(--danger-hover);
    }
    
    .btn-validate i, .btn-reject i {
        margin-right: 0.375rem;
    }
    
    /* Empty State */
    .no-data {
        padding: 3rem !important;
        text-align: center;
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--gray-500);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .dashboard-stats {
            width: 100%;
        }
        
        .stat-card {
            flex: 1;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .data-table {
            min-width: 600px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const handleValidation = async (reportId, newStatus, buttonElement) => {
            const row = document.getElementById(`report-row-${reportId}`);
            row.classList.add('processing');
            
            // Tambahkan indikator loading pada tombol
            const originalContent = buttonElement.innerHTML;
            buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            buttonElement.disabled = true;

            try {
                const response = await fetch(`/api/admin/reports/${reportId}/validate`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal memproses laporan.');
                }
                
                const responseData = await response.json();
                
                // Tampilkan notifikasi sukses
                showNotification(responseData.message || `Laporan #${reportId} berhasil di-${newStatus}.`, 'success');
                
                // Animasi fade out sebelum menghapus baris
                row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                
                setTimeout(() => {
                    row.remove();
                    
                    // Periksa apakah masih ada baris tersisa
                    const remainingRows = document.querySelectorAll('.report-row');
                    if (remainingRows.length === 0) {
                        location.reload(); // Reload jika tidak ada data lagi
                    }
                }, 500);
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan: ' + error.message, 'error');
                
                // Kembalikan tombol ke keadaan semula
                buttonElement.innerHTML = originalContent;
                buttonElement.disabled = false;
                row.classList.remove('processing');
            }
        };

        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-icon">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                </div>
                <div class="notification-message">${message}</div>
            `;
            
            document.body.appendChild(notification);
            
            // Animasi muncul
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);
            
            // Hapus notifikasi setelah 5 detik
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }

        const table = document.getElementById('reports-table');

        table.addEventListener('click', function (event) {
            const target = event.target.closest('button');
            if (!target) return;
            
            const reportId = target.dataset.id;
            if (!reportId) return;

            if (target.classList.contains('btn-validate')) {
                if (confirm(`Yakin ingin validasi laporan #${reportId}? Poin akan ditambahkan.`)) {
                    handleValidation(reportId, 'valid', target);
                }
            }

            if (target.classList.contains('btn-reject')) {
                if (confirm(`Yakin ingin menolak laporan #${reportId}?`)) {
                    handleValidation(reportId, 'ditolak', target);
                }
            }
        });
    });
</script>
<style>
    /* Notifikasi Styles */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: var(--shadow-lg);
        padding: 1rem;
        display: flex;
        align-items: center;
        min-width: 300px;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        z-index: 1000;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification.success {
        border-left: 4px solid var(--success-color);
    }
    
    .notification.error {
        border-left: 4px solid var(--danger-color);
    }
    
    .notification-icon {
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    
    .notification.success .notification-icon {
        color: var(--success-color);
    }
    
    .notification.error .notification-icon {
        color: var(--danger-color);
    }
    
    .notification-message {
        flex: 1;
        font-weight: 500;
    }
</style>
@endpush