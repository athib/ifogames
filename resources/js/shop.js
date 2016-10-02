var filters = { 'platform' : [], 'genre' : []};

$(function() {
    var allProducts = $('.product-holder');
    
    $('.filter-item').each(function() {
        $(this).on('click', function() {
            var filterType = $(this).attr('filter-type');
            var filterName = $(this).text();

            keepOnly(filterType, filterName, allProducts);
            addFilter(filterType, filterName);
        })
    });

    $('#remove-filters span').on('click', function(e) {
        filters = { 'platform' : [], 'genre' : []};
        $('#applied-filters span').each(function() {
            $(this).trigger(e);
        });
    });

    $('.btn-add-cart').on('click', function(e) {
        e.preventDefault();
        var idGame = $(this).closest('.product-item').find('.id-game').attr('value');
        var idPlatform = $(this).closest('.product-item').find('select.platform-select').val();

        if (idPlatform == null) {
            popup('warning', 'Vous devez choisir une plateforme avant d\'ajouter au panier', 'Action impossible');
            return;
        }

        $.ajax({
            url: '/ifogames/fr/shop/cart/add',
            type: 'POST',
            dataType: 'json',
            data: { 'idGame': idGame, 'idPlatform': idPlatform },
            success: function(data, status, xhr) {
                if (data.nostock) {
                    popup('danger', 'Désolé, ce produit est en rupture de stock. Revenez plus tard.', 'Action impossible');
                    return;
                }
                if (!data.addingOK) {
                    popup('warning', 'Ce produit est déjà dans votre panier.', 'Action impossible');
                    return;
                }
                var htmlItem = getHtmlProductItem(
                    data.gameInfos.jacket,
                    data.gameInfos.title,
                    data.gameInfos.idGame,
                    data.gameInfos.price,
                    data.platform.id,
                    data.platform.name
                );
                htmlItem.on('click', addRemoveEvent);
                $('#cart-items').append(htmlItem);

                updateMiniCartDisplay(data.cartProducts, data.gameInfos.cartTotal);
                addRemoveEvent();
                popup('success', 'Le produit a bien été ajouté au panier');
            },
            error: function(xhr, status, error) {}
        });
    });

    $('.empty-cart').on('click', function(event) {
        event.stopImmediatePropagation();
        updateMiniCartDisplay(0, 0);
        $('.items-holder .cart-item').remove();
        $('.items-holder .cart-labels').remove();
        $.ajax({
            url: '/ifogames/fr/shop/cart/empty'
        });
        popup('success', 'Votre panier a bien été vidé.')
    });

    addRemoveEvent();

    $('select.platform-select').on('change', function (event) {
        var thisProductItem = $(this).closest('.product-item');
        var stock = $('option:selected', this).attr('stock');
        
        thisProductItem.find('.product-stock span').html(stock);
        thisProductItem.find('.product-stock').show();
    });
});


// AFFICHAGE DU MODAL INFOS
$('#modal-infos').on('show.bs.modal', function (event) {
    $(event.relatedTarget).one('focus', function() { $(this).blur(); });

    var id = $(event.relatedTarget).data('id');
    var route = $(event.relatedTarget).data('route');
    route = route.replace('-', '/');

    $.ajax({
        url: '/ifogames/fr/shop/'+route,
        dataType: 'json',
        type: 'POST',
        data: { 'id': id },
        success: function(data, status, xhr) {
            $('#modal-infos .modal-title').html(data.title);
            $('#modal-infos .modal-body').html(data.body);
        }
    });
})



function updateMiniCartDisplay(nbProducts, cartPrice) {
    if (nbProducts > 0) {
        $('.no-products').hide();
        $('.empty-cart').show();
        $('.mini-cart-total').show();
    } else {
        $('#mini-cart #cart-items').html('');
        $('#mini-cart .mini-cart-total').hide();
        $('.empty-cart').hide();
        $('.no-products').show();
    }
    $('#nb-cart-products').html(nbProducts);
    $('.mini-cart-total .subtotal span').html(cartPrice);
}

function keepOnly(dataType, dataName, context) {
    context.each(function() {
        if ($(this).attr(dataType).indexOf(dataName) == -1) {
            $(this).hide();
        }
    });
};

function unHide(filters) {
    console.log(filters);
    var maskedElems = $('.product-holder:hidden');

    maskedElems.each(function() {
        var bool = true;
        for (var type in filters) {
            for (var value in filters[type]) {
                if ($(this).attr(type).indexOf(filters[type][value]) == -1) {
                    bool = false;
                }
            }
        }
        if (bool) {
            $(this).show();
        }
    });
};

function hasFilters(filters) {
    var bool = false;
    for (var type in filters) {
        if (filters[type].length > 0) {
            bool = true;
            break;
        }
    }

    return bool;
};

function addFilter(type, name) {
    if (!hasFilters(filters)) {
        $('#remove-filters').show();
    }
    filters[type].push(name);

    $('li.filter-item[filter-type="'+type+'"][value="'+name+'"]').hide();

    var newSpan = $('<span class="filter" filter-type="'+type+'" value="'+name+'">'+name+'</span>');
    newSpan.appendTo($('#applied-filters'));

    newSpan.on('click', function() {
        removeFilter($(this));
    });
};

function removeFilter(elem) {
    var dataType = elem.attr('filter-type');
    var dataName = elem.attr('value');

    $('li.filter-item[filter-type="'+ dataType +'"][value="'+ dataName +'"]').show();

    var pos = filters[dataType].indexOf(dataName);
    if (pos != -1) {
        filters[dataType].splice(pos, 1);
    }

    if (!hasFilters()) {
        $('#remove-filters').hide();
    }

    unHide(filters);

    elem.remove();
}

function addRemoveEvent() {
    $('span.minicart-remove-item').on('click', function(event) {
        event.stopImmediatePropagation();
        event.stopPropagation();

        var idGame = $(this).closest('.cart-item').find('.id-game').attr('value');
        var idPlatform = $(this).closest('.cart-item').find('.id-platform').attr('value');

        $('.cart-item').each(function(){
            var thisIdGame = $('.id-game', this).attr('value');
            var thisIdPlatform = $('.id-platform', this).attr('value');

            if (thisIdGame == idGame && thisIdPlatform == idPlatform) {
                $(this).remove();
            }
        });
        $.ajax({
            url: '/ifogames/fr/shop/cart/remove',
            type: 'POST',
            dataType: 'json',
            data: {'idGame': idGame, 'idPlatform': idPlatform },
            success: function(data, status, xhr) {
                updateMiniCartDisplay(data.cartProducts, data.cartPrice);
                popup('success', 'Le produit a bien été retiré du panier.');
            }
        });
    });
}

function getHtmlProductItem(img, title, idGame, price, idPlatform, namePlatform) {
    return $('\<li class="row cart-item">\
            <div class="product-thumb col-md-4">\
            <img src="'+ img +'" alt="'+ title +'" />\
            </div>\
            <div class="product-infos col-md-8">\
            <input type="hidden" class="id-game" value="'+ idGame +'">\
            <input type="hidden" class="id-platform" value="'+ idPlatform +'">\
            <h6 class="product-title">'+ title +'<br><small>'+ namePlatform +'</small></h6>\
        <div class="price">'+ price +' €</div>\
        <span class="minicart-remove-item glyphicon glyphicon-remove"></span>\
            </div>\
            </li>');
}