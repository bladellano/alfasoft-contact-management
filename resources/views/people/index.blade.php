<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .actions {
            margin: 20px 0;
        }
        .btn {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .auth-info {
            text-align: right;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="auth-info">
        @auth
            Logged in as: <strong>{{ auth()->user()->email }}</strong>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
        @endauth
    </div>

    <h1>People</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="actions">
        @auth
            <a href="{{ route('people.create') }}" class="btn btn-primary">Add New Person</a>
        @endauth
    </div>

    <table>
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
            <tr>
                <td>
                    @if($person->avatar_url)
                        <img src="{{ $person->avatar_url }}" alt="Avatar" class="avatar">
                    @else
                        <div class="avatar" style="background-color: #ccc;"></div>
                    @endif
                </td>
                <td>{{ $person->name }}</td>
                <td>{{ $person->email }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('people.show', $person->id) }}" class="btn btn-secondary">View</a>
                        @auth
                            <a href="{{ route('people.edit', $person->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('people.destroy', $person->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this person?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endauth
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($people->isEmpty())
        <p>No people found.</p>
    @endif
</body>
</html>
