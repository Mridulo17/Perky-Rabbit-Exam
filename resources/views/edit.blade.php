

<div class="my-5">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('update', [ $employee->id, app()->getLocale()]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-floating">
            <input class="form-control" name="name" type="text" value="{{ $employee->name }}"  />
            <label for="name">{{ __('Name') }}</label>
        </div>
        <br>

        <div class="form-floating">
            <input class="form-control" name="contact" type="text" value="{{ $employee->contact }}"  />
            <label>{{ __('Contact') }}</label>
        </div>
        <br>
        <div class="form-floating">
            <input class="form-control" name="email" type="email" value="{{ $employee->email }}"  />
            <label>{{ __('Email') }}</label>
        </div>
        <br>
        <div class="form-floating">
            <input type="date" name="date_of_birth" value="{{ $employee->date_of_birth }}">
            <label for="message">{{ __('dob') }}</label>
        </div>
        <br>
        <div class="form-floating">
            {{-- <input class="form-control" id="picture" name="picture" type="file"/> --}}
            <img src="{{asset($employee->picture_path)}}" width=60px; height=40px;>
            <input class="form-control" id="picture" name="picture" type="file"/>
            <input type="hidden" name="old_photo" value="{{ $employee->picture_path }}">
            <label for="phone">{{ __('Picture') }}</label>
        </div>
    
        <br />
        <!-- Submit Button-->
        <div class="form-group">
            <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">{{ __('Update') }}</button>
        </div>
    </form>
</div>