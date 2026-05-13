<!--Modal view pdf-->
<div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="titleView">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <strong>Descripción</strong>
                    <p class="description text-justify" id="description"></p>
                </div>
                <embed class="container input-pdf" type="application/pdf" id="input-pdf" src="" style="height: 30rem;"></embed>
                <div class="container">
                    <p>En caso de que no se evidencie la previsualización del archivo, se sugiere emplear las siguientes opciones. <span class="text-danger">*</span></p>
                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <a href="http://" target="_blank" rel="noopener noreferrer" id="link-pdf" class="btn btn-primary" title="Ver en otra pestaña"><i class="fa-solid fa-square-arrow-up-right"></i> Ver</a>
                        <a href="http://" class="btn btn-secondary" id="link-donwload" data-url="" dat-name=""><i class="fa-solid fa-download" title="Descargar archivo"></i> Descargar</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p><span>Publicado por</span>&nbsp;&nbsp;<strong id="publicador">Yeison Danner</strong></p>
            </div>
        </div>
    </div>
</div>
<!--end-->