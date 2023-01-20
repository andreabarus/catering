
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg " style="background-color:#F63440;">
  <div class="container-fluid mx-5">
    <a class="navbar-brand" href="#">
    <img src="{{('img/logotugasakhir.catering.png')}}" alt="" class="" style="width:28%;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home">Home</a>
        </li>
        <li class="nav-item dropdown">
        </li>
        <li class="nav-item dropdown text-end" style="margin-left: 914px;">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
      </ul>
        
    </div>
  </div>
</nav>
<div id="demo" class="carousel slide" data-bs-ride="carousel">

  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  </div>
  
  <!-- The slideshow/carousel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{('img/foto-4.webp')}}" alt="makanan" class="d-block" style="width:100%; height:565px;">
    </div>
    <div class="carousel-item">
      <img src="{{('img/foto-2.jpg')}}" alt="makanan" class="d-block" style="width:100%; height:565px;">
    </div>
    <div class="carousel-item">
      <img src="{{('img/foto-5.png')}}" alt="makanan" class="d-block" style="width:100%; height:565px;">
    </div>
  </div>
  
  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<div class="container mt-5">
  <h2 class="text-center mb-5">Produk Kami</h2>
  <div class="row">
        @foreach($produks as $produk)
        <div class="col-md-4 mt-2">
            <div class="card">
                <img src="{{url('uploads')}}/{{$produk->gambar }}" class="card-img-top" height="220" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $produk->nama_barang}}</h5>
                    <p class="card-text">
                        <strong> Harga :</strong> Rp. {{number_format ($produk->harga)}} <br>
                        <strong> Stok :</strong> {{ $produk->stok}} <br>
                        <hr>
                    </p>
                    <a href="{{url('pesan')}}/{{ $produk->id}}" class="btn btn-primary "><i class="fa fa-shopping-cart me-2"></i>Pesan</a>
                </div> 
            </div>
            
        </div>
        @endforeach
  </div>
</div>
</body>
</html>
