@extends('uccello::modules.default.index.main')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s7">
                        <div class="input-field col s12">
                            <input id="description" type="text">
                            <label for="description">
                                {{ uctrans('field.description', $module) }}
                            </label>
                        </div>
                    </div>
                    <div class="col s5">
                        <span class="timer">00:00:00</span>
                        <a class="waves-effect btn primary">{{ uctrans('button.start', $module) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection