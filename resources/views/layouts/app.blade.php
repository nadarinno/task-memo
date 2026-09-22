<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Memo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        nav {
            background: #1f2937;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a, nav button {
            color: white;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            margin-left: 15px;
        }

        .container {
            width: 85%;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 7px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button, .btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border-bottom: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<nav>
    <div>
        <strong>Task Memo</strong>
    </div>

    <div>
        @auth
            <span>{{ auth()->user()->name }}</span>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>