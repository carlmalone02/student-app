<!-- @dump($students) -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            width: 100%;
            height: 100%;
            padding: 0;
        }
        @page {
            size: A4 landscape; 
            margin: 20mm;
        }
        .certificate {
            border: 1px solid #000;
            padding: 20px;
            text-align: center;
            page-break-after: always;
        }
        .certificate h2 {
            font-size: 30px;
            margin-bottom: 20px;
        }
        .certificate p {
            font-size: 20px;
        }
        .certificate .student-name {
            font-weight: bold;
            font-size: 24px;
        }
        .pass{
            background-color:green;
            color:white;
        }
    </style>
</head>
<body>
    @foreach ($students as $student)
        <div class="certificate">
            <h2>Certificate of Recognition</h2>
            <p>is given to</p>
            <p class="student-name">{{ $student->name }}</p>
            <h3>Grade: {{ $student->grade }} </h3>
            <h2 class="pass">PASS</h2>
        </div>
    @endforeach
</body>
</html>
