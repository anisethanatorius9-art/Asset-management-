<!DOCTYPE html>
<html>

<head>
   {{-- <title>Groups Export</title> --}}
</head>

<body>
   <div class="header">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

      <h1>Location Report</h1>
      <p class="text-center">Generated on {{ now()->format('d M Y') }}</p>
   </div>

   <table class="table">
      <thead>
         <tr>
            <th>#</th>
            <th>Name</th>
         </tr>
      </thead>

      <tbody>
         @foreach ($data as $location)
            <tr>
               <td>{{ $loop->iteration }}</td>
               <td>{{ $location->name }}</td>
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
