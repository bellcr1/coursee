<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Online Course Certificate</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to bottom right, #eef2f7, #ffffff);
      padding: 40px;
    }
    .certificate {
      background: #fff;
      border: 12px double #0d47a1;
      padding: 60px;
      width: 1200px;
      height: 780px;
      margin: auto;
      box-shadow: 0 30px 50px rgba(0,0,0,0.2);
      position: relative;
      border-radius: 20px;
      aspect-ratio: 5 / 4;
    }
    .logo {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo img {
      height: 85px;
    }
    .qr-code {
      width: 85px;
    }
    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      text-align: center;
      color: #0d47a1;
      margin-top: 35px;
      text-transform: uppercase;
      letter-spacing: 1.2px;
    }
    .recipient {
      font-size: 22px;
      text-align: center;
      margin: 45px 0;
      line-height: 1.7;
      color: #333;
    }
    .recipient strong {
      font-size: 28px;
      color: #0b5394;
    }
    .info {
      text-align: center;
      font-size: 18px;
      margin-bottom: 30px;
      color: #444;
    }
    .hours {
      text-align: center;
      margin: 25px 0 30px 0;
      font-weight: bold;
      font-size: 18px;
      color: #ffffff;
      background: linear-gradient(to right, #1976d2, #0d47a1);
      padding: 14px 30px;
      border-radius: 12px;
      display: inline-block;
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    .divider {
      height: 1px;
      width: 85%;
      background: linear-gradient(to right, #0b5394, #1976d2);
      margin: 25px auto;
      border-radius: 5px;
    }
    .signature-block {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 20px;
    }
    .signature {
      text-align: center;
      font-size: 15px;
    }
    .signature img {
      height: 55px;
      margin-top: 6px;
    }
    .signature strong {
      display: block;
      font-weight: bold;
      margin-bottom: 4px;
      color: #1a1a1a;
    }
    .title-badge {
      display: block;
      margin: auto;
      width: fit-content;
      background-color: #0b5394;
      color: white;
      padding: 8px 20px;
      border-radius: 30px;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: bold;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    #pdf-button-container {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 999;
    }

    #pdf-button {
      background-color: #0d47a1;
      color: white;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 20px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      transition: background-color 0.3s ease;
    }

    #pdf-button:hover {
      background-color: #08306b;
    }
  </style>
</head>
<body>

  @php
    $coach = \App\Models\User::find($course->user_id);
    $category = \App\Models\Category::find($course->category);
  @endphp

  <div class="certificate" id="certificate">
    <div class="logo">
      <img src="{{ asset('home/assets/img/logo11.png') }}" alt="Institute Logo">
      {!! $qrCode !!}
    </div>

    <span class="title-badge">COURSE Certificate</span>
    <h1>{{ strtoupper($category->name) }} ({{ strtoupper($course->title) }}) CERTIFICATION</h1>

    <div class="recipient">
      This certifies that<br/>
      <strong>{{ $user->name }} {{ $user->lastname }}</strong><br/>
      has successfully completed the<br/>
      <strong>{{ strtoupper($category->name) }} ({{ strtoupper($course->title) }})</strong><br/>
      online professional training course.
    </div>

    <div class="info">
      including all online lessons, assessments, and practical activities<br/>
      conducted by Advensia Academy, the online learning platform.        
    </div>

    <div class="hours">
      ONLINE COURSE DURATION: {{ $course->duration }} HOURS
    </div>

    <div class="divider"></div>

    <div class="signature-block">
      <div class="signature">
        <strong>{{ strtoupper($coach->name.' '.$coach->lastname) }}</strong>
        <small>{{ $category->name }} Instructor</small>
      </div>
      <div class="signature">
        <img src="{{ asset('home/assets/img/logo1.png') }}" alt="Signature">
      </div>
      <div class="signature">
        <strong>{{ $courseUser->updated_at->format('Y-m-d') }}</strong>
        <small>Completion Date</small><br/>
        <strong>ID: {{ $verify }}</strong>
      </div>
    </div>
  </div>

  <div id="pdf-button-container">
    <button id="pdf-button" title="Download PDF">⬇</button>
  </div>

  {{-- html2pdf.js stable version --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

  {{-- PDF generation --}}
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const button = document.getElementById("pdf-button");
    
      button.addEventListener("click", function () {
        const element = document.getElementById("certificate");
        const rect = element.getBoundingClientRect();
        const width = 1345;
        const height = 924;
    
        const options = {
          margin: 0.5,
          filename: 'certificate_{{ $verify }}.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: {
            scale: 3,
            useCORS: true,
            windowWidth: width,
            windowHeight: height
          },
          jsPDF: {
            unit: 'px',
            format: [width, height],
            orientation: 'landscape'
          }
        };
    
        html2pdf().set(options).from(element).save();
      });
    });
    </script>
</body>
</html>
