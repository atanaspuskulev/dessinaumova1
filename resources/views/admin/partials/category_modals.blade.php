<div class="modal fade" id="trashCategory" tabindex="-1" role="dialog" aria-labelledby="trashCategory"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trashCategory">{{ __('strings.archive_category_title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('strings.archive_category_question') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="trashCategoryAction();">{{ __('strings.archive') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="destroyCategory" tabindex="-1" role="dialog" aria-labelledby="destroyCategory"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destroyCategory">{{ __('strings.delete_category_title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('strings.delete_category_question') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="destoryCategoryAction();">{{ __('strings.delete') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="untrashCategory" tabindex="-1" role="dialog" aria-labelledby="untrashCategory"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="untrashCategory">{{ __('strings.restore_category_title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('strings.restore_category_question') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('strings.cancel') }}</button>
                <a class="btn btn-success" href="javascript:void(0);" onclick="restoreCategoryAction();">{{ __('strings.restore') }}</a>
            </div>
        </div>
    </div>
</div>
