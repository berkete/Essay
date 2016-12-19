@extends('layouts.app')



@section('content')

    @if($items)

    <select id="userselect" name="userselect">
        <option>Select User</option>
        @foreach ($items as $user)
           {{ var_dump($user->id)}}
            <option value="{{ $user->id }}">{{ $user->card_holder}}</option>
        @endforeach
    </select>

    <select id="itemselect" name="itemselect">
        <option>Please choose user first</option>
    </select>




@endif

    @endsection

@section('script')
<script>
    jQuery(document).ready(function($){
        $('#userselect').change(function() {
            $.get("{{ url('myurl')}}", {option: $(this).val()}, function (data) {
                var item = $('#itemselect');
                item.empty();
                $.each(data, function (key, value) {
                    item.append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
            });
        });
    });
</script>
    @endsection