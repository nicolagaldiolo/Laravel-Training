<div class="form-group">
    <label>Album thumb</label>
    <input type="file" class="form-control" placeholder="Album thumb" name="album_thumb" value="{{$data->album_thumb}}">
    @if($data->album_thumb)
        <img width="300" src="{{asset($data->album_thumb)}}" alt="{{$data->album_name}}">
    @endif
</div>