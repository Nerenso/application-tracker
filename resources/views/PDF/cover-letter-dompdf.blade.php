<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') . ' | Cover Letter ' . $jobListing->page_title }}</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">

  <!-- Scripts -->
  @vite('resources/css/app.css')

</head>

<body class="font-coverLetter antialiased">
  <div style="white-space: pre-wrap; word-wrap: break-word; font-family:'Calibri', 'Trebuchet MS', sans-serif; line-height: 1.25rem; font-size: small;">{{ $coverLetter }}</div>
</body>

</html>
