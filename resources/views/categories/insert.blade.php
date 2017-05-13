<div id="new-category" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Categorie toevoegen</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('category.insert') }}" method="POST" class="form-horizontal" id="category">
                    <input type="hidden" name="_token"    value="{{ csrf_token() }}">
                    <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="module"    value="news">

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}"> {{-- Name form-group --}}
                        <label class="control-label col-md-3">Naam: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Naam van het label" name="name">
                        </div>
                    </div> {{-- /Name form-group --}}

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}"> {{-- Description form-group --}}
                        <label class="control-label col-md-3">Beschrijving: <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <textarea name="description" placeholder="Beschrijving van het label." class="form-control" rows="8"></textarea>
                        </div>
                    </div> {{-- /description form-group --}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="category" class="btn btn-success"><span class="fa fa-check"></span> Toevoegen</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close" aria-hidden="true"></span> Sluiten</button>
            </div>
        </div>

    </div>
</div>