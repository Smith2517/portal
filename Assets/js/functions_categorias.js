var table;
var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
    loadTable();
    setTimeout(() => {
        openModalSave();
        openModalEditPhoto();
        ModalEdit();
        updateFile();
        updateEstadoAviso();
        save();
        delet();
        editar();
        loadIcon();
        divLoading.style.display = "none";
    }, 1000);
});
document.addEventListener("click", () => {
    delet();
    openModalSave();
    openModalEditPhoto();
    ModalEdit();
    updateEstadoAviso();

});
function loadTable() {
    table = $("#table").dataTable({
        aProcessing: true,
        aServerSide: true,
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla =(",
            sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            oAria: {
                sSortAscending:
                    ": Activar para ordenar la columna de manera ascendente",
                sSortDescending:
                    ": Activar para ordenar la columna de manera descendente",
            },
            buttons: {
                copy: "Copiar",
                colvis: "Visibilidad",
            },
        },
        ajax: {
            url: " " + base_url + "/Blog/getCategorias/",
            dataSrc: "",
        },
        columns: [
            { data: "cont" },
            { data: "c_Categoria" },
            { data: "link" },
            { data: "c_Estado" },
            { data: "acciones" },
        ],
        dom: "lBfrtip",
        buttons: [
            {
                extend: "copyHtml5",
                text: "<i class='far fa-copy'></i> Copiar",
                titleAttr: "Copiar",
                className: "btn btn-secondary",
            },
            {
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'></i> Excel",
                titleAttr: "Esportar a Excel",
                className: "btn btn-success",
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fas fa-file-pdf'></i> PDF",
                titleAttr: "Esportar a PDF",
                className: "btn btn-danger",
            },
            {
                extend: "csvHtml5",
                text: "<i class='fas fa-file-csv'></i> CSV",
                titleAttr: "Esportar a CSV",
                className: "btn btn-info",
            },
        ],
        resonsive: "true",
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],
        columnDefs: [
            {
                class: "col-1 text-center",
                targets: 0,
            },
            {
                class: "col-3",
                targets: 1,
            },
            {
                class: "col-4 text-justify",
                targets: 2,
            },
            {
                class: "col-1 text-center",
                targets: 3,
            },
            {
                class: "col-2 text-center",
                targets: 4,
            }
        ],
    });
}

function updateEstadoAviso() {
    const btnEstadoFooter = document.querySelectorAll(".btnEstatus");
    btnEstadoFooter.forEach((element) => {
        element.addEventListener("click", () => {
            let titulo = element.getAttribute("data-nombre");
            let id = element.getAttribute("data-id");
            let estado = element.getAttribute("data-estado");
            swal(
                {
                    title: "¿Estas seguro?",
                    text: "Desea cambiar el estado del aviso: " + titulo,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, cambiar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        let data = new FormData();
                        data.append("id", id);
                        data.append("estado", estado);
                        let encabezados = new Headers();
                        let config = {
                            method: "POST",
                            headers: encabezados,
                            mode: "cors",
                            cache: "no-cache",
                            body: data,
                        };
                        let url = base_url + "/Blog/estadoAviso";
                        try {
                            divLoading.style.display = "flex";
                            fetch(url, config)
                                .then((response) => response.json())
                                .then((response) => {
                                    if (response.status) {
                                        swal("Satisfactorio", response.msg, "success");
                                        divLoading.style.display = "none";
                                        table.api().ajax.reload();
                                    } else {
                                        divLoading.style.display = "none";
                                        swal("Ocurrio un error inesperado", response.msg, "error");
                                    }
                                });
                        } catch (error) {
                            console.error(error);
                        }
                    }
                }
            );
        });
    });
}

function save() {
    if (document.querySelector("#formSave")) {
        formSave = document.querySelector("#formSave");
        formSave.addEventListener("submit", (e) => {
            e.preventDefault();
            let data = new FormData(formSave);
            let encabezados = new Headers();
            let config = {
                method: "POST",
                headers: encabezados,
                mode: "cors",
                cache: "no-cache",
                body: data,
            };
            let url = base_url + "/Blog/saveCategoria";
            try {
                divLoading.style.display = "flex";
                fetch(url, config)
                    .then((response) => response.json())
                    .then((response) => {
                        if (response.status) {
                            swal("Satisfactorio", response.msg, "success");
                            formSave.reset();
                            divLoading.style.display = "none";
                            $("#modalSave").modal("hide");
                            table.api().ajax.reload();
                        } else {
                            divLoading.style.display = "none";
                            swal("Ocurrio un error inesperado", response.msg, "error");
                        }
                    });
            } catch (error) {
                divLoading.style.display = "none";

                console.error(error);
            }
        });
    }
}
function delet() {
    const arrbtnDelRol = document.querySelectorAll(".btnDel");
    arrbtnDelRol.forEach((element) => {
        element.addEventListener("click", () => {
            let nombre = element.getAttribute("data-nombre");
            let id = element.getAttribute("data-id");
            let file = element.getAttribute("data-file");
            swal(
                {
                    title: "¿Estas seguro?",
                    text: "Esta seguro de eliminar " + nombre,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, eliminar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        let data = new FormData();
                        data.append("id", id);
                        data.append("file", file);
                        let encabezados = new Headers();
                        let config = {
                            method: "POST",
                            headers: encabezados,
                            mode: "cors",
                            cache: "no-cache",
                            body: data,
                        };
                        let url = base_url + "/Blog/deleteCategoria";
                        try {
                            divLoading.style.display = "flex";
                            fetch(url, config)
                                .then((response) => response.json())
                                .then((response) => {
                                    if (response.status) {
                                        swal("Satisfactorio", response.msg, "success");
                                        divLoading.style.display = "none";
                                        table.api().ajax.reload();
                                    } else {
                                        divLoading.style.display = "none";
                                        swal("Ocurrio un error inesperado", response.msg, "error");
                                    }
                                });
                        } catch (error) {
                            console.error(error);
                        }
                    }
                }
            );
        });
    });
}
function editar() {
    if (document.querySelector("#formCatUpdate")) {
        formCatUpdate = document.querySelector("#formCatUpdate");
        formCatUpdate.addEventListener("submit", (e) => {
            e.preventDefault();
            let data = new FormData(formCatUpdate);
            let encabezados = new Headers();
            let config = {
                method: "POST",
                headers: encabezados,
                mode: "cors",
                cache: "no-cache",
                body: data,
            };
            let url = base_url + "/Blog/editCategoria";
            try {
                divLoading.style.display = "flex";
                fetch(url, config)
                    .then((response) => response.json())
                    .then((response) => {
                        if (response.status) {
                            swal("Satisfactorio", response.msg, "success");
                            formCatUpdate.reset();
                            divLoading.style.display = "none";
                            $("#modalEditCat").modal("hide");
                            table.api().ajax.reload();
                        } else {
                            divLoading.style.display = "none";
                            swal("Ocurrio un error inesperado", response.msg, "error");
                        }
                    });
            } catch (error) {
                console.error(error);
            }
        });
    }
}
function updateFile() {
    if (document.querySelector("#formUpdateFile")) {
        formUpdateFile = document.querySelector("#formUpdateFile");
        formUpdateFile.addEventListener("submit", (e) => {
            e.preventDefault();
            let data = new FormData(formUpdateFile);
            let encabezados = new Headers();
            let config = {
                method: "POST",
                headers: encabezados,
                mode: "cors",
                cache: "no-cache",
                body: data,
            };
            let url = base_url + "/Blog/editFileCategoria";
            try {
                divLoading.style.display = "flex";
                fetch(url, config)
                    .then((response) => response.json())
                    .then((response) => {
                        if (response.status) {
                            swal("Satisfactorio", response.msg, "success");
                            formUpdateFile.reset();
                            divLoading.style.display = "none";
                            $("#modalEditFile").modal("hide");
                            table.api().ajax.reload();
                        } else {
                            divLoading.style.display = "none";
                            swal("Ocurrio un error inesperado", response.msg, "error");
                        }
                    });
            } catch (error) {
                console.error(error);
            }
        });
    }
}

function openModalSave() {
    if (document.querySelector(".openmodal")) {
        const openmodal = document.querySelector(".openmodal");
        openmodal.addEventListener("click", () => {
            $("#modalSave").modal("show");
        });
    }
}
function ModalEdit() {
    if (document.querySelector(".btnEdit")) {
        const btnEdit = document.querySelectorAll(".btnEdit")
        btnEdit.forEach(element => {
            element.addEventListener("click", () => {
                document.querySelector("#id_Catupd").value = element.getAttribute("data-id");
                document.querySelector("#txtNombCat").value = element.getAttribute("data-nombre");
                document.querySelector("#txtDescCat").value = element.getAttribute("data-description");
                $("#modalEditCat").modal("show")
            })
        });
    }
}
function openModalEditPhoto() {
    const arrbtnEditPhoto = document.querySelectorAll(".btnEditFile");
    arrbtnEditPhoto.forEach((element) => {
        element.addEventListener("click", () => {
            document.querySelector("#ip_updFil").value = element.getAttribute("data-id");
            document.querySelector("#photoOld_updFil").value = element.getAttribute("data-image");
            document.querySelector("#photo_file").src = base_url + "/Assets/upload/images/" + element.getAttribute("data-image");
            $("#modalEditFile").modal("show");
        });
    });
}

function loadIcon() {
    let img = document.querySelector("#photo_file");
    let input = document.querySelector("#ImgArchivo");
    input.addEventListener("change", (e) => {
        if (input.files[0]) {
            img.src = URL.createObjectURL(input.files[0]);
        }
    });
}

