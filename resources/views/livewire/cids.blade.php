<div>
    @foreach($cids as $cid)
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" value="{{ $cid->cid }}"> 
            </div>
            <div class="col">
                <input type="text" class="form-control" value="{{ $cid->description }}" readonly> 
            </div>
        </div>
    @endforeach
</div>
