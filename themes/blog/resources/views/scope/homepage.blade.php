@php
// seo()->title(__('tools::seo.title.homepage')); 
@endphp
@extends(themeLayout())
@section('content')
    [tools::search-box /]
    <div class="container">
        [tools::collection /]
        [tools::tool title="Top Tools By Rank" rank="1" /]
        [tools::category title="List Category"/]
    </div>
@endsection
