<div class="modal fade" id="trashCategory" tabindex="-1" role="dialog" aria-labelledby="trashCategory"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trashCategory">Archive Category?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure you want to archive this category?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="trashCategoryAction();">Archive</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="destroyCategory" tabindex="-1" role="dialog" aria-labelledby="destroyCategory"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destroyCategory">Delete Category?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure you want to delete this category?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="destoryCategoryAction();">DELETE</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="untrashCategory" tabindex="-1" role="dialog" aria-labelledby="untrashCategory"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="untrashCategory">Restore Category?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure you want to restore this category?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:void(0);" onclick="restoreCategoryAction();">RESTORE</a>
            </div>
        </div>
    </div>
</div>
