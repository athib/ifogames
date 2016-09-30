
$('table#data-table').tablesorter({ theme: 'blue' });

// LISTE DES MEMBRES
$('.loader-link.members').on('click', function(event) {
    event.preventDefault();
    $(this).blur();
    
    $.ajax({
        url: '/ifogames/fr/admin/member/list',
        success: function(data, status, xhr) {
            data = JSON.parse(data);
            $('#admin-content .table-wrapper').html(data.table);
            $('table#data-table').tablesorter({ theme: 'blue' });

            $('button.action-delete').on('click', function(event) {
                var row = $(this).closest('tr');
                var idMember = parseInt(row.find('td.id-member').attr('value'));

                row.remove();
                deleteMember(idMember);
            });
        }
    });
});

// LISTE DES COMMANDES
$('.loader-link.orders').on('click', function(event) {
    event.preventDefault();
    $(this).blur();

    $.ajax({
        url: '/ifogames/fr/admin/order/list',
        success: function(data, status, xhr) {
            data = JSON.parse(data);
            $('#admin-content .table-wrapper').html(data.table);
            $('table#data-table').tablesorter({ theme: 'blue' });
        }
    });
});

// LISTE DES JEUX
$('.loader-link.games').on('click', function(event) {
    event.preventDefault();
    $(this).blur();

    $.ajax({
        url: '/ifogames/fr/admin/game/list',
        success: function(data, status, xhr) {
            data = JSON.parse(data);
            $('#admin-content .table-wrapper').html(data.table);
            $('table#data-table').tablesorter({ theme: 'blue' });

            $('button.action-delete').on('click', function(event) {
                var row = $(this).closest('tr');
                var idGame = parseInt($(this).attr('data-id'));

                row.remove();
                deleteGame(idGame);
            });
        }
    });
});



// AFFICHAGE DU MODAL INFOS
$('#modal-infos').on('show.bs.modal', function (event) {
    $(event.relatedTarget).one('focus', function() { $(this).blur(); });

    var id = $(event.relatedTarget).data('id');
    var route = $(event.relatedTarget).data('route');
    route = route.replace('-', '/');

    $.ajax({
        url: '/ifogames/fr/admin/'+route,
        dataType: 'json',
        type: 'POST',
        data: { 'id': id },
        success: function(data, status, xhr) {
            $('#modal-infos .modal-title').html(data.title);
            $('#modal-infos .modal-body').html(data.body);
        }
    });
})

// AFFICHAGE DU MODAL EDIT
$('#modal-edit').on('show.bs.modal', function (event) {
    $(event.relatedTarget).one('focus', function() { $(this).blur(); });

    var id = $(event.relatedTarget).data('id');
    var route = $(event.relatedTarget).data('route');
    route = route.replace('-', '/');

    $.ajax({
        url: '/ifogames/fr/admin/'+route,
        dataType: 'json',
        type: 'POST',
        data: { 'id': id },
        success: function(data, status, xhr) {
            $('#modal-edit .modal-body').html(data.body);
            initDatePicker();
            $('.modal-edit-submit').on('click', function(event) {
                $(this).one('focus', function() { $(this).blur(); });
                saveGame();
            });
        }
    });
})

// FONCTIONS OUTILS

function deleteMember(id) {
    $.ajax({
        url: '/ifogames/fr/admin/member/delete',
        type: 'POST',
        data: { 'idMember': id },
        success: function(data, status, xhr) {
            popup('info', 'Le membre a bien été supprimé de la base de données');
        }
    });
}

function deleteGame(id) {
    $.ajax({
        url: '/ifogames/fr/admin/game/delete',
        type: 'POST',
        data: { 'idGame': id },
        success: function(data, status, xhr) {
            popup('info', 'Le jeu a bien été supprimé de la base de données');
        }
    });
}

function initDatePicker() {
    $('.datepicker').datepicker({
        dateFormat : 'yy-mm-dd',
        firstDay : 1,
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        changeYear: true
    });
}

function saveGame() {
    $('#form-add-game').submit();
    /*var form = $('#form-add-game');
    var id = form.find('input[name="id"]').attr('value');
    var title = form.find('input[name="title"]').val();
    var description = form.find('textarea[name="description"]').val();
    var editor = form.find('select[name="editor"]').val();
    var releaseDate = form.find('input[name="releaseDate"]').val();
    var price = form.find('input[name="price"]').val();
    var pegi = form.find('select[name="pegi"]').val();
    var genres = form.find('select[name="genres"]').val();
    var platforms = form.find('select[name="platforms"]').val();

    $.ajax({
        url: '/ifogames/fr/admin/game/add',
        type: 'POST',
        dataType: 'json',
        data: {
            'file': new FormData(form[0]),
            'save': true,
            'id': id,
            'title': title,
            'description': description,
            'editor': editor,
            'releaseDate': releaseDate,
            'price': price,
            'pegi': pegi,
            'genres': genres,
            'platforms': platforms,
        },
        success: function(data, status, xhr) {
            if (data.adding == true) {
                $('#modal-edit').modal('hide');
                $('.loader-link.games').trigger('click');
                popup('success', 'le jeu a bien été ajouté');
            } else {
                $('#modal-edit .modal-body').html(data.body);
            }
        },
        error: function(xhr, status, err) {}
    });*/
}