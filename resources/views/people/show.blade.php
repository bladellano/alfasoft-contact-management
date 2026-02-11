<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .person-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 100px;
        }
        .detail-value {
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
            border: none;
            cursor: pointer;
            font-size: 14px;
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
        }
        .btn-success {
            background-color: #28a745;
            color: white;
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
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .no-contacts {
            padding: 20px;
            text-align: center;
            color: #666;
            background-color: #f8f9fa;
            border-radius: 4px;
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

    <h1>Person Details</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="person-details">
        <div class="detail-row">
            <span class="detail-label">Name:</span>
            <span class="detail-value">{{ $person->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <span class="detail-value">{{ $person->email }}</span>
        </div>
    </div>

    <div class="actions">
        @auth
            <a href="{{ route('people.edit', $person->id) }}" class="btn btn-primary">Edit Person</a>
            <form action="{{ route('people.destroy', $person->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this person?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Person</button>
            </form>
        @endauth
        <a href="{{ route('people.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="section-header">
        <h2>Contacts</h2>
        @auth
            <a href="{{ route('contacts.create', ['person' => $person->id]) }}" class="btn btn-success">Add New Contact</a>
        @endauth
    </div>

    @if($person->contacts->isEmpty())
        <div class="no-contacts">
            <p>No contacts found for this person.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Country Code</th>
                    <th>Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($person->contacts as $contact)
                <tr>
                    <td>{{ $contact->country_code }}</td>
                    <td>{{ $contact->number }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-secondary">View</a>
                            @auth
                                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?')">
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
    @endif
</body>
</html>
