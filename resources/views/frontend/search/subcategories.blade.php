<div class="custom-control custom-checkbox searchFilter-checkbox mt-2 categoryList">
    <input type="checkbox" class="custom-control-input" id="category_{{$cat->id}}" name="categories[]" value="{{$cat->id}}" @if(isset($_GET['search']) && ($_GET['search'] == $cat->slug || $_GET['search'] == $cat->name) || $slug == $cat->slug) checked @endif
        @if (count($categoryId) > 0 && in_array($cat->id, $categoryId[0])) checked @endif>
        <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
            for="category_{{$cat->id}}">{{$cat->name}}</label>

        @php $newDashes = $dashes. '  ' @endphp
        @foreach ($cat->subs as $sub)
            @include('/frontend/search/subcategories', ['cat' => $sub, 'dashes' => $newDashes])
        @endforeach
</div>
