<div class="row">
    <div class="col-md-12">
        <form id="form-add-game" action="/ifogames/fr/admin/game/add" method="post" enctype="multipart/form-data">
            <?php echo $formGame; ?>
            <?php echo $formGenres; ?>
            <?php echo $formPlatforms; ?>
        </form>
    </div>
</div>

<script>
    $('#form-add-game').find('input[name="jacket"]').on('change', function (e) {
        var files = $(this)[0].files;

        if (files.length > 0) {
            var file = files[0],
                $image_preview = $('#image_preview');

            $image_preview.find('.thumbnail').removeClass('hidden');
            $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
            $image_preview.find('h4').html(file.name);
            $image_preview.find('.caption p:first').html(file.size +' bytes');
        }
    });
    
    $('#image_preview').find('button[type="button"]').on('click', function (e) {
        e.preventDefault();

        $('#form-add-game').find('input[name="jacket"]').val('');
        $('#image_preview').find('.thumbnail').addClass('hidden');
    });

    $('#form-add-game').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var formdata = (window.FormData) ? new FormData(form[0]) : null;
        formdata.append('save', 'save');
        formdata.append('myGenres', form.find('select[name="genres"]').val());
        formdata.append('myPlatforms', form.find('select[name="platforms"]').val());
        var data = (formdata !== null) ? formdata : form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(data, status, xhr) {
                if (data.adding == true) {
                    $('#modal-edit').modal('hide');
                    $('.loader-link.games').trigger('click');
                    popup('success', 'le jeu a bien été ajouté');
                } else {
                    $('#modal-edit .modal-body').html(data.body);
                    initDatePicker();
                }
            },
            error: function(xhr, status, err) {}
        });
    });
</script>