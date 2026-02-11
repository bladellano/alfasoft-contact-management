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
    </style>
</head>
<body>
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
        <a href="{{ route('people.edit', $person->id) }}" class="btn btn-primary">Edit Person</a>
        <form action="{{ route('people.destroy', $person->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this person?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Person</button>
        </form>
        <a href="{{ route('people.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="section-header">
        <h2>Contacts</h2>
        <a href="{{ route('contacts.create', ['person' => $person->id]) }}" class="btn btn-success">Add New Contact</a>
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
                            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
