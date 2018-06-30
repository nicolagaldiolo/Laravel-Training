<div class="responseMessage"></div>

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Created date</th>
        <th>Update date</th>
        <th>Albums</th>
        <th>Action</th>
    </tr>
    @forelse($categories as $item)
        <tr id="item_{{$item->id}}">
            <td class="catName">{{$item->name}}</td>
            <td>{{$item->created_at->diffForHumans()}}</td>
            <td>{{$item->updated_at->diffForHumans()}}</td>
            <td>{{$item->album_count}}</td>
            <td>
                <a class="delete-category btn btn-danger btn-sm" data-id="item_{{$item->id}}"
                   href="{{route('categories.destroy', $item)}}">
                    <i class="far fa-trash-alt"></i>
                </a>
                <a class="update-category btn btn-primary btn-sm" data-id="item_{{$item->id}}"
                   href="{{route('categories.update', $item)}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No categories</td>
        </tr>
    @endforelse
</table>

<div>
    {{-- {{$images->links('vendor.pagination.bootstrap-4')}}
        || bootstrap-4 | default | semantic-ui | ecc
        posso specificare un determinato template per la paginazione, oppure usare quello standard
    --}} {{$categories->links()}}

</div>

<form id="categoryForm" action="{{route('categories.store')}}" method="post">
    <div class="form-row">
        <div class="col-8">
            @csrf
            <label class="sr-only" for="name">Category name</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="name" placeholder="New category" name="name">
        </div>
        <div class="col">
            <button type="submit" class="create-category btn btn-primary btn-block">Nuova categoria</button>
        </div>
    </div>
</form>