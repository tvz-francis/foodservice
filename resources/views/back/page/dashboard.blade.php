@extends('back.backtemp.main')
@section('title', 'Dashboard')
@section('title_name', 'ダッシュボード')
@section('content')



@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.dashboard').addClass('active');
    });
</script>
@endsection