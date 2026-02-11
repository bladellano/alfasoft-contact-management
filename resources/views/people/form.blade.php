<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($person) ? 'Edit Person' : 'Add New Person' }}</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .btn {
            padding: 10px 20px;
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
        .actions {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h1>{{ isset($person) ? 'Edit Person' : 'Add New Person' }}</h1>

    <form action="{{ isset($person) ? route('people.update', $person->id) : route('people.store') }}" method="POST">
        @csrf
        @if(isset($person))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $person->name ?? '') }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $person->email ?? '') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($person) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('people.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</body>
</html>
