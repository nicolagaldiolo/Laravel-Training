<div class="form-group">
    <label>Photo thumb</label>
    <input type="file" class="form-control" placeholder="Photo thumb" name="img_path" value="{{$photo->img_path}}">
    @if($photo->img_path)
        <img width="300" src="{{asset($photo->img_path)}}" alt="{{$photo->name}}">
    @endif
</div>