<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificado</title>
  <style>
    @page {
        size: A4 landscape; /* Tamaño A4 en orientación horizontal */
        margin: 0; /* Márgenes de la página */
    }
    /* Diseño del certificado */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .certificate-container {
      width: 90%;
      height: 90%;
      padding: 50px;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      text-align: center;
      position: relative;
      border: 5px solid #3498DB;
    }

    /* Añadir el logo */
    .certificate-logo {
      position: absolute;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: auto;
      margin-bottom: 20px;
    }

    .certificate-header {
      font-size: 40px;
      font-weight: bold;
      margin-bottom: 30px;
      color: #2C3E50;
      text-transform: uppercase;
    }

    .certificate-title {
      font-size: 28px;
      font-weight: normal;
      margin: 20px 0;
      color: #3498DB;
      text-transform: uppercase;
    }

    .certificate-body {
      font-size: 20px;
      margin: 20px 0;
      color: #34495E;
      line-height: 1.6;
    }

    .certificate-recipient {
      font-size: 30px;
      font-weight: bold;
      margin-top: 20px;
      color: #2C3E50;
    }

    .certificate-footer {
      margin-top: 40px;
      font-size: 18px;
      color: #7F8C8D;
    }

    .signature {
      margin-top: 40px;
      font-size: 20px;
      font-style: italic;
      color: #2C3E50;
    }

    .date {
      font-size: 16px;
      color: #7F8C8D;
      margin-top: 10px;
      font-weight: bold;
    }

    /* Agregar líneas decorativas */
    .line {
      width: 50%;
      border-top: 2px solid #3498DB;
      margin: 20px auto;
    }
  </style>
</head>
<body>
  <div class="certificate-container">
    <!-- Logo (puedes agregarlo si tienes uno) -->
    <img src="path_to_logo.png" alt="Logo" class="certificate-logo">

    <div class="certificate-header">Certificado de Participación</div>
    
    <div class="certificate-title">Este Certificado se Otorga a</div>
    <div class="certificate-recipient"><b>{{$nick}}</b></div>

    <div class="line"></div> <!-- Línea decorativa -->

    <div class="certificate-title">Puntuación</div>
    <div class="certificate-recipient"><b>{{$totalPuntos}}</b> / {{$todasPreguntas}}</div>

    <div class="certificate-body">
      Por su destacada participación en el curso de Trading desde novato hasta experto Qhatu organizado por Matías Guerra.
    </div>

    <div class="line"></div> <!-- Línea decorativa -->

    <div class="certificate-footer">
      Dado en Quito, Ecuador, el {{$fecha}}.
    </div>

    <div class="signature">Firma: _________________________</div>

    <div class="date">Fecha: {{$fecha}}</div>
  </div>
</body>
</html>
