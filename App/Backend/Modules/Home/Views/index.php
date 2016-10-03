<h1><?php echo $translator->get('section_title.admin.home'); ?></h1>

<div class="row">
    <div class="col-md-3">
        <div id="menu-admin" >
            <ul>
                <li><a href="#" class="loader-link members">liste membres</a></li>
                <li><a href="#" class="loader-link games">liste jeux</a></li>
                <li><a href="#" class="loader-link orders">liste commandes</a></li>
            </ul>
        </div>
    </div>
    <div id="admin-content" class="col-md-9">
        <div class="table-wrapper">
            <h2><?php echo $translator->get('admin.home.title'); ?></h2>
            <p><?php echo $translator->get('admin.home.welcome'); ?></p>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-infos" tabindex="-1" role="dialog" aria-labelledby="modalinfos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Détails d'un élément</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="modal-infos-submit btn btn-default my-btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edition</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="modal-edit-cancel btn btn-default my-btn-default" data-dismiss="modal">annul</button>
                <button type="button" class="modal-edit-submit btn btn-primary my-btn-primary" name="save">save</button>
            </div>
        </div>
    </div>
</div>