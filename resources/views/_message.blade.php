<div class="clear-both"></div>

@if(!empty(session('success')))
  <div class="alert alert-success " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('success') !!}
  </div>
@endif

@if(!empty(session('error')))
  

  <div class="alert alert-danger " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('error') !!}
  </div>
@endif

@if(!empty(session('payment-error')))
  <div class="alert alert-danger " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('payment-error') !!}
  </div>
@endif

@if(!empty(session('warning')))
  <div class="alert alert-warning " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('warning') !!}
  </div>
@endif

@if(!empty(session('info')))
  <div class="alert alert-info " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('info') !!}
  </div>
@endif

@if(!empty(session('secondary')))
  <div class="alert alert-secondary " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('secondary') !!}
  </div>
@endif

@if(!empty(session('primary')))
  <div class="alert alert-primary " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('primary') !!}
  </div>
@endif

@if(!empty(session('light')))
  <div class="alert alert-light " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('light') !!}
  </div>
@endif

@if(!empty(session('dark')))
  <div class="alert alert-dark " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! session('dark') !!}
  </div>
@endif
