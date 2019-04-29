
<div class="form-group row">
    <label class="col-md-{{$col_a ?? '4'}} col-form-label" for="hf-email">{{$label}}</label>
    <div class="col-md-{{$col_b ?? '8'}}">
        <input class="form-control {{$class ?? ''}}" id="{{$name}}" type="text" name="{{$name}}" placeholder="">
    </div>
</div>


@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
