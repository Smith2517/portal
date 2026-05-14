<?php
headerAdmin($data);
getModal('modalPaginas', $data);
?>
<!-- TinyMCE WYSIWYG Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>

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
            
            <div class="mb-3">
                <label for="editor" class="form-label">Contenido de la Página</label>
                <!-- Contenedor del editor TinyMCE (debe ser un textarea) -->
                <textarea id="editor" name="editor" style="height: 600px; width: 100%; font-size: 16px; background: white;"><?= $data['page_infoPagina']['p_contenido'] ?></textarea>
            </div>
            <button id="btnActionForm" class="btn btn-primary mt-2" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar Contenido</span></button>
        </form>
    </div>
</main>

<script>
    // Inicializar TinyMCE
    tinymce.init({
        selector: '#editor',
        height: 700,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
        toolbar1: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        toolbar2: 'link image media upload_pdf | table | removeformat | fullscreen code',
        image_advtab: true,
        // Handler para subida nativa de imágenes arrastradas/seleccionadas
        images_upload_url: '<?= base_url() ?>/paginas/uploadImage',
        automatic_uploads: true,
        convert_urls: false, // Fundamental para evitar Error 404 en el Front-End
        // Opciones para convertir enlaces en botones
        link_class_list: [
            {title: 'Enlace Normal', value: ''},
            {title: 'Botón Principal (Azul)', value: 'btn btn-primary'},
            {title: 'Botón Secundario (Gris)', value: 'btn btn-secondary'},
            {title: 'Botón Éxito (Verde)', value: 'btn btn-success'},
            {title: 'Botón Peligro (Rojo)', value: 'btn btn-danger'}
        ],
        // Botón personalizado para subir e insertar un PDF
        setup: function (editor) {
            editor.ui.registry.addButton('upload_pdf', {
                icon: 'document-properties',
                tooltip: 'Subir e Insertar Visor de PDF',
                onAction: function (_) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'application/pdf');
                    input.click();

                    input.onchange = function() {
                        var file = input.files[0];
                        if (file) {
                            swal({
                                title: "Subiendo PDF...",
                                text: "Por favor espere mientras se transfiere el archivo.",
                                icon: "info",
                                buttons: false,
                                closeOnClickOutside: false
                            });

                            var formData = new FormData();
                            formData.append('file', file);

                            fetch('<?= base_url() ?>/paginas/uploadPdf', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(result => {
                                swal.close();
                                if(result.status) {
                                    // Insertar iframe con tamaño específico 950x400
                                    var iframeHtml = `<div style="text-align: center; padding: 20px 0;"><iframe src="${result.url}#view=FitH" width="950" height="600" style="border: none; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 100%;"></iframe></div><p><br></p>`;
                                    editor.insertContent(iframeHtml);
                                } else {
                                    swal("Error", result.msg, "error");
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                swal.close();
                                swal("Error", "Ocurrió un error al subir el PDF", "error");
                            });
                        }
                    };
                }
            });
        }
    });

    // Manejar el envío del formulario
    document.getElementById('formContent').addEventListener('submit', function(e) {
        e.preventDefault();

        // Forzar a TinyMCE a sincronizar su contenido con el textarea
        tinymce.triggerSave();

        var formData = new FormData(this);

        fetch('<?= base_url() ?>/paginas/saveContent', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status) {
                swal("¡Guardado!", data.msg, "success");
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

