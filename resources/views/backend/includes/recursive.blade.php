@foreach($subcategories as $subcategory)
    @if($edit && (isset($category) && $subcategory['id']==$model->id)) @continue @endif
    <option value="{{ $subcategory['id'] }}" {{ $edit &&  $subcategory['id']==$model->id ? 'selected' : '' }}>
        @if($subcategory['parent_id'] !== 0)
            ╚═
            @if($loop->depth>1)
                @for($i=2;$i<$loop->depth;$i++)
                    ═
                @endfor
            @endif
        @endif
        {{ $subcategory['transname'] }}
    </option>
    @if(count($subcategory->children))
        @include('backend.includes.recursive',['subcategories' => $subcategory->children,'model'=>$model])
    @endif
@endforeach
