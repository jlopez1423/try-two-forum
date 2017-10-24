@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a New Thread</div>

                    <div class="panel-body">

                        <form method="POST" action="/threads">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel_id">Choose a Channel:</label>
                                <select type="text" class="form-control" id="channel_id" name="channel_id" required>
                                    <option value="">Choose One...</option>
                                    @foreach( App\Channel::all() as $channel )
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea type="text" class="form-control" id="body" rows="8" name="body" required>{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if( count( $errors ) )

                                @foreach( $errors->all() as $error )

                                    <ul class="alert alert-danger">
                                        <li>{{ $error  }}</li>
                                    </ul>

                                @endforeach

                            @endif

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
