<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
           value="{{$user->name??old('name')}}" placeholder="Your name">
    @if ($errors->has('name'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{$user->email??old('email')}}"
           placeholder="Your email">
    @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <label for="role">Role</label>
    <select name="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">
        <option value="user"{{($user->role == 'user' || old('role') == 'user') ? 'selected' : ''}}>User</option>
        <option value="admin"{{($user->role == 'admin' || old('role') == 'admin') ? 'selected' : ''}}>Admin</option>
    </select>
    @if ($errors->has('role'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('role') }}</strong>
        </span>
    @endif
    <input type="hidden" name="id" value="{{$user->id}}"> <!-- il passaggio dell'id mi serve solo per validare la mail (vedi controllo validazione email) -->
</div>
<div class="form-group">
    <button class="btn btn-primary">Save</button>
</div>