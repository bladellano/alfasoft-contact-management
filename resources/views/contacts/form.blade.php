<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($contact) ? 'Edit Contact' : 'Add New Contact' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        .person-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
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
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        select {
            background-color: white;
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
        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-container .select2-selection--single {
            height: 42px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <h1>{{ isset($contact) ? 'Edit Contact' : 'Add New Contact' }}</h1>

    <div class="person-info">
        <strong>For:</strong> {{ $person->name }} ({{ $person->email }})
    </div>

    <form action="{{ isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store') }}" method="POST">
        @csrf
        @if(isset($contact))
            @method('PUT')
        @endif

        <input type="hidden" name="person_id" value="{{ $person->id }}">

        <div class="form-group">
            <label for="country_code">Country</label>
            <select id="country_code" name="country_code" required>
                <option value="">Select a country</option>
                @foreach($countries as $country)
                    <option value="{{ $country['calling_code'] }}"
                        {{ old('country_code', $contact->country_code ?? '') == $country['calling_code'] ? 'selected' : '' }}>
                        {{ $country['display_name'] }}
                    </option>
                @endforeach
            </select>
            @error('country_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="number">Phone Number</label>
            <input type="text" id="number" name="number" value="{{ old('number', $contact->number ?? '') }}"
                   maxlength="9" pattern="[0-9]{9}" required>
            <div class="help-text">Must be exactly 9 digits</div>
            @error('number')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">{{ isset($contact) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('people.show', $person->id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#country_code').select2({
                placeholder: 'Select a country',
                allowClear: true
            });
        });
    </script>
</body>
</html>
