@extends('layouts.app')

@section('content')
<div class="container">
  <div class="mb-4">
    <h1 class="display-5 fw-bold">Bienvenido a FrontJS Solutions</h1>
    <p class="lead text-secondary">
      Ofrecemos servicios de desarrollo web con tecnologías modernas como Vue.js y React.js.
    </p>
  </div>

  <div class="mb-4">
    <div class="card-body text-center">
      <img src="{{ asset('images/image-home.jpg') }}" class="img-fluid rounded" alt="Front-end Stack">
    </div>
  </div>

    <p class="text-center text-muted fs-5"> En <strong>FrontJS Solutions</strong> nos especializamos en el desarrollo de interfaces web modernas, 
        rápidas y escalables utilizando las tecnologías más potentes del ecosistema JavaScript. 
        Creamos sitios, aplicaciones y componentes personalizados con <strong>React.js</strong>, 
        <strong>Vue.js</strong> y frameworks complementarios como <strong>Next.js</strong> y 
        <strong>TypeScript</strong>, garantizando experiencias de usuario fluidas, seguras y optimizadas 
        para todos los dispositivos.  
        <br><br>
        Nuestro objetivo es transformar ideas en productos digitales de alto rendimiento, 
        combinando diseño, funcionalidad y código de calidad profesional.
    </p>

  <div class="text-center">
    <a href="{{ route('request.create') }}" class="btn btn-primary btn-lg">Solicitar un servicio</a>
  </div>
</div>
@endsection



