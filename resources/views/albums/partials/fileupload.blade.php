<div class="form-group">
    <label>Album thumb</label>
    <input type="file" class="form-control" placeholder="Album thumb" name="album_thumb" value="{{$album->album_thumb}}">
    @if($album->album_thumb)
        <img width="300" src="{{asset($album->album_thumb)}}" alt="{{$album->album_name}}">
    @endif
</div>