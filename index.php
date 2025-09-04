<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Graduación 🎓</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- ✅ Responsivo -->
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
    .carousel-item img,
    .carousel-item video {
      border-radius: 20px;
      object-fit: cover;
      width: 100%;
      max-height: 75vh; /* Se adapta a la pantalla */
    }
    .carousel-inner {
      padding: 10px;
    }
    .carousel-caption-custom {
      margin-top: 15px;
    }

    /* ✅ Mejorar textos y botones en pantallas pequeñas */
    @media (max-width: 576px) {
      h5 { font-size: 1.1rem; }
      p { font-size: 0.9rem; }
      .btn-lg {
        padding: 8px 14px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

<!-- Modal de error -->
<div class="modal fade" id="fileTooLargeModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Archivo demasiado grande</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        El archivo seleccionado excede el tamaño máximo permitido   
        Por favor selecciona un archivo más pequeño.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- Barra superior -->
<nav class="navbar p-3">
  <div class="container-fluid d-flex justify-content-between align-items-center">
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

      <div class="text-center my-3" id="upload-loading" style="display:none;">
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Subiendo...</span>
        </div>
        <p class="mt-2">Subiendo archivo, por favor espera...</p>
      </div>  

      <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="mb-3 px-3">
          <label>Nombre:</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3 px-3">
          <label>Descripción:</label>
          <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3 px-3">
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
      <div class="carousel-caption-custom">
          <h5><?= htmlspecialchars($row['nombre']) ?></h5>
          <p><?= htmlspecialchars($row['descripcion']) ?></p>
          <div class="d-flex justify-content-center gap-3 flex-wrap">
              <button class="btn btn-light btn-lg like-btn" data-id="<?= $row['id'] ?>">👍 
                <span id="like-<?= $row['id'] ?>"><?= $row['likes'] ?></span>
              </button>
              <button class="btn btn-danger btn-lg heart-btn" data-id="<?= $row['id'] ?>">❤️ 
                <span id="heart-<?= $row['id'] ?>"><?= $row['corazones'] ?></span>
              </button>
          </div>
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
document.addEventListener('DOMContentLoaded', function(){
    const form = document.querySelector('#uploadModal form');
    const spinner = document.getElementById('upload-loading');

    form.addEventListener('submit', function(e){
        const files = this.querySelector('input[type="file"]').files;
        const maxSize = 60 * 1024 * 1024; // 40MB
        let tooBig = false;

        for(let i=0; i<files.length; i++){
            if(files[i].size > maxSize){
                tooBig = true;
                break;
            }
        }

        if (tooBig) {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('fileTooLargeModal'));
            modal.show();
        } else {
            spinner.style.display = "block";
        }
    });

    // Likes y corazones
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
});
</script>
</body>
<?php if (isset($_GET['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
    <?= htmlspecialchars($_GET['error']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php elseif (isset($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    ✅ Archivo(s) subido(s) correctamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

</html>
