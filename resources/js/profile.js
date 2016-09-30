var tmpHtml;
//var editInfosBtn;
//var editBillingAddrBtn;
//var editMailingAddrBtn;


$(function() {
    editInfosBtn = $('button[name="profile-edit-infos"]');
    editBillingAddrBtn = $('button[name="profile-edit-billing-address"]');
    editMailingAddrBtn = $('button[name="profile-edit-mailing-address"]');

    editInfosBtn.on('click', function(event) {
        $(this).blur();
        var context = $('.profile-member');
        if (editInfosBtn.attr('action') == 'edit') {
            prepareInfosEdit(context, editInfosBtn);
        } else  {
            validateInfosChange(context, editInfosBtn);
        }
    });

    editBillingAddrBtn.on('click', function(event) {
        $(this).blur();
        var context = $('.profile-address .billing-address');
        if (editBillingAddrBtn.attr('action') == 'edit') {
            prepareAddressEdit(context, editBillingAddrBtn);
        } else  {
            validateAddressChange(context, editBillingAddrBtn);
        }
    });
    
    editMailingAddrBtn.on('click', function(event) {
        $(this).blur();
        var context = $('.profile-address .mailing-address');
        if (editMailingAddrBtn.attr('action') == 'edit') {
            prepareAddressEdit(context, editMailingAddrBtn);
        } else  {
            validateAddressChange(context, editMailingAddrBtn);
        }
    });
});


function prepareInfosEdit(context, editInfosBtn) {
    $.ajax({
        url: '/ifogames/fr/profile/editinfos',
        dataType: 'json',
        type: 'POST',
        data: { 'action': 'edit'},
        success: function(data, status, xhr) {
            tmpHtml = $('#profile-content .infos-editable').html();
            $('#profile-content .infos-editable').html(data.html);
            editInfosBtn.attr('action', 'validate');
            $('span', editInfosBtn).toggle();
            editInfosBtn.before(generateCancelInfosButton());
        },
        error: function(xhr, status, error) {
            alert('oops edit infos');
        }
    });
}

function prepareAddressEdit(context, button) {
    $.ajax({
        url: '/ifogames/fr/profile/editaddress',
        dataType: 'json',
        type: 'POST',
        data: { 
            'action': 'edit',
            'what': button.attr('name')
        },
        success: function(data, status, xhr) {
            var tmp = context.html();
            context.html(data.html);
            button.attr('action', 'validate');
            $('span', button).toggle();
            button.before(generateCancelAddressButton(context, button, tmp));
        },
        error: function(xhr, status, error) {
            alert('oops edit address');
        }
    });
}

function validateInfosChange(context, editInfosBtn) {
    $.ajax({
        url: '/ifogames/fr/profile/editinfos',
        dataType: 'json',
        type: 'POST',
        data: {
            'action': 'validate',
            'id': $('input:hidden[name="id"]').attr('value'),
            'username': $('input[name="username"]').val(),
            'firstname': $('input[name="firstname"]').val(),
            'lastname': $('input[name="lastname"]').val(),
            'email': $('input[name="email"]').val(),
            'phone': $('input[name="phone"]').val(),
        },
        success: function(data, status, xhr) {
            //console.log(data);
            //data = JSON.parse(data);
            //console.log(data);
            if (data.status == true) {
                $('#profile-content .infos-editable').html(getHtmlMemberInfos(data.member));
                $('#user-menu .welcome span.username').html(data.userMenu);
                editInfosBtn.attr('action', 'edit');
                $('span', editInfosBtn).toggle();
                context.closest('.profile-infos').find('button.cancel').remove();
            } else {
                //popup('danger', data.field + ' déjà utilisé');
                $('#profile-content .infos-editable').html(data.html);
            }
        },
        error: function(xhr, status, error) {
            alert('oops validate edit infos');
        }
    });
}

function validateAddressChange(context, button) {
    $.ajax({
        url: '/ifogames/fr/profile/editaddress',
        dataType: 'html',
        type: 'POST',
        data: {
            'action': 'validate',
            'what': button.attr('name'),
            'id' : $('input:hidden[name="id"]', context).attr('value'),
            'street': $('input[name="street"]', context).val(),
            'postalCode': $('input[name="postalCode"]', context).val(),
            'city': $('input[name="city"]', context).val()
        },
        success: function(data, status, xhr) {
            data = JSON.parse(data);
            if (data.status == true) {
                context.html(getHtmlAddressInfos(data.address));
                button.attr('action', 'edit');
                $('span', button).toggle();
                context.closest('.profile-address').find('button.cancel').remove();
            }
        },
        error: function(xhr, status, error) {
            alert('oops validate edit address');
        }
    });
}

function getHtmlMemberInfos(member) {
    var html = '';

    for (key in member) {
        html += '<p>' + key + ' : ' + member[key] + '</p>';
    }

    return html;
}

function getHtmlAddressInfos(address) {
    var html = '<p>';
    for (key in address) {
        html += address[key] + ' ';
    }

    return html + '</p>';
}

function generateCancelInfosButton() {
    var button = $('<button class="cancel btn btn-default my-btn-default pull-right">' +
        '<span class="glyphicon glyphicon-remove"></span></button>');

    button.on('click', function() {
        $('#profile-content .infos-editable').html(tmpHtml);
        editInfosBtn.attr('action', 'edit');
        $('span', editInfosBtn).toggle();
        $(this).remove();
    });

    return button;
}

function generateCancelAddressButton(context, button, oldHtml) {
    var cancelButton = $('<button class="cancel btn btn-default my-btn-default pull-right">' +
        '<span class="glyphicon glyphicon-remove"></span></button>');

    cancelButton.on('click', function() {
        context.html(oldHtml);
        button.attr('action', 'edit');
        $('span', button).toggle();
        $(this).remove();
    });

    return cancelButton;
}