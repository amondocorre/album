<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Graduación 🎓</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #111;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background: linear-gradient(90deg, #000, #444);
    }
    .btn-grad {
      background: linear-gradient(45deg, gold, orange);
      border: none;
      color: #000;
      font-weight: bold;
    }
    .carousel-item img {
      border-radius: 20px;
      max-height: 1000px;
      object-fit: cover;
    }
    .carousel-item img,
    .carousel-item video {
      border-radius: 20px;
      object-fit: cover;
      max-height: 70vh; /* No más del 80% de la altura de la pantalla */
      width: 100%;      /* Que ocupe todo el ancho disponible */
    }

    @media (min-width: 768px) {
      .carousel-item img,
      .carousel-item video {
        width: 75%;     /* En pantallas medianas/grandes vuelve al estilo original */
      }
    }
  </style>
  <!-- Modal de error -->
<div class="modal fade" id="fileTooLargeModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Archivo demasiado grande</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        El archivo seleccionado excede el tamaño máximo permitido de 40MB. Por favor selecciona un archivo más pequeño.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>


</head>
<body>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.querySelector('#uploadModal form');
    form.addEventListener('submit', function(e){
        const files = this.querySelector('input[type="file"]').files;
        const maxSize = 40 * 1024 * 1024; // 40MB
        for(let i=0; i<files.length; i++){
            if(files[i].size > maxSize){
                e.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('fileTooLargeModal'));
                modal.show();
                break;
            }
        }
    });
});
</script>


<!-- Barra superior -->
<nav class="navbar p-3">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1 text-light">🎓 Álbum de Graduación de Iveth Chalco</span>
    <button class="btn btn-grad btn-lg px-4 py-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
  📤 Subir Foto/Video
</button>
  </div>
</nav>

<!-- Modal Subida -->
<div class="modal fade" id="uploadModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Subir Foto/Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Selecciona archivos (fotos o videos):</label>
                <input type="file" name="archivo[]" multiple class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-grad">Subir</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Carrusel inferior -->
<div id="carouselFotos" class="carousel slide mt-5" data-bs-ride="carousel">
  <div class="carousel-inner text-center">

   <?php
$res = $conn->query("SELECT * FROM media ORDER BY creado DESC LIMIT 15");
$active = "active";
while($row = $res->fetch_assoc()):
?>
<div class="carousel-item <?= $active ?>">
    <?php if($row['tipo']=="foto"): ?>
        <img src="<?= $row['cloudinary_url'] ?>" class="d-block mx-auto img-fluid">
    <?php else: ?>
        <video src="<?= $row['cloudinary_url'] ?>" controls class="d-block mx-auto img-fluid"></video>
    <?php endif; ?>
    <div class="mt-3">
        <h5><?= htmlspecialchars($row['nombre']) ?></h5>
        <p><?= htmlspecialchars($row['descripcion']) ?></p>
       <button class="btn btn-light btn-lg like-btn" data-id="<?= $row['id'] ?>">👍 <span id="like-<?= $row['id'] ?>"><?= $row['likes'] ?></span></button>
      <button class="btn btn-danger btn-lg heart-btn" data-id="<?= $row['id'] ?>">❤️ <span id="heart-<?= $row['id'] ?>"><?= $row['corazones'] ?></span></button>

    </div>
</div>
<?php 
    $active = ""; 
endwhile; 
?>



  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotos" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselFotos" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.like-btn').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    let id = btn.dataset.id;
    fetch("likes.php", {
      method:"POST",
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:"id="+id+"&tipo=like"
    }).then(r=>r.json()).then(data=>{
      document.getElementById("like-"+id).innerText = data.likes;
    });
  });
});
document.querySelectorAll('.heart-btn').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    let id = btn.dataset.id;
    fetch("likes.php", {
      method:"POST",
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:"id="+id+"&tipo=corazon"
    }).then(r=>r.json()).then(data=>{
      document.getElementById("heart-"+id).innerText = data.corazones;
    });
  });
});
</script>
</body>
</html>
