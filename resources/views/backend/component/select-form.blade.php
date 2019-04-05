<select class="form-control {{$class ?? ''}}" id="{{$name}}" name="{{$name}}">
    <option value="0">{{$msg_o ?? "Todos"}}</option>
    @foreach($lista as $item)
        @php
            $selected = '';
                if($elemento_editar){
                    $selected = ($item->id==$valor_seleccionado) ? 'selected="selected"':'';
                }else{
                    $selected = '';
                }

        @endphp
        <option value="{{$item->id}}" {{$selected}}>{{$item->nombre}}</option>
    @endforeach
</select>

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            @if(isset($enlazado) && $enlazado==true)
            jQuery('#{{$name}}').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                //bootbox.alert(id);
                 //jQuery('.alert-danger').hide();
                 jQuery.ajax({
                     url: "{{ $enlazado_ruta }}/"+id,
                    method: 'get',
                    success: function(data){
                        //console.log(data);
                        $("#{{$enlazado_destino}}").html("");
                        $("#{{$enlazado_destino}}").append('<option value="0">{{$msg_o ?? "Todos"}}</option>');
                        $.each(JSON.parse(data), function(id, name) {
                            $("#{{$enlazado_destino}}").append('<option value=' + name.id + '>' + name.nombre + '</option>');
                        });
                    }
                });
            });
            @endif
        });

    </script>
@endpush
