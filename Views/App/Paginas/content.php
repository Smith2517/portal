<?php
headerAdmin($data);
getModal('modalPaginas', $data);
?>
<!-- Editor de código fuente Ace -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>

<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i>
                <?= $data['page_title'] ?>
            </h1>
            <h3>Pagina | <?= $data['page_infoPagina']['p_nombre'] ?></h3>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/roles"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>
    <div>
        <form id="formContent" name="formContent">
            <input type="hidden" name="idPagina" id="idPagina" value="<?= $data['page_infoPagina']["id"] ?>">
            <!-- Editor de código fuente -->
            <div class="mb-3">
                <label for="editor" class="form-label">Contenido HTML</label>
                <div id="editor" style="height: 500px; width: 100%; border: 1px solid #ccc; font-size: 14px;"><?= htmlspecialchars($data['page_infoPagina']['p_contenido']) ?></div>
                <textarea id="hiddenEditor" name="editor" style="display: none;"><?= $data['page_infoPagina']['p_contenido'] ?></textarea>
            </div>
            <button id="btnActionForm" class="btn btn-primary mt-2" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
        </form>
    </div>
</main>

<script>
    // Inicializar el editor Ace
    var editor = ace.edit("editor", {
        maxLines: 30,
        theme: "ace/theme/clouds"
    });

    editor.getSession().setMode("ace/mode/html");

    // Sincronizar el contenido del editor Ace con el textarea oculto
    editor.getSession().on('change', function() {
        document.getElementById('hiddenEditor').value = editor.getValue();
    });

    // Sincronizar al cargar la página
    document.getElementById('hiddenEditor').value = editor.getValue();

    // Manejar el envío del formulario
    document.getElementById('formContent').addEventListener('submit', function(e) {
        e.preventDefault();

        // Asegurarse de que el valor esté sincronizado
        document.getElementById('hiddenEditor').value = editor.getValue();

        // Enviar el formulario
        var formData = new FormData(this);

        fetch('<?= base_url() ?>/paginas/saveContent', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status) {
                swal("Contenido!", data.msg, "success");
            } else {
                swal("Error!", data.msg, "error");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            swal("Error!", "Error de red al guardar", "error");
        });
    });
</script>

<?php footerAdmin($data); ?>

