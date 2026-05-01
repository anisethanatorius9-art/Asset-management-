<!DOCTYPE html>
<html>

<head>
    {{-- <title>Groups Export</title> --}}
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

        <h1>Asset Report</h1>
        <p class="text-center">Generated on {{ now()->format('d M Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Serial</th>
                <th>Model</th>
                <th>Manufacturer</th>
                <th>Purchase date</th>
                <th>Purchase price</th>
                <th>Status</th>
                <th>Category</th>
                <th>Location</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$asset->serial_number}}</td>
                <td>{{$asset->model}}</td>
                <td>{{$asset->manufacturer}}</td>
                <td>{{$asset->purchase_date}}</td>
                <td>{{ $asset->purchase_price}}</td>
                <td>{{$asset->status}}</td>
                <td>{{$asset->category?->name}}</td>
                <td>{{$asset->location?->name}}</td>
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
