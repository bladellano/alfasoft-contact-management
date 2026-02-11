<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .contact-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        .detail-row {
            margin-bottom: 15px;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 150px;
        }
        .detail-value {
            color: #333;
        }
        .person-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
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

    <h1>Contact Details</h1>

    <div class="person-info">
        <span class="info-label">Person:</span>
        <a href="{{ route('people.show', $contact->person->id) }}">{{ $contact->person->name }}</a>
    </div>

    <div class="contact-details">
        <div class="detail-row">
            <span class="detail-label">Country:</span>
            <span class="detail-value">{{ $countryName }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Country Code:</span>
            <span class="detail-value">+{{ $contact->country_code }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Phone Number:</span>
            <span class="detail-value">{{ $contact->number }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Full Number:</span>
            <span class="detail-value">+{{ $contact->country_code }} {{ $contact->number }}</span>
        </div>
    </div>

    <div class="actions">
        @auth
            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-primary">Edit Contact</a>
            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Contact</button>
            </form>
        @endauth
        <a href="{{ route('people.show', $contact->person->id) }}" class="btn btn-secondary">Back to Person</a>
    </div>
</body>
</html>
