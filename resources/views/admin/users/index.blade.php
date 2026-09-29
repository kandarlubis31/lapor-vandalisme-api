{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manage Users')

@section('content')
    <div class="page-header">
        <h2>Manage Users</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><span class="user-id">#{{ $user->id }}</span></td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span class="user-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'mentor' ? 'warning' : 'primary') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            <div class="points-container">
                                <i class="fas fa-coins"></i>
                                <span>{{ $user->points }}</span>
                            </div>
                        </td>
                        <td class="actions">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $users->links() }}
    </div>
@endsection

@push('styles')
<style>
    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .page-header h2 {
        color: var(--gray-900);
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .page-header h2::before {
        content: "";
        display: inline-block;
        width: 4px;
        height: 24px;
        background-color: var(--primary-color);
        margin-right: 0.75rem;
        border-radius: 2px;
    }
    
    /* Button Styles */
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .btn i {
        margin-right: 0.375rem;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
    }
    
    /* Alert Styles */
    .alert {
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: var(--shadow-sm);
    }
    
    .alert i {
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    
    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border-left: 4px solid var(--success-color);
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border-left: 4px solid var(--danger-color);
    }
    
    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table tr:hover {
        background-color: var(--gray-50);
    }
    
    .user-id {
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
        font-size: 1.5rem;
    }
    
    .user-name {
        font-weight: 500;
    }
    
    /* Badge Styles */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .badge-primary {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
    }
    
    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .badge-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }
    
    /* Points Container */
    .points-container {
        display: flex;
        align-items: center;
        font-weight: 500;
    }
    
    .points-container i {
        color: #f59e0b;
        margin-right: 0.375rem;
    }
    
    /* Action Buttons */
    .actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-edit, .btn-delete {
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    
    .btn-edit {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .btn-edit:hover {
        background-color: rgba(79, 70, 229, 0.2);
    }
    
    .btn-delete {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border: none;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background-color: rgba(239, 68, 68, 0.2);
    }
    
    .delete-form {
        display: inline;
    }
    
    /* Pagination */
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-radius: 0.375rem;
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    
    .pagination li {
        border-right: 1px solid var(--gray-200);
    }
    
    .pagination li:last-child {
        border-right: none;
    }
    
    .pagination a, .pagination span {
        display: block;
        padding: 0.5rem 0.75rem;
        color: var(--gray-700);
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .pagination a:hover {
        background-color: var(--gray-100);
    }
    
    .pagination .active span {
        background-color: var(--primary-color);
        color: white;
    }
    
    .pagination .disabled span {
        color: var(--gray-400);
        background-color: var(--gray-50);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .data-table {
            min-width: 700px;
        }
        
        .actions {
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Improve delete confirmation
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const userName = this.closest('tr').querySelector('.user-name').textContent;
                
                if (confirm(`Are you sure you want to delete the user "${userName}"? This action cannot be undone.`)) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush