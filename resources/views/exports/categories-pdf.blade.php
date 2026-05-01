<!DOCTYPE html>
<html>

<head>
    {{-- <title>Groups Export</title> --}}
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

        <h1>Category Report</h1>
        <p class="text-center">Generated on {{ now()->format('d M Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>code</th>
                <th>Description</th>
                <th>Active</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $category)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{$category->code}}</td>
                <td>{{$category->description}}</td>
                <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <htmlpagefooter name="footer">
        <div style="text-align:center; font-size:10px; color:#666;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. | Page {PAGENO} of {nb}
        </div>
    </htmlpagefooter>

    <sethtmlpagefooter name="footer" value="on" />

</body>

</html>
