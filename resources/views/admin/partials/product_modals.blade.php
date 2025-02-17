<div class="modal fade" id="trashProduct" tabindex="-1" role="dialog" aria-labelledby="trashProduct"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trashProduct">{{ __('strings.archive_product_title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('strings.archive_product_question') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="trashProductAction();">{{ __('strings.archive') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="destroyProduct" tabindex="-1" role="dialog" aria-labelledby="destroyProduct"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destroyProduct">{{ __('strings.delete_product_title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('strings.delete_product_question') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="destoryProductAction();">{{ __('strings.delete') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="untrashProduct" tabindex="-1" role="dialog" aria-labelledby="untrashProduct"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="untrashProduct">{{ __('strings.restore_product_title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('strings.restore_product_question') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                <a class="btn btn-success" href="javascript:void(0);" onclick="restoreProductAction();">{{ __('strings.restore') }}</a>
            </div>
        </div>
    </div>
</div>
