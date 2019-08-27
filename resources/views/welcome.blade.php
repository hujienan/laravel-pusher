<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        <h1>Pusher Test</h1>
        <p>
            Try publishing an event to channel <code>my-channel</code>
            with event name <code>my-event</code>.
        </p>
    </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    let pusher = new Pusher("{{ env('MIX_PUSHER_APP_KEY') }}", {
      cluster: 'ap1',
      forceTLS: true
    });
    let channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });
    // window.Echo.listen('my-channel', 'my-event', function(data) {
    //   alert(JSON.stringify(data));
    // });
    
</script>
</body>