@if(count($errors) > 0)
    <div id="errors" class="alert alert-danger form-group" style="float: right;width: 100%">
        <ul class="float-right mb-0" style="width: 90%">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <a style="cursor: pointer;margin-left: 2%;float: left;width: 5%" onclick="closeError()">&times;</a>
    </div>

@endif

