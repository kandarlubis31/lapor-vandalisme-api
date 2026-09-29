<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>body{font-family:sans-serif;display:flex;justify-content:center;align-items:center;height:100vh;background-color:#f9fafb;}form{background:white;padding:2rem;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.1);width:300px;}h2{text-align:center;color:#1f2937;margin-bottom:1.5rem;}div{margin-bottom:1rem;}label{display:block;margin-bottom:0.5rem;color:#374151;}input{width:100%;padding:0.5rem;border:1px solid #d1d5db;border-radius:4px;}button{width:100%;padding:0.75rem;border:none;border-radius:4px;background-color:#4f46e5;color:white;font-size:1rem;cursor:pointer;}p{color:red;font-size:0.875rem;}</style>
</head>
<body>
    <form method="POST" action="/admin/login">
        @csrf
        <h2>Admin Login</h2>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autofocus>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        @if ($errors->any())
            <div>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif
        <button type="submit">Login</button>
    </form>
</body>
</html>