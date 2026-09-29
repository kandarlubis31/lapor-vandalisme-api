{{-- resources/views/admin/users/edit.blade.php --}}
@extends('admin.layout')
@section('title', 'Edit User')
@section('content')
    <div class="form-header">
        <h2><i class="fas fa-user-edit"></i> Edit User: {{ $user->name }}</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="edit-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name"><i class="fas fa-user"></i> Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        
        <div class="form-group">
            <label for="role"><i class="fas fa-user-tag"></i> Role</label>
            <select id="role" name="role">
                <option value="user" @if(old('role', $user->role) == 'user') selected @endif>User</option>
                <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
            </select>
        </div>
        
        <div class="password-section">
            <p><i class="fas fa-info-circle"></i> Fill password only if you want to change it.</p>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> New Password</label>
                <input type="password" id="password" name="password">
            </div>
            
            <div class="form-group">
                <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
        </div>
        
        <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update User
            </button>
        </div>
    </form>
@endsection

@push('styles')
<style>
    .form-header {
        margin-bottom: 2rem;
    }
    
    .form-header h2 {
        color: var(--gray-900);
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .form-header h2 i {
        margin-right: 0.75rem;
        color: var(--primary-color);
    }
    
    .edit-form {
        max-width: 600px;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: var(--shadow);
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--gray-700);
    }
    
    .form-group label i {
        margin-right: 0.5rem;
        color: var(--gray-500);
    }
    
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--gray-300);
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }
    
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    .password-section {
        margin: 2rem 0;
        padding: 1.5rem;
        background-color: var(--gray-50);
        border-radius: 0.375rem;
        border-left: 4px solid var(--primary-color);
    }
    
    .password-section p {
        margin: 0 0 1rem 0;
        color: var(--gray-600);
        font-style: italic;
    }
    
    .password-section p i {
        margin-right: 0.5rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        font-size: 1rem;
    }
    
    .btn i {
        margin-right: 0.5rem;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
    }
    
    .btn-secondary {
        background-color: var(--gray-200);
        color: var(--gray-700);
    }
    
    .btn-secondary:hover {
        background-color: var(--gray-300);
    }
    
    .alert {
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        box-shadow: var(--shadow-sm);
    }
    
    .alert i {
        margin-right: 0.75rem;
        font-size: 1.25rem;
        margin-top: 0.25rem;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border-left: 4px solid var(--danger-color);
    }
    
    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .edit-form {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush