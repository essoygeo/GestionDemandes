<script>
    (function ($) {
        var fileUploadCount = 0;

        $.fn.fileUpload = function () {
            return this.each(function () {
                var fileUploadDiv = $(this);
                var fileUploadId = `fileUpload-${++fileUploadCount}`;
                var uploadUrl = fileUploadDiv.data('url'); // URL Laravel stockée dans data-url

                var fileDivContent = `
                    <label for="${fileUploadId}" class="file-upload">
                        <div>
<!--                            <i class="material-icons-outlined"></i>-->
<!--                            <p></p>-->
<!--                            <span>OR</span>-->
                            <div>upload</div>
                        </div>
                        <input type="file" id="${fileUploadId}" name="files[]" multiple hidden />
                    </label>
                `;

                fileUploadDiv.html(fileDivContent).addClass("file-container");

                var table = null;
                var tableBody = null;
                var factureexistant = $('#factureexistant');


                function createTable() {
                    // Vérifie si le tableau a un thead
                    if (factureexistant.find('thead').length > 0) {
                        factureexistant.find('thead').remove(); // Supprime le thead
                    }

                    table = $(`
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                 <!--   <th>#</th>-->
                                   <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Nom</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Prévisualisation</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Taille</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Type</th>
                            <th class="text-primary-emphasis text-center align-middle" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    `);

                    tableBody = table.find("tbody");
                    fileUploadDiv.append(table);
                }

                function uploadFiles(files) {
                    let formData = new FormData();
                    $.each(files, function (i, file) {
                        formData.append('files[]', file);
                    });

                    const token = '{{csrf_token()}}';

                    return $.ajax({
                        url: uploadUrl,
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': token },
                        data: formData,
                        contentType: false,
                        processData: false
                    });
                }

                function handleFiles(files) {
                    if (!table) createTable();
                    // tableBody.empty();

                    if (files.length > 0) {
                        uploadFiles(files).done(function (response) {
                            console.log(response)
                            if (response.success && response.success.length > 0) {
                                $.each(response.success, function (index, data) {
                                    var fileSize = (data.filesize / 1024).toFixed(2) + " KB";
                                    var fileName = data.path_image.split('/').pop();
                                    var preview = `<img class="fullscreen" src="${data.path_image}" alt="${fileName}" height="30">`;
                                    //   <td>${index + 1}</td>
                                    var row = $(`
                                        <tr>

                                            <td class="text-center align-middle">${fileName}</td>
                                            <td class="text-center align-middle">${preview}</td>
                                            <td class="text-center align-middle">${fileSize}</td>
                                            <td class="text-center align-middle">image/*</td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="deleteBtn  btn btn-danger btn-sm" data-id="${data.id}">
                                                    <i class="fa fa-trash">delete</i>
                                                </button>
                                            </td>
                                        </tr>
                                    `);

                                    tableBody.append(row);
                                });

                                // Gérer suppression
                                tableBody.find(".deleteBtn").click(function () {
                                    const id = $(this).data('id');

                                    const row = $(this).closest("tr");
                                    const token = '{{csrf_token()}}';


                                    if (confirm("Voulez-vous vraiment supprimer cette facture ?")) {
                                        $.ajax({
                                            url: `/facture/${id}`,
                                            type: 'DELETE',
                                            headers: { 'X-CSRF-TOKEN': token },
                                            success: function () {
                                                row.remove();
                                                if (tableBody.find("tr").length === 0) {
                                                    // tableBody.append('<tr><td colspan="6" class="no-file">Aucun fichier sélectionné.</td></tr>');
                                                }
                                            },
                                            error: function () {
                                                alert("Erreur lors de la suppression.");
                                            }
                                        });
                                    }
                                });
                            }
                        }).fail(function () {
                            alert("Erreur lors de l’upload.");
                        });
                    }
                }

                fileUploadDiv.on({
                    dragover: function (e) {
                        e.preventDefault();
                        fileUploadDiv.toggleClass("dragover", e.type === "dragover");
                    },
                    drop: function (e) {
                        e.preventDefault();
                        fileUploadDiv.removeClass("dragover");
                        handleFiles(e.originalEvent.dataTransfer.files);
                    },
                });

                fileUploadDiv.find(`#${fileUploadId}`).change(function () {
                    handleFiles(this.files);
                });
            });
        };
    })(jQuery);


</script>
