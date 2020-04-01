@extends('uccello::modules.default.list.main')

@section('extra-meta')
<meta name="start-tracker-url" content="{{ ucroute('clockify.tracker.start', $domain, $module) }}">
@endsection

@section('before-datatable-card')
<input type="hidden" id="last-tracker-date" value="{{ $tracker->date_start.' '.$tracker->time_start }}">

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s7">
                        <div class="input-field col s12">
                            <input id="description" type="text" value="{{ $tracker->description }}">
                            <label for="description">
                                {{ uctrans('field.description', $module) }}
                            </label>
                        </div>
                    </div>
                    <div class="col s5">
                        <span id="tracker-timer" class="timer">00:00:00</span>
                        <a class="waves-effect btn primary">{{ uctrans('button.start', $module) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-content')
<div id="trackerModal" class="modal">
    <div class="modal-content">
      <h4>Modal Header</h4>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s12">
              <textarea id="description" class="materialize-textarea"></textarea>
                <label for="description">{{ uctrans('field.description', $module) }}</label>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <a id="start-tracker" href="javascript:void(0)" class="modal-close waves-effect green btn">{{ uctrans('button.start', $module) }}</a>
    </div>
</div>
@endsection

@section('page-action-buttons')
    {{-- Create button --}}
    @if (Auth::user()->canCreate($domain, $module))
    <div id="page-action-buttons">
        <a href="#trackerModal" class="btn-floating btn-large waves-effect green modal-trigger" data-tooltip="{{ uctrans('button.new', $module) }}" data-position="top">
            <i class="material-icons">add</i>
        </a>
    </div>
    @endif
@endsection

@section('css')
    {!! Html::style(mix('css/app.css', 'vendor/sardoj/clockify')) !!}
@append

@section('script')
    {!! Html::script(mix('js/app.js', 'vendor/sardoj/clockify')) !!}
@append